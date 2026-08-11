<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $newEmail = $user->email;
            
            // Revert email temporarily so it's not saved yet
            $user->email = $user->getOriginal('email');
            $user->save(); // Save name and phone

            $otp = sprintf("%06d", mt_rand(1, 999999));
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();
            
            session(['pending_email_change' => $newEmail]);
            
            Mail::to($newEmail)->send(new OtpVerificationMail($otp, 'Anda telah meminta perubahan alamat email. Gunakan kode OTP berikut untuk memverifikasi email baru Anda.'));
            
            return redirect()->route('profile.verify')->with('success', 'Kode OTP telah dikirim ke email baru Anda.');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        session(['pending_password_change' => Hash::make($validated['password'])]);

        Mail::to($user->email)->send(new OtpVerificationMail($otp, 'Anda telah meminta perubahan password. Gunakan kode OTP berikut untuk mengonfirmasi perubahan ini.'));

        return redirect()->route('profile.verify')->with('success', 'Kode OTP telah dikirim ke email Anda untuk konfirmasi perubahan password.');
    }

    /**
     * Show the profile change OTP verification form.
     */
    public function verifyChangeForm(Request $request)
    {
        if (!session('pending_email_change') && !session('pending_password_change')) {
            return redirect()->route('profile.edit');
        }

        $message = session('pending_email_change') 
            ? 'Kami telah mengirimkan kode OTP ke email baru Anda.' 
            : 'Kami telah mengirimkan kode OTP ke email Anda saat ini.';

        return view('profile.verify-change', compact('message'));
    }

    /**
     * Handle the profile change OTP submission.
     */
    public function verifyChange(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $inputOtp = $request->otp;
        $user = $request->user();

        if ((string) $user->otp_code === (string) trim($inputOtp) && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            // Valid OTP
            $user->otp_code = null;
            $user->otp_expires_at = null;

            if (session('pending_email_change')) {
                $user->email = session('pending_email_change');
                session()->forget('pending_email_change');
            } elseif (session('pending_password_change')) {
                $user->password = session('pending_password_change');
                session()->forget('pending_password_change');
            }

            $user->save();

            return redirect()->route('profile.edit')->with('success', 'Perubahan berhasil dikonfirmasi dan disimpan.');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }

    /**
     * Resend the profile change OTP.
     */
    public function resendChangeOtp(Request $request)
    {
        $user = $request->user();

        if (!session('pending_email_change') && !session('pending_password_change')) {
            return redirect()->route('profile.edit');
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        if (session('pending_email_change')) {
            $email = session('pending_email_change');
            $customMessage = 'Anda telah meminta perubahan alamat email. Gunakan kode OTP berikut untuk memverifikasi email baru Anda.';
        } else {
            $email = $user->email;
            $customMessage = 'Anda telah meminta perubahan password. Gunakan kode OTP berikut untuk mengonfirmasi perubahan ini.';
        }

        Mail::to($email)->send(new OtpVerificationMail($otp, $customMessage));

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }
}
