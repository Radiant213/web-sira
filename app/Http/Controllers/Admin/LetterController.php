<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = LetterRequest::with('user');

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

        $letters = $query->latest()->paginate(10)->withQueryString();

        return view('admin.surat.index', compact('letters'));
    }

    public function show(LetterRequest $surat)
    {
        $surat->load('user');
        return view('admin.surat.show', compact('surat'));
    }

    public function approve(LetterRequest $surat)
    {
        $surat->update(['status' => 'approved']);
        return redirect()->route('admin.surat.show', $surat)->with('success', 'Surat pengantar telah disetujui.');
    }

    public function reject(Request $request, LetterRequest $surat)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $surat->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.surat.show', $surat)->with('success', 'Surat pengantar telah ditolak.');
    }

    public function print(LetterRequest $surat)
    {
        $surat->load('user');
        $pdf = Pdf::loadView('admin.surat.print', compact('surat'));

        return $pdf->stream('surat-pengantar-' . $surat->id . '.pdf');
    }
}
