@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi pribadi dan pengaturan keamanan akun Anda.')

@section('content')
<div class="mx-auto max-w-4xl animate-fade-in-up space-y-6">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="rounded-xl bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Informasi Profil --}}
    <div class="rounded-2xl border border-border bg-card shadow-sm overflow-hidden">
        <div class="border-b border-border bg-slate-50/50 px-6 py-4">
            <h3 class="text-lg font-bold text-slate-800">Informasi Profil</h3>
            <p class="text-sm text-slate-500">Perbarui nama, email, dan nomor telepon akun Anda.</p>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
                        @error('name') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
                        @error('email') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500">
                        @error('phone') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span class="text-xs font-normal text-slate-400">(Tidak dapat diubah)</span></label>
                        <input type="text" value="{{ $user->nik }}" class="block w-full rounded-xl border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500 cursor-not-allowed" disabled>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Form Ubah Password --}}
    <div class="rounded-2xl border border-border bg-card shadow-sm overflow-hidden mt-6">
        <div class="border-b border-border bg-slate-50/50 px-6 py-4">
            <h3 class="text-lg font-bold text-slate-800">Ubah Password</h3>
            <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.</p>
        </div>
        <form action="{{ route('profile.password') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 max-w-xl">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
                    @error('current_password') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
                    @error('password') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500" required>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-slate-900 focus:ring-4 focus:ring-slate-500/30 transition-all">
                        Perbarui Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
