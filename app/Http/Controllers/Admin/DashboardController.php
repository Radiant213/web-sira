<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Due;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_warga' => User::where('role', 'warga')->count(),
            'warga_pending' => User::where('role', 'warga')->where('is_verified', false)->count(),
            'surat_pending' => LetterRequest::pending()->count(),
            'pengaduan_pending' => Complaint::where('status', '!=', 'resolved')->count(),
            'total_iuran' => Due::paid()->sum('amount'),
            'iuran_belum_bayar' => Due::unpaid()->count(),
        ];

        $recentLetters = LetterRequest::with('user')->latest()->take(5)->get();
        $recentComplaints = Complaint::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLetters', 'recentComplaints'));
    }

    public function exportPdf(\Illuminate\Http\Request $request)
    {
        $stats = [
            'total_warga' => User::where('role', 'warga')->count(),
            'warga_pending' => User::where('role', 'warga')->where('is_verified', false)->count(),
            'surat_pending' => LetterRequest::pending()->count(),
            'pengaduan_pending' => Complaint::where('status', '!=', 'resolved')->count(),
            'total_iuran' => Due::paid()->sum('amount'),
            'iuran_belum_bayar' => Due::unpaid()->count(),
        ];

        $chartImage = $request->input('chart_image');

        if (ob_get_length()) {
            ob_end_clean();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf.dashboard', compact('stats', 'chartImage'));
        return $pdf->download('Laporan_Dashboard_SIRA.pdf');
    }
}
