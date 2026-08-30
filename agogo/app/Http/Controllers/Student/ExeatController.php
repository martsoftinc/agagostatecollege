<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exeat;
use Illuminate\Http\Request;

class ExeatController extends Controller
{
    /**
     * List all exeats for the logged-in student
     */
    public function index()
    {
        $student = auth()->user();

        $exeats = Exeat::with(['logger', 'approver'])
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(12);

        return view('student.exeats.index', compact('exeats', 'student'));
    }

    /**
     * Return a single exeat as JSON (for modal)
     */
    public function show(Exeat $exeat)
    {
        // Security: student can only view their own records
        if ($exeat->student_id !== auth()->id()) {
            abort(404);
        }

        $exeat->load(['logger', 'approver']);

        return response()->json([
            'id'                 => $exeat->id,
            'type'               => ucfirst($exeat->type),
            'destination'        => $exeat->destination,
            'reason'             => $exeat->reason,
            'status'             => ucfirst($exeat->status),
            'departure_at'       => $exeat->departure_at->format('d M Y, h:i A'),
            'expected_return_at' => $exeat->expected_return_at->format('d M Y, h:i A'),
            'actual_return_at'   => $exeat->actual_return_at
                                        ? $exeat->actual_return_at->format('d M Y, h:i A')
                                        : null,
            'guardian_contact'   => $exeat->guardian_contact,
            'notes'              => $exeat->notes,
            'logged_by'          => $exeat->logger?->name,
            'approved_by'        => $exeat->approver?->name,
            'created_at'         => $exeat->created_at->format('d M Y, h:i A'),
        ]);
    }
}