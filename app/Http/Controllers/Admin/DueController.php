<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Due;
use App\Models\User;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index(Request $request)
    {
        $query = Due::with('user');

        if ($request->filled('month_year')) {
            $query->where('month_year', $request->month_year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $dues = $query->latest()->paginate(10)->withQueryString();
        $totalCollected = Due::paid()->sum('amount');
        $totalUnpaid = Due::unpaid()->count();

        return view('admin.iuran.index', compact('dues', 'totalCollected', 'totalUnpaid'));
    }

    public function create()
    {
        $warga = User::where('role', 'warga')->where('is_verified', true)->get();
        return view('admin.iuran.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month_year' => 'required|string|size:7',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid',
            'payment_date' => 'nullable|date',
        ]);

        if ($validated['status'] === 'paid' && empty($validated['payment_date'])) {
            $validated['payment_date'] = now()->toDateString();
        }

        Due::create($validated);

        return redirect()->route('admin.iuran.index')->with('success', 'Data iuran berhasil ditambahkan.');
    }

    public function markPaid(Due $iuran)
    {
        $iuran->update([
            'status' => 'paid',
            'payment_date' => now()->toDateString(),
        ]);

        return redirect()->route('admin.iuran.index')->with('success', 'Iuran berhasil ditandai lunas.');
    }

    public function generateBatch(Request $request)
    {
        $validated = $request->validate([
            'month_year' => 'required|string|size:7',
            'amount' => 'required|numeric|min:0',
        ]);

        $warga = User::where('role', 'warga')->where('is_verified', true)->get();

        foreach ($warga as $w) {
            Due::firstOrCreate(
                [
                    'user_id' => $w->id,
                    'month_year' => $validated['month_year'],
                ],
                [
                    'amount' => $validated['amount'],
                    'status' => 'unpaid',
                ]
            );
        }

        return redirect()->route('admin.iuran.index')->with('success', 'Tagihan iuran bulan ' . $validated['month_year'] . ' berhasil digenerate untuk ' . $warga->count() . ' warga.');
    }
}
