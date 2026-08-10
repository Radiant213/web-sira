<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Role ini sudah ada.',
            'guard_name.required' => 'Guard wajib dipilih.',
        ]);

        Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => 'web', // Force web guard internally
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role baru berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Role ini sudah ada.',
            'guard_name.required' => 'Guard wajib dipilih.',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Data role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        // Jangan hapus role admin dan warga
        if (in_array($role->name, ['admin', 'warga'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Role bawaan sistem tidak boleh dihapus.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
