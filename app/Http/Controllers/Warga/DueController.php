<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;

class DueController extends Controller
{
    public function index()
    {
        $dues = auth()->user()->dues()->latest()->paginate(12);
        $totalPaid = auth()->user()->dues()->paid()->sum('amount');
        $totalUnpaid = auth()->user()->dues()->unpaid()->count();

        return view('warga.iuran.index', compact('dues', 'totalPaid', 'totalUnpaid'));
    }
}
