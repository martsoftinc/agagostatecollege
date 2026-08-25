<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\MNotifyService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ForgotPincodeController extends Controller
{

    protected $mnotify;

    public function __construct(MNotifyService $mnotify)
    {
        $this->mnotify = $mnotify;
    }
    
    /**
     * Show the forgot pincode form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-pincode');
    }

    /**
     * Send pincode to user's phone via SMS
     */
     public function sendPincode(Request $request)
    {
        // FIX: Validate 'student_id' instead of 'login'
        $request->validate([
            'student_id' => 'required|string|max:255',
        ]);

        // Find user by student_id or phone
        $user = User::where('student_id', $request->student_id)
            ->orWhere('phone', $request->student_id)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'student_id' => ['No student found with this ID or phone number.'],
            ]);
        }

        // Check if user has a phone number
        if (!$user->phone) {
            throw ValidationException::withMessages([
                'student_id' => ['No phone number registered for this student. Please contact the administrator.'],
            ]);
        }

        // Generate new pincode
        $newPincode = User::generatePincode();

        // Update user's pincode
        $user->pincode = $newPincode;
        $user->save();

        // Send SMS with pincode
        $sent = $this->mnotify->sendPincode($user, $newPincode);

        if (!$sent) {
            Log::error("Failed to send pincode to: {$user->phone} for student: {$user->student_id}");
            return back()->with('error', 'Failed to send pincode. Please try again or contact the administrator.');
        }

        Log::info("Pincode sent successfully to: {$user->phone} for student: {$user->student_id}");

        return back()->with('success', 'A new pincode has been sent to your registered phone number.');
    }

    /**
     * Send SMS notification to user
     */
    private function sendSms(string $phone, string $pincode): void
    {
        // Example using a SMS service (replace with actual SMS provider)
        // You can use services like Twilio, Africa's Talking, etc.
        
        $message = "Your Agogo State College student portal pincode is: $pincode. Please keep this confidential.";
        
        try {
            // Implement your SMS sending logic here
            // Example with a custom SMS service class:
            // SmsService::send($phone, $message);
            
            // For testing, log the SMS
            Log::info("SMS sent to: $phone, Pincode: $pincode");
            
        } catch (\Exception $e) {
            Log::error("Failed to send SMS: " . $e->getMessage());
            // You might want to throw an exception or handle it differently
        }
    }

    /**
     * Determine if login input is student_id or phone
     */
    private function determineLoginField(string $login): string
    {
        if (preg_match('/^[0-9\+\-\s\(\)]+$/', $login)) {
            return 'phone';
        }

        if (preg_match('/^[A-Z0-9\-]+$/i', $login)) {
            return 'student_id';
        }

        return 'student_id';
    }
}