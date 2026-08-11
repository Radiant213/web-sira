<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;

class Admin2FAController extends Controller
{
    /**
     * Show the 2FA verification form.
     */
    public function showVerifyForm(Request $request)
    {
        if (session('admin_2fa_passed')) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-2fa');
    }

    /**
     * Handle the OTP submission.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $inputOtp = $request->otp;
        $user = $request->user();

        if ((string) $user->otp_code === (string) trim($inputOtp) && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            // Valid OTP
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            session(['admin_2fa_passed' => true]);

            return redirect()->route('admin.dashboard')->with('success', 'Verifikasi keamanan berhasil.');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }

    /**
     * Resend the OTP code.
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if (session('admin_2fa_passed')) {
            return redirect()->route('admin.dashboard');
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $customMessage = "Jika Anda ingin login menggunakan email '{$user->email}', cek email ini untuk mendapatkan kode OTP dan melanjutkan login.";
        Mail::to($user->email)->send(new OtpVerificationMail($otp, $customMessage));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
