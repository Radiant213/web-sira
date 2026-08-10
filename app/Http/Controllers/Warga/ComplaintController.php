<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = auth()->user()->complaints()->latest()->paginate(10);
        return view('warga.pengaduan.index', compact('complaints'));
    }

    public function create()
    {
        return view('warga.pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'title.required' => 'Judul pengaduan wajib diisi.',
            'description.required' => 'Deskripsi pengaduan wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $pengaduan = auth()->user()->complaints()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $photoPath,
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemNotification(
            'Pengaduan Baru',
            auth()->user()->name . " mengirimkan pengaduan: {$pengaduan->title}",
            route('admin.pengaduan.show', $pengaduan->id),
            'warning'
        ));

        return redirect()->route('warga.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim. Terima kasih atas laporan Anda.');
    }

    public function show(Complaint $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('warga.pengaduan.show', compact('pengaduan'));
    }
}
