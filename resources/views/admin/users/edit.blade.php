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
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20"
                               required>
                        @error('nik') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20"
                               required>
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20"
                               required>
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20">
                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Peran (Role)</label>
                        <select name="role" class="block w-full appearance-none rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
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
                        <textarea name="address" rows="3" 
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Ubah Password <span class="text-xs font-normal text-slate-500">(Kosongkan jika tidak ingin diubah)</span></h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20">
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20">
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
