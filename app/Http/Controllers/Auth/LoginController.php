<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    /**
     * Handle login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Admin 2FA Logic
            if ($user->isAdmin()) {
                $otp = sprintf("%06d", mt_rand(1, 999999));
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => now()->addMinutes(5),
                ]);

                $customMessage = "Jika Anda ingin login menggunakan email '{$user->email}', cek email ini untuk mendapatkan kode OTP dan melanjutkan login.";
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($otp, $customMessage));
                
                session()->put('admin_2fa_passed', false);
                return redirect()->route('admin.2fa');
            }

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect based on user role.
     */
    protected function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->email_verified_at === null) {
            if (!$user->otp_code || !$user->otp_expires_at || $user->otp_expires_at->isPast()) {
                $otp = sprintf("%06d", mt_rand(1, 999999));
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => now()->addMinutes(5),
                ]);
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($otp));
            }
            return redirect()->route('otp.verify')->with('info', 'Kode OTP baru telah dikirimkan ke email Anda.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (!$user->isVerified()) {
            return redirect()->route('pending-verification');
        }

        return redirect()->route('warga.dashboard');
    }
}
