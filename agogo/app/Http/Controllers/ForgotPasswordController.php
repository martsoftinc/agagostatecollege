<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to request a password reset code.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotForm()
    {
        return view('password.request');
    }

    /**
     * Send a password reset code to the user's email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendResetCode(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $email = $request->email;
        
        // Generate a 6-digit random code
        $code = sprintf("%06d", mt_rand(1, 999999));
        
        // Store the code in cache with expiration (15 minutes)
        Cache::put('password_reset_' . $email, [
            'code' => $code,
            'created_at' => Carbon::now(),
        ], now()->addMinutes(15));
        
        // Send the code via email
        try {
            $this->sendResetCodeEmail($email, $code);
            
            // Store email in session for the next step
            session(['reset_email' => $email]);
            
            return response()->json([
                'success' => true,
                'message' => 'A verification code has been sent to your email address.',
                'redirect' => route('password.verify')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to send verification code. Please try again later.'
            ], 500);
        }
    }
    
    /**
     * Send the reset code email.
     *
     * @param  string  $email
     * @param  string  $code
     * @return void
     */
    protected function sendResetCodeEmail($email, $code)
    {
        $subject = 'Password Reset Code - Brainest Educare';
        
        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset Code</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .header {
                    background: #002c5f;
                    padding: 30px 20px;
                    text-align: center;
                }
                .header h1 {
                    color: #ffffff;
                    margin: 0;
                    font-size: 24px;
                }
                .content {
                    padding: 40px 30px;
                    text-align: center;
                }
                .code {
                    font-size: 48px;
                    font-weight: bold;
                    color: #002c5f;
                    background: #f0f4f8;
                    padding: 20px;
                    border-radius: 12px;
                    letter-spacing: 8px;
                    margin: 20px 0;
                    font-family: monospace;
                }
                .message {
                    color: #333333;
                    line-height: 1.6;
                    margin-bottom: 20px;
                }
                .footer {
                    background: #f8f9fa;
                    padding: 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #666666;
                }
                .button {
                    display: inline-block;
                    background: #002c5f;
                    color: white;
                    padding: 12px 30px;
                    text-decoration: none;
                    border-radius: 6px;
                    margin-top: 20px;
                }
                .warning {
                    font-size: 12px;
                    color: #999;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Brainest Educare</h1>
                </div>
                <div class='content'>
                    <h2>Password Reset Request</h2>
                    <p class='message'>We received a request to reset your password. Use the verification code below to proceed with resetting your password.</p>
                    <div class='code'>" . $code . "</div>
                    <p class='message'>This code will expire in <strong>15 minutes</strong>.</p>
                    <p class='warning'>If you did not request a password reset, please ignore this email or contact support.</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Brainest Educare. All rights reserved.</p>
                    <p>This is an automated message, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Plain text version
        $textContent = "Password Reset Request\n\n";
        $textContent .= "We received a request to reset your password. Use the verification code below to proceed:\n\n";
        $textContent .= "VERIFICATION CODE: " . $code . "\n\n";
        $textContent .= "This code will expire in 15 minutes.\n\n";
        $textContent .= "If you did not request a password reset, please ignore this email.\n\n";
        $textContent .= "© " . date('Y') . " Brainest Educare";
        
        Mail::send([], [], function ($message) use ($email, $subject, $htmlContent, $textContent) {
            $message->to($email)
                    ->subject($subject)
                    ->html($htmlContent)
                    ->text($textContent);
        });
    }
    
    /**
     * Show the form to enter the verification code.
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyCodeForm()
    {
        // Check if email exists in session
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }
        
        return view('password.verify');
    }
    
    /**
     * Verify the reset code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);
        
        $email = session('reset_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request a new reset code.',
                'redirect' => route('password.request')
            ], 400);
        }
        
        $cachedData = Cache::get('password_reset_' . $email);
        
        if (!$cachedData) {
            return response()->json([
                'success' => false,
                'message' => 'Reset code has expired. Please request a new one.',
                'redirect' => route('password.request')
            ], 400);
        }
        
        if ($cachedData['code'] !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        }
        
        // Code is valid, generate a temporary token for password reset
        $token = Str::random(60);
        
        // Store the token in cache with longer expiration (30 minutes)
        Cache::put('password_reset_token_' . $email, [
            'token' => $token,
            'code_verified_at' => Carbon::now(),
        ], now()->addMinutes(30));
        
        // Store token in session
        session(['reset_token' => $token]);
        
        // Clear the code from cache (already used)
        Cache::forget('password_reset_' . $email);
        
        return response()->json([
            'success' => true,
            'message' => 'Code verified successfully.',
            'redirect' => route('password.reset-form')
        ]);
    }
    
    /**
     * Show the password reset form.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        // Check if token exists in session
        if (!session()->has('reset_token') || !session()->has('reset_email')) {
            return redirect()->route('password.request');
        }
        
        return view('password.reset');
    }
    
    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
        
        $email = session('reset_email');
        $token = session('reset_token');
        
        if (!$email || !$token) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request a new password reset.',
                'redirect' => route('password.request')
            ], 400);
        }
        
        // Verify the token is still valid
        $cachedToken = Cache::get('password_reset_token_' . $email);
        
        if (!$cachedToken || $cachedToken['token'] !== $token) {
            return response()->json([
                'success' => false,
                'message' => 'Reset session has expired. Please request a new reset code.',
                'redirect' => route('password.request')
            ], 400);
        }
        
        // Find the user and update password
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found. Please try again.',
                'redirect' => route('password.request')
            ], 404);
        }
        
        // Update password
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Clear all reset-related session data and cache
        session()->forget(['reset_email', 'reset_token']);
        Cache::forget('password_reset_token_' . $email);
        
        // Send confirmation email (optional)
        $this->sendPasswordResetConfirmation($email);
        
        return response()->json([
            'success' => true,
            'message' => 'Your password has been successfully reset.',
            'redirect' => route('login')
        ]);
    }
    
    /**
     * Send password reset confirmation email.
     *
     * @param  string  $email
     * @return void
     */
    protected function sendPasswordResetConfirmation($email)
    {
        $subject = 'Your Password Has Been Reset - Brainest Educare';
        
        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Password Reset Confirmation</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .header {
                    background: #002c5f;
                    padding: 30px 20px;
                    text-align: center;
                }
                .header h1 {
                    color: #ffffff;
                    margin: 0;
                }
                .content {
                    padding: 40px 30px;
                    text-align: center;
                }
                .message {
                    color: #333333;
                    line-height: 1.6;
                }
                .footer {
                    background: #f8f9fa;
                    padding: 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #666666;
                }
                .button {
                    display: inline-block;
                    background: #002c5f;
                    color: white;
                    padding: 12px 30px;
                    text-decoration: none;
                    border-radius: 6px;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Brainest Educare</h1>
                </div>
                <div class='content'>
                    <h2>Password Reset Confirmation</h2>
                    <p class='message'>Your password has been successfully reset.</p>
                    <p class='message'>If you did not perform this action, please contact our support team immediately.</p>
                    <a href='" . route('login') . "' class='button'>Sign In Now</a>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Brainest Educare. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        Mail::send([], [], function ($message) use ($email, $subject, $htmlContent) {
            $message->to($email)
                    ->subject($subject)
                    ->html($htmlContent);
        });
    }
    
    /**
     * Resend the reset code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendCode(Request $request)
    {
        $email = session('reset_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please restart the password reset process.',
                'redirect' => route('password.request')
            ], 400);
        }
        
        // Check if user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
                'redirect' => route('password.request')
            ], 404);
        }
        
        // Generate a new 6-digit code
        $code = sprintf("%06d", mt_rand(1, 999999));
        
        // Store the new code in cache
        Cache::put('password_reset_' . $email, [
            'code' => $code,
            'created_at' => Carbon::now(),
        ], now()->addMinutes(15));
        
        // Send the new code
        try {
            $this->sendResetCodeEmail($email, $code);
            
            return response()->json([
                'success' => true,
                'message' => 'A new verification code has been sent to your email.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to resend reset code: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to send verification code. Please try again later.'
            ], 500);
        }
    }
}