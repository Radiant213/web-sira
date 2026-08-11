@extends('layouts.app')
@section('title', 'Edit Data User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Perbarui data informasi pengguna sistem')

@section('content')
<div class="mx-auto max-w-4xl animate-fade-in-up">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-white p-2 text-slate-400 shadow-sm transition-colors hover:bg-slate-50 hover:text-slate-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Edit User: {{ $user->name }}</h2>
    </div>

    <div class="rounded-2xl border border-border bg-card shadow-sm overflow-hidden">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400"
                               required>
                        @error('nik') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400"
                               required>
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400"
                               required>
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400">
                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Peran (Role)</label>
                        <select name="role" class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[position:right_0.75rem_center] bg-no-repeat pr-10" required>
                            <option value="" disabled>Pilih role...</option>
                            @foreach($roles as $roleItem)
                                <option value="{{ $roleItem->name }}" {{ old('role', $user->roles->first()->name ?? $user->role) == $roleItem->name ? 'selected' : '' }}>
                                    {{ ucfirst($roleItem->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea name="address" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Ubah Password <span class="text-xs font-normal text-slate-500">(Kosongkan jika tidak ingin diubah)</span></h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400">
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition-all placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 hover:border-slate-400">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/30 transition-all" style="cursor: pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
