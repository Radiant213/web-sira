<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form untuk memasukkan email reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Tangani pengiriman email OTP untuk reset password.
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $otp = sprintf("%06d", mt_rand(1, 999999));

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpVerificationMail($otp, 'Gunakan kode OTP berikut untuk me-reset password Anda.'));

        // Simpan email ke session agar tidak perlu diketik ulang di form reset
        session(['reset_email' => $user->email]);

        return redirect()->route('password.reset')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Tampilkan form untuk memasukkan OTP dan password baru.
     */
    public function showResetForm(Request $request)
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', ['email' => session('reset_email')]);
    }

    /**
     * Tangani validasi OTP dan update password baru.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|string|size:1',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $inputOtp = implode('', $request->otp);
        $user = User::where('email', $request->email)->first();

        if ($user->otp_code === $inputOtp && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            // Valid OTP
            $user->update([
                'password' => Hash::make($request->password),
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('reset_email');

            return redirect()->route('login')->with('success', 'Password berhasil di-reset. Silakan login dengan password baru.');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }
}
