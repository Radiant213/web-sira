@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h2 class="mb-6 text-center text-xl font-bold text-white">Daftar Akun Warga</h2>

    @if($errors->any())
        <x-ui.alert type="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-200">
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.alert>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- NIK --}}
        <div>
            <label for="nik" class="mb-1.5 block text-sm font-medium text-slate-300">NIK <span class="text-red-400">*</span></label>
            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16"
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="16 digit NIK">
        </div>

        {{-- Nama --}}
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-300">Nama Lengkap <span class="text-red-400">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="Nama lengkap Anda">
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Email <span class="text-red-400">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="nama@email.com">
        </div>

        {{-- Phone --}}
        <div>
            <label for="phone" class="mb-1.5 block text-sm font-medium text-slate-300">No. Telepon</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="08xxxxxxxxxx">
        </div>

        {{-- Address --}}
        <div>
            <label for="address" class="mb-1.5 block text-sm font-medium text-slate-300">Alamat</label>
            <textarea id="address" name="address" rows="2"
                      class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                             outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2 resize-none"
                      placeholder="Alamat lengkap Anda">{{ old('address') }}</textarea>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-300">Password <span class="text-red-400">*</span></label>
            <input type="password" id="password" name="password" required
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="Minimal 8 karakter">
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-300">Konfirmasi Password <span class="text-red-400">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="Ulangi password">
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30
                       transition-all duration-300 hover:from-primary-600 hover:to-primary-800 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-400">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-primary-400 hover:text-primary-300 transition-colors">Masuk</a>
    </p>
@endsection
