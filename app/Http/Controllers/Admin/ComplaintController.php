<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengaduan.index', compact('complaints'));
    }

    public function show(Complaint $pengaduan)
    {
        $pengaduan->load('user');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Complaint $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,process,resolved',
            'admin_response' => 'nullable|string|max:1000',
        ]);

        $pengaduan->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        return redirect()->route('admin.pengaduan.show', $pengaduan)->with('success', 'Status pengaduan berhasil diupdate.');
    }
}
