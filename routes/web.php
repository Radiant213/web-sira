<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DueController as AdminDueController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\LetterRequestController;
use App\Http\Controllers\Warga\ComplaintController as WargaComplaintController;
use App\Http\Controllers\Warga\DueController as WargaDueController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('warga.dashboard');
    }
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.email');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// OTP Verification (Requires Auth)
Route::middleware('auth')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/otp/verify', [OtpController::class, 'verify']);
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| Pending Verification Page
|--------------------------------------------------------------------------
*/
Route::get('/pending-verification', function () {
    if (!auth()->check()) return redirect()->route('login');
    if (auth()->user()->isAdmin()) return redirect()->route('admin.dashboard');
    if (auth()->user()->isVerified()) return redirect()->route('warga.dashboard');
    return view('auth.pending-verification');
})->name('pending-verification');

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Profile Change Verification
    Route::get('/profile/verify', [ProfileController::class, 'verifyChangeForm'])->name('profile.verify');
    Route::post('/profile/verify', [ProfileController::class, 'verifyChange']);
    Route::post('/profile/verify/resend', [ProfileController::class, 'resendChangeOtp'])->name('profile.verify.resend');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // 2FA Routes
    Route::get('/2fa', [\App\Http\Controllers\Auth\Admin2FAController::class, 'showVerifyForm'])->name('2fa');
    Route::post('/2fa', [\App\Http\Controllers\Auth\Admin2FAController::class, 'verify']);
    Route::post('/2fa/resend', [\App\Http\Controllers\Auth\Admin2FAController::class, 'resend'])->name('2fa.resend');
});

Route::prefix('admin')->middleware(['auth', 'role:admin', 'admin.2fa'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/export', [AdminDashboardController::class, 'exportPdf'])->name('dashboard.export');

    // Users Management (Admin only)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Roles Management
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show']);

    // Warga Management
    Route::resource('warga', WargaController::class);
    Route::patch('/warga/{user}/verify', [WargaController::class, 'verify'])->name('warga.verify');
    Route::delete('/warga/{user}/reject', [WargaController::class, 'reject'])->name('warga.reject');

    // Surat Pengantar
    Route::get('/surat', [LetterController::class, 'index'])->name('surat.index');
    Route::get('/surat/{surat}', [LetterController::class, 'show'])->name('surat.show');
    Route::patch('/surat/{surat}/approve', [LetterController::class, 'approve'])->name('surat.approve');
    Route::patch('/surat/{surat}/reject', [LetterController::class, 'reject'])->name('surat.reject');
    Route::get('/surat/{surat}/print', [LetterController::class, 'print'])->name('surat.print');

    // Pengaduan
    Route::get('/pengaduan', [AdminComplaintController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminComplaintController::class, 'show'])->name('pengaduan.show');
    Route::patch('/pengaduan/{pengaduan}/status', [AdminComplaintController::class, 'updateStatus'])->name('pengaduan.updateStatus');

    // Iuran
    Route::get('/iuran', [AdminDueController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/create', [AdminDueController::class, 'create'])->name('iuran.create');
    Route::post('/iuran', [AdminDueController::class, 'store'])->name('iuran.store');
    Route::patch('/iuran/{iuran}/pay', [AdminDueController::class, 'markPaid'])->name('iuran.markPaid');
    Route::post('/iuran/generate', [AdminDueController::class, 'generateBatch'])->name('iuran.generate');
});

/*
|--------------------------------------------------------------------------
| Warga Routes
|--------------------------------------------------------------------------
*/
Route::prefix('warga')->middleware(['auth', 'role:warga', 'verified.account'])->name('warga.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

    // Surat Pengantar
    Route::get('/surat', [LetterRequestController::class, 'index'])->name('surat.index');
    Route::get('/surat/create', [LetterRequestController::class, 'create'])->name('surat.create');
    Route::post('/surat', [LetterRequestController::class, 'store'])->name('surat.store');
    Route::get('/surat/{surat}', [LetterRequestController::class, 'show'])->name('surat.show');

    // Pengaduan
    Route::get('/pengaduan', [WargaComplaintController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [WargaComplaintController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [WargaComplaintController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [WargaComplaintController::class, 'show'])->name('pengaduan.show');

    // Iuran
    Route::get('/iuran', [WargaDueController::class, 'index'])->name('iuran.index');
});
