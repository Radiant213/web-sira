<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Due;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'surat_pending' => $user->letterRequests()->pending()->count(),
            'surat_approved' => $user->letterRequests()->approved()->count(),
            'pengaduan_pending' => $user->complaints()->where('status', '!=', 'resolved')->count(),
            'pengaduan_resolved' => $user->complaints()->resolved()->count(),
            'iuran_unpaid' => $user->dues()->unpaid()->count(),
            'iuran_total' => $user->dues()->paid()->sum('amount'),
        ];

        $recentLetters = $user->letterRequests()->latest()->take(3)->get();
        $recentComplaints = $user->complaints()->latest()->take(3)->get();
        $currentDue = $user->dues()->where('month_year', now()->format('Y-m'))->first();

        return view('warga.dashboard', compact('stats', 'recentLetters', 'recentComplaints', 'currentDue'));
    }
}
