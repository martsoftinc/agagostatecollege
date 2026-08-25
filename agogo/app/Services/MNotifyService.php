<?php
// app/Services/MNotifyService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MNotifyService
{
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->apiKey = config('services.mnotify.api_key');
        $this->senderId = config('services.mnotify.sender_id');
    }

    /**
     * Send SMS using MNotify
     */
    public function sendSms(string $recipient, string $message): bool
    {
        try {
            // Format phone number
            $recipient = $this->formatPhoneNumber($recipient);

            Log::info('Sending SMS via MNotify', [
                'recipient' => $recipient,
                'sender' => $this->senderId,
                'message' => $message
            ]);

            // MNotify expects 'recipient' as an array
            $response = Http::post('https://api.mnotify.com/api/sms/quick', [
                'key' => $this->apiKey,
                'recipient' => [$recipient],  // IMPORTANT: Must be an array
                'sender' => $this->senderId,
                'message' => $message,
            ]);

            $responseData = $response->json();

            Log::info('MNotify Response', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            // Check for success response
            if ($response->successful()) {
                // MNotify returns 'success' status
                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    Log::info("SMS sent successfully to: {$recipient}");
                    return true;
                }
                
                // Some versions return 'code' instead of 'status'
                if (isset($responseData['code']) && $responseData['code'] === 'success') {
                    Log::info("SMS sent successfully to: {$recipient}");
                    return true;
                }
            }

            Log::error("MNotify SMS failed", [
                'recipient' => $recipient,
                'response' => $responseData,
                'status' => $response->status()
            ]);
            
            return false;

        } catch (\Exception $e) {
            Log::error("MNotify SMS error: " . $e->getMessage(), [
                'recipient' => $recipient,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send pincode to student
     */
    public function sendPincode(User $user, string $pincode): bool
    {
        $message = "AGOSCO: Hello {$user->name}, your new portal pincode is: {$pincode}. Please keep this confidential. - Agogo State College";
        return $this->sendSms($user->phone, $message);
    }

    /**
     * Format phone number for MNotify
     * MNotify expects numbers in format: 233XXXXXXXXX (without +)
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If phone starts with 0, replace with 233 (Ghana country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '233' . substr($phone, 1);
        }
        
        // If phone doesn't start with 233, assume it's a local number and add 233
        if (!str_starts_with($phone, '233')) {
            $phone = '233' . $phone;
        }
        
        return $phone;
    }
}