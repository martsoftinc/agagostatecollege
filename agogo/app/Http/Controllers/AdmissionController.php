<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Services\MNotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdmissionController extends Controller
{
    protected $mnotify;

    public function __construct(MNotifyService $mnotify)
    {
        $this->mnotify = $mnotify;
    }

    /**
     * Show the admission form
     */
    public function index()
    {
        return view('admission.index');
    }

    /**
     * Store the admission form and initialize payment
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
        'passport_picture' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        'surname' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'gender' => 'required|in:male,female',
        'date_of_birth' => 'required|date|before:today',
        'place_of_birth' => 'nullable|string|max:255',
        'nationality' => 'required|string|max:255',
        'religion' => 'nullable|string|max:255',
        'home_town' => 'nullable|string|max:255',
        'parent_guardian_name' => 'required|string|max:255',
        'parent_guardian_phone' => 'required|string|max:20',
        'parent_guardian_email' => 'nullable|email|max:255',
        'relationship' => 'required|in:father,mother,guardian,other',
        'parent_guardian_occupation' => 'required|string|max:255',
        'address' => 'required|string',
        'place_of_residence' => 'required|string|max:255',
        'previous_school' => 'required|string|max:255',
        'index_number' => 'required|string|max:255',
        'bece_year' => 'nullable|string|max:10',
        'programme' => 'required|in:general_science,business,general_arts,visual_arts,home_economics,agricultural_science',
        'position_held' => 'nullable|string|max:255',
        'interests_hobbies' => 'nullable|string',
        'medical_conditions' => 'nullable|string',
        'declaration' => 'accepted',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store passport picture
    $passportPath = null;
    if ($request->hasFile('passport_picture')) {
        $passportPath = $request->file('passport_picture')->store('passports', 'public');
    }

    // Generate unique payment reference
    $reference = 'ADM-' . strtoupper(Str::random(10)) . '-' . time();

    $admission = Admission::create([
        'passport_picture' => $passportPath,
        'surname' => $request->surname,
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'gender' => $request->gender,
        'date_of_birth' => $request->date_of_birth,
        'place_of_birth' => $request->place_of_birth,
        'nationality' => $request->nationality,
        'religion' => $request->religion,
        'home_town' => $request->home_town,
        'parent_guardian_name' => $request->parent_guardian_name,
        'parent_guardian_phone' => $request->parent_guardian_phone,
        'parent_guardian_email' => $request->parent_guardian_email,
        'relationship' => $request->relationship,
        'parent_guardian_occupation' => $request->parent_guardian_occupation,
        'address' => $request->address,
        'place_of_residence' => $request->place_of_residence,
        'previous_school' => $request->previous_school,
        'index_number' => $request->index_number,
        'bece_year' => $request->bece_year,
        'programme' => $request->programme,
        'position_held' => $request->position_held,
        'interests_hobbies' => $request->interests_hobbies,
        'medical_conditions' => $request->medical_conditions,
        'amount_paid' => 30.00,
        'payment_reference' => $reference,
        'payment_status' => 'pending',
        'status' => 'pending',
    ]);

    try {
        $this->sendApplicationReceivedSms($admission);
    } catch (\Exception $e) {
        Log::warning('Application SMS failed but continuing', [
            'admission_id' => $admission->id,
            'error' => $e->getMessage(),
        ]);
    }

    return $this->initializePayment($admission);
    }

    /**
     * Initialize Paystack payment using Laravel HTTP Client
     */
    private function initializePayment($admission)
    {
        $paystackSecret = config('services.paystack.secret_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $paystackSecret,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $admission->email ?? 'admission@agogostate.edu',
                'amount' => $admission->amount_paid * 100,
                'reference' => $admission->payment_reference,
                'callback_url' => route('admission.verify-payment'),
                'metadata' => [
                    'admission_id' => $admission->id,
                    'applicant_name' => $admission->full_name,
                    'applicant_phone' => $admission->parent_guardian_phone,
                ]
            ]);

            if ($response->successful() && $response->json('status')) {
                $authorizationUrl = $response->json('data.authorization_url');
                
                // Send SMS with payment link (don't fail if SMS fails)
                try {
                    $this->sendPaymentLinkSms($admission, $authorizationUrl);
                } catch (\Exception $e) {
                    Log::warning('Payment link SMS failed but continuing', [
                        'admission_id' => $admission->id,
                        'error' => $e->getMessage()
                    ]);
                }
                
                return redirect($authorizationUrl);
            }

            Log::error('Paystack initialization failed', [
                'response' => $response->json(),
                'admission_id' => $admission->id
            ]);

            return redirect()->back()
                ->with('error', 'Payment initialization failed: ' . $response->json('message', 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('Paystack initialization exception', [
                'message' => $e->getMessage(),
                'admission_id' => $admission->id
            ]);

            return redirect()->back()
                ->with('error', 'Payment initialization failed. Please try again.');
        }
    }

    /**
     * Verify Paystack payment
     */
    public function verifyPayment(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect()->route('admission.index')
                ->with('error', 'Payment reference not found.');
        }

        $paystackSecret = config('services.paystack.secret_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $paystackSecret,
                'Cache-Control' => 'no-cache',
            ])->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('status')) {
                $data = $response->json('data');
                
                $admission = Admission::where('payment_reference', $reference)->first();
                
                if ($admission) {
                    $paymentStatus = ($data['status'] === 'success') ? 'paid' : 'failed';
                    
                    $admission->update([
                        'payment_status' => $paymentStatus,
                        'status' => 'pending'
                    ]);

                    if ($data['status'] === 'success') {
                        // Send SMS notifications - but don't fail if SMS fails
                        try {
                            $this->sendPaymentConfirmationSms($admission);
                        } catch (\Exception $e) {
                            Log::warning('Payment confirmation SMS failed', [
                                'admission_id' => $admission->id,
                                'error' => $e->getMessage()
                            ]);
                        }

                        try {
                            $this->sendAdminNotificationSms($admission);
                        } catch (\Exception $e) {
                            Log::warning('Admin notification SMS failed', [
                                'admission_id' => $admission->id,
                                'error' => $e->getMessage()
                            ]);
                        }
                        
                        // Always return success page regardless of SMS status
                        return view('admission.success', compact('admission'));
                    }
                }
            }

            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'response' => $response->json()
            ]);

            return redirect()->route('admission.index')
                ->with('error', 'Payment verification failed. Please contact support.');

        } catch (\Exception $e) {
            Log::error('Paystack verification exception', [
                'message' => $e->getMessage(),
                'reference' => $reference
            ]);

            return redirect()->route('admission.index')
                ->with('error', 'Payment verification failed. Please try again.');
        }
    }

    /**
     * Send SMS for application received
     */
    private function sendApplicationReceivedSms($admission)
    {
        $message = "Dear {$admission->full_name},\n\n";
        $message .= "Thank you for submitting your application to Agogo State College.\n";
        $message .= "Your Application Reference: {$admission->payment_reference}\n\n";
        $message .= "You will receive payment instructions shortly.\n";
        $message .= "Thank you for choosing Agogo State College.";

        return $this->mnotify->sendSms($admission->parent_guardian_phone, $message);
    }

    /**
     * Send SMS with payment link
     */
    private function sendPaymentLinkSms($admission, $paymentUrl)
    {
        $message = "Dear {$admission->full_name},\n\n";
        $message .= "Complete your admission application by paying GH₵ 30.00:\n";
        $message .= $paymentUrl . "\n\n";
        $message .= "Reference: {$admission->payment_reference}\n";
        $message .= "Valid for 24 hours.\n\n";
        $message .= "Agogo State College Admission Office";

        return $this->mnotify->sendSms($admission->parent_guardian_phone, $message);
    }

    /**
     * Send payment confirmation SMS
     */
    private function sendPaymentConfirmationSms($admission)
    {
        $message = "Dear {$admission->full_name},\n\n";
        $message .= "Payment confirmed! Your admission application is now complete.\n";
        $message .= "Reference: {$admission->payment_reference}\n\n";
        $message .= "We will review your application and contact you within 48 hours.\n";
        $message .= "Thank you for choosing Agogo State College.";

        return $this->mnotify->sendSms($admission->parent_guardian_phone, $message);
    }

    /**
     * Send admin notification SMS
     */
    private function sendAdminNotificationSms($admission)
    {
        $adminNumber = config('services.mnotify.default_recipient');
        
        if (!$adminNumber) {
            Log::info('Admin SMS not sent: No default recipient configured');
            return ['success' => false, 'error' => 'No admin number configured'];
        }

        $message = "NEW ADMISSION APPLICATION\n\n";
        $message .= "Name: {$admission->full_name}\n";
        $message .= "Reference: {$admission->payment_reference}\n";
        $message .= "Phone: {$admission->parent_guardian_phone}\n";
        $message .= "Previous School: {$admission->previous_school}\n\n";
        $message .= "Visit admin dashboard to view details:\n";
        $message .= route('admin.admissions.show', $admission->id);

        return $this->mnotify->sendSms($adminNumber, $message);
    }

    /**
     * Send status update SMS
     */
    private function sendStatusUpdateSms($admission, $oldStatus, $newStatus)
    {
        $statusMessages = [
            'reviewed' => "Your application is now under review. We'll get back to you soon.",
            'accepted' => "Congratulations! Your application has been accepted. Please contact the admission office for further details.",
            'rejected' => "We appreciate your interest in Agogo State College. Unfortunately, your application was not successful at this time.",
        ];

        $message = "Dear {$admission->full_name},\n\n";
        $message .= "Application Status Update:\n";
        $message .= "From: " . ucfirst($oldStatus) . "\n";
        $message .= "To: " . ucfirst($newStatus) . "\n\n";
        $message .= $statusMessages[$newStatus] ?? "Your application status has been updated to: " . ucfirst($newStatus) . ".\n\n";
        $message .= "Reference: {$admission->payment_reference}\n";
        $message .= "Agogo State College Admission Office";

        return $this->mnotify->sendSms($admission->parent_guardian_phone, $message);
    }

    /**
     * Update admission status
     */
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected'
        ]);

        $admission = Admission::findOrFail($id);
        $oldStatus = $admission->status;
        $admission->update(['status' => $request->status]);

        // Send SMS notification for status change (don't fail if SMS fails)
        try {
            $this->sendStatusUpdateSms($admission, $oldStatus, $request->status);
        } catch (\Exception $e) {
            Log::warning('Status update SMS failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()
            ->with('success', 'Admission status updated successfully.');
    }

    /**
     * Resend payment link via SMS
     */
    public function resendPaymentLink($id)
    {
        $admission = Admission::findOrFail($id);
        
        if ($admission->payment_status === 'paid') {
            return redirect()->back()
                ->with('error', 'Payment already completed for this application.');
        }

        // Initialize new payment
        return $this->initializePayment($admission);
    }

    /**
     * Send custom SMS from admin
     */
    public function sendCustomSms(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $admission = Admission::findOrFail($id);
        
        $result = $this->mnotify->sendSms($admission->parent_guardian_phone, $request->message);
        
        if ($result['success']) {
            return redirect()->back()
                ->with('success', 'SMS sent successfully.');
        }
        
        return redirect()->back()
            ->with('error', 'Failed to send SMS: ' . ($result['error'] ?? 'Unknown error'));
    }

    /**
     * Send custom SMS via AJAX
     */
    public function sendCustomSmsAjax(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $admission = Admission::findOrFail($id);
        
        $result = $this->mnotify->sendSms($admission->parent_guardian_phone, $request->message);
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'SMS sent successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Unknown error'
        ], 500);
    }

    /**
     * Show all admissions for admin
     */
    public function adminIndex(Request $request)
    {
        $query = Admission::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('surname', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('index_number', 'LIKE', "%{$search}%")
                  ->orWhere('parent_guardian_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by application status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $admissions = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Admission::count(),
            'paid' => Admission::where('payment_status', 'paid')->count(),
            'pending_payment' => Admission::where('payment_status', 'pending')->count(),
            'failed_payment' => Admission::where('payment_status', 'failed')->count(),
            'reviewed' => Admission::where('status', 'reviewed')->count(),
            'accepted' => Admission::where('status', 'accepted')->count(),
            'rejected' => Admission::where('status', 'rejected')->count(),
        ];

        return view('admin.admissions.index', compact('admissions', 'stats'));
    }

    /**
     * Show individual admission details for admin
     */
    public function adminShow($id)
    {
        $admission = Admission::findOrFail($id);
        return view('admin.admissions.show', compact('admission'));
    }

    /**
     * Export admissions to CSV
     */
    public function adminExport()
    {
        $admissions = Admission::all();
        
        $filename = "admissions_" . date('Y-m-d') . ".csv";
        
        return response()->streamDownload(function() use ($admissions) {
            $handle = fopen('php://output', 'w');
            
            fputcsv($handle, [
                'ID', 'Surname', 'First Name', 'Middle Name', 'Date of Birth',
                'Parent/Guardian', 'Phone', 'Address', 'Residence', 'Occupation',
                'Previous School', 'Index Number', 'Position', 'Interests',
                'Medical Conditions', 'Payment Status', 'Application Status',
                'Amount Paid (GHS)', 'Payment Reference', 'Applied At'
            ]);

            foreach ($admissions as $admission) {
                fputcsv($handle, [
                    $admission->id,
                    $admission->surname,
                    $admission->first_name,
                    $admission->middle_name,
                    $admission->date_of_birth->format('Y-m-d'),
                    $admission->parent_guardian_name,
                    $admission->parent_guardian_phone,
                    $admission->address,
                    $admission->place_of_residence,
                    $admission->parent_guardian_occupation,
                    $admission->previous_school,
                    $admission->index_number,
                    $admission->position_held ?? 'N/A',
                    $admission->interests_hobbies ?? 'N/A',
                    $admission->medical_conditions ?? 'N/A',
                    $admission->payment_status,
                    $admission->status,
                    number_format($admission->amount_paid, 2),
                    $admission->payment_reference,
                    $admission->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Delete admission
     */
    public function adminDestroy($id)
    {
        $admission = Admission::findOrFail($id);
        
        // Notify admin before deletion (don't fail if SMS fails)
        try {
            $adminNumber = config('services.mnotify.default_recipient');
            if ($adminNumber) {
                $message = "ADMISSION DELETED\n\n";
                $message .= "Applicant: {$admission->full_name}\n";
                $message .= "Reference: {$admission->payment_reference}\n";
                $message .= "Deleted by admin.";

                $this->mnotify->sendSms($adminNumber, $message);
            }
        } catch (\Exception $e) {
            Log::warning('Deletion notification SMS failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage()
            ]);
        }
        
        $admission->delete();

        return redirect()->route('admin.admissions.index')
            ->with('success', 'Admission record deleted successfully.');
    }

    /**
     * Test SMS functionality
     */
    public function testSms(Request $request)
    {
        $phone = $request->query('phone', '233XXXXXXXXX');
        $message = $request->query('message', 'Test SMS from Agogo State College. If you receive this, SMS integration is working!');
        
        $result = $this->mnotify->sendSms($phone, $message);
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'SMS sent successfully',
                'data' => $result['data'] ?? null
            ]);
        }
        
        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Unknown error'
        ], 500);
    }

    /**
     * Check SMS balance
     */
    public function checkSmsBalance()
    {
        $result = $this->mnotify->checkBalance();
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'balance' => $result['balance'] ?? 0,
                'currency' => $result['currency'] ?? 'GHS'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Unknown error'
        ], 500);
    }
}