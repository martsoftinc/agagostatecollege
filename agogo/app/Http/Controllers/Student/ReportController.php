<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Semester;
use App\Models\AssessmentWeight;
use App\Models\Setting;
use App\Models\ReportPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $semesters = Semester::with('academicYear')
            ->whereHas('scores', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->orderByDesc('id')
            ->get();

        // Get payment status for each semester
        $payments = ReportPayment::where('student_id', $student->id)
            ->where('status', 'success')
            ->pluck('semester_id')
            ->toArray();

        $reportFee = Setting::get('report_fee', 20.00);

        return view('student.reports.index', compact(
            'student', 'semesters', 'payments', 'reportFee'
        ));
    }

    public function show(Semester $semester)
    {
        $this->ensurePaid($semester);

        $student = Auth::user();
        $scores = Score::with('subject')
            ->where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->get();

        $totalPoints  = $scores->sum('grade_point');
        $subjectCount = $scores->whereNotNull('grade_point')->count();
        $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;
        $weights = AssessmentWeight::active();
        $subjectPositions = $this->calculateSubjectPositions($student, $semester, $scores);

        return view('student.reports.show', compact(
            'student', 'semester', 'scores', 'semesterGpa', 'weights', 'subjectPositions'
        ));
    }

    public function download(Semester $semester)
    {
        $this->ensurePaid($semester);

        $student = Auth::user();
        $scores = Score::with('subject')
            ->where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->get();

        $totalPoints  = $scores->sum('grade_point');
        $subjectCount = $scores->whereNotNull('grade_point')->count();
        $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;
        $weights = AssessmentWeight::active();
        $subjectPositions = $this->calculateSubjectPositions($student, $semester, $scores);

        $pdf = Pdf::loadView('student.reports.pdf', compact(
            'student', 'semester', 'scores', 'semesterGpa', 'weights', 'subjectPositions'
        ))->setPaper('a4');

        $filename = 'Terminal_Report_' . ($student->student_id ?? $student->id) . '_' . str_replace(' ', '_', $semester->name) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Initiate Paystack payment
     */
    public function pay(Semester $semester)
    {
        $student = Auth::user();
        $fee = (float) Setting::get('report_fee', 20.00);

        // Already paid?
        $alreadyPaid = ReportPayment::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->where('status', 'success')
            ->exists();

        if ($alreadyPaid) {
            return redirect()->route('student.reports.show', $semester)
                ->with('success', 'You have already paid for this report.');
        }

        $reference = 'RPT_' . $student->id . '_' . $semester->id . '_' . Str::upper(Str::random(10));

        // Create pending payment record
        ReportPayment::updateOrCreate(
            [
                'student_id'  => $student->id,
                'semester_id' => $semester->id,
            ],
            [
                'reference' => $reference,
                'amount'    => $fee,
                'currency'  => 'GHS',
                'status'    => 'pending',
            ]
        );

        $payload = [
            'email'        => $student->email,
            'amount'       => $fee * 100, // Paystack expects amount in kobo/pesewas
            'currency'     => 'GHS',
            'reference'    => $reference,
            'callback_url' => route('student.reports.callback'),
            'metadata'     => [
                'student_id'  => $student->id,
                'semester_id' => $semester->id,
                'custom_fields' => [
                    [
                        'display_name'  => 'Student Name',
                        'variable_name' => 'student_name',
                        'value'         => $student->full_name ?? $student->name,
                    ],
                    [
                        'display_name'  => 'Semester',
                        'variable_name' => 'semester',
                        'value'         => $semester->name,
                    ],
                ],
            ],
        ];

        // Use HTTPS always
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post('https://api.paystack.co/transaction/initialize', $payload);

        if (!$response->successful() || !$response->json('status')) {
            return redirect()->back()->with('error', 'Unable to initiate payment. Please try again.');
        }

        $authorizationUrl = $response->json('data.authorization_url');

        return redirect()->away($authorizationUrl);
    }

    /**
     * Paystack callback (after payment)
     */
    public function callback()
    {
        $reference = request('reference') ?? request('trxref');

        if (!$reference) {
            return redirect()->route('student.reports.index')
                ->with('error', 'Invalid payment reference.');
        }

        // Verify transaction with Paystack (HTTPS)
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->successful() || !$response->json('status')) {
            return redirect()->route('student.reports.index')
                ->with('error', 'Payment verification failed.');
        }

        $data = $response->json('data');

        if ($data['status'] !== 'success') {
            return redirect()->route('student.reports.index')
                ->with('error', 'Payment was not successful.');
        }

        $payment = ReportPayment::where('reference', $reference)->first();

        if (!$payment) {
            return redirect()->route('student.reports.index')
                ->with('error', 'Payment record not found.');
        }

        // Update payment
        $payment->update([
            'status'            => 'success',
            'channel'           => $data['channel'] ?? null,
            'paystack_response' => $data,
            'paid_at'           => now(),
        ]);

        return redirect()->route('student.reports.show', $payment->semester_id)
            ->with('success', 'Payment successful! You can now view your report.');
    }

    /**
     * Ensure student has paid before viewing/downloading
     */
    private function ensurePaid(Semester $semester): void
    {
        $student = Auth::user();

        $paid = ReportPayment::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->where('status', 'success')
            ->exists();

        if (!$paid) {
            abort(403, 'You must pay to access this report.');
            // Or redirect:
            // redirect()->route('student.reports.index')->with('error', 'Please pay to unlock this report.')->send();
        }
    }

    private function calculateSubjectPositions($student, $semester, $scores)
    {
        // ... keep your existing method exactly as it is
        $positions = [];
        foreach ($scores as $score) {
            if (is_null($score->total_score)) {
                $positions[$score->subject_id] = null;
                continue;
            }
            $allScores = Score::where('class_stream_id', $score->class_stream_id)
                ->where('subject_id', $score->subject_id)
                ->where('semester_id', $semester->id)
                ->whereNotNull('total_score')
                ->orderByDesc('total_score')
                ->get();
            $rank = 1;
            $previousScore = null;
            $actualPosition = 1;
            foreach ($allScores as $index => $s) {
                if ($previousScore !== null && $s->total_score < $previousScore) {
                    $rank = $index + 1;
                }
                if ($s->student_id === $student->id) {
                    $actualPosition = $rank;
                    break;
                }
                $previousScore = $s->total_score;
            }
            $totalStudents = $allScores->count();
            $positions[$score->subject_id] = $actualPosition . ' / ' . $totalStudents;
        }
        return $positions;
    }
}