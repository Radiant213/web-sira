<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'warga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->status === 'verified');
        }

        $warga = $query->latest()->paginate(10)->withQueryString();

        return view('admin.warga.index', compact('warga'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8',
        ]);

        $warga = User::create([
            ...$validated,
            'password' => bcrypt($validated['password']),
            'role' => 'warga',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        $wargaRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'warga', 'guard_name' => 'web']);
        $warga->assignRole($wargaRole);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit(User $warga)
    {
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, User $warga)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik,' . $warga->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $warga->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $warga->update($validated);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diupdate.');
    }

    public function destroy(User $warga)
    {
        $warga->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);
        return redirect()->route('admin.warga.index')->with('success', 'Akun warga berhasil diverifikasi.');
    }

    public function reject(User $user)
    {
        $user->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Akun warga berhasil ditolak dan dihapus.');
    }
}
