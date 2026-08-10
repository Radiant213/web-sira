@extends('layouts.app')

@section('title', 'Tambah Warga')
@section('page-title', 'Tambah Warga')
@section('page-subtitle', 'Tambahkan data warga baru')

@section('content')
<div class="mx-auto max-w-2xl animate-fade-in-up">
    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8">
        @if($errors->any())
            <x-ui.alert type="error" class="mb-6">
                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('admin.warga.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="nik" class="mb-1.5 block text-sm font-medium text-slate-700">NIK <span class="text-red-500">*</span></label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16"
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="16 digit NIK">
                </div>

                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="Nama lengkap warga">
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="nama@email.com">
                </div>

                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-slate-700">No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="08xxxxxxxxxx">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="mb-1.5 block text-sm font-medium text-slate-700">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 resize-none"
                              placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="Minimal 8 karakter">
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-border pt-5">
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    Simpan
                </button>
                <a href="{{ route('admin.warga.index') }}" class="rounded-xl border border-border px-6 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
