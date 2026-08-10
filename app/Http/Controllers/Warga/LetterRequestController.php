<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;

class LetterRequestController extends Controller
{
    public function index()
    {
        $letters = auth()->user()->letterRequests()->latest()->paginate(10);
        return view('warga.surat.index', compact('letters'));
    }

    public function create()
    {
        return view('warga.surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_type' => 'required|string|max:255',
            'purpose' => 'required|string|max:1000',
        ], [
            'letter_type.required' => 'Jenis surat wajib dipilih.',
            'purpose.required' => 'Keperluan wajib diisi.',
        ]);

        $surat = auth()->user()->letterRequests()->create($validated);

        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemNotification(
            'Pengajuan Surat Baru',
            auth()->user()->name . " mengajukan surat {$surat->letter_type}.",
            route('admin.surat.show', $surat->id),
            'info'
        ));

        return redirect()->route('warga.surat.index')->with('success', 'Pengajuan surat berhasil dikirim. Mohon tunggu persetujuan admin.');
    }

    public function show(LetterRequest $surat)
    {
        if ($surat->user_id !== auth()->id()) {
            abort(403);
        }
        return view('warga.surat.show', compact('surat'));
    }
}
