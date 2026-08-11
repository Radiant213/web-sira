<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showVerifyForm(Request $request)
    {
        // If the user's email is already verified, redirect them appropriately.
        if ($request->user() && $request->user()->email_verified_at !== null) {
            return redirect('/');
        }

        return view('auth.verify-otp');
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

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        if ($user->otp_code === $inputOtp && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            // Valid OTP
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'email_verified_at' => now(),
            ]);

            // Now that email is verified, we can notify the admins if they are 'warga' and not verified by admin
            if ($user->role === 'warga' && !$user->is_verified) {
                $admins = \App\Models\User::where('role', 'admin')->get();
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemNotification(
                    'Pendaftaran Warga Baru',
                    "{$user->name} telah memverifikasi email dan menunggu verifikasi admin.",
                    route('admin.warga.index'),
                    'info'
                ));
            }

            return redirect()->intended('/')->with('success', 'Email berhasil diverifikasi.');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }

    /**
     * Resend the OTP code.
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at !== null) {
            return redirect('/');
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpVerificationMail($otp));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
