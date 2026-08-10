@extends('layouts.guest')

@section('title', 'Menunggu Verifikasi')

@section('content')
    <div class="text-center">
        {{-- Icon --}}
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-amber-500/10 ring-4 ring-amber-500/20">
            <svg class="h-10 w-10 text-amber-400 animate-pulse-soft" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h2 class="mb-3 text-xl font-bold text-white">Menunggu Verifikasi</h2>
        <p class="mb-6 text-sm leading-relaxed text-slate-400">
            Akun Anda telah berhasil dibuat dan sedang menunggu verifikasi dari Pengurus RT.
            Silakan hubungi Pengurus RT Anda atau tunggu hingga akun Anda diverifikasi.
        </p>

        <div class="rounded-xl border border-primary-400/20 bg-primary-500/5 p-4">
            <div class="flex items-center gap-3 text-left">
                <svg class="h-5 w-5 shrink-0 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-primary-300/80">Setelah diverifikasi, Anda dapat mengakses semua fitur layanan RT/RW secara online.</p>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3">
            <a href="{{ route('pending-verification') }}"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white
                      transition-all duration-200 hover:bg-white/10">
                🔄 Refresh Status
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-slate-400
                               transition-all duration-200 hover:bg-white/10 hover:text-white" style="cursor: pointer;">
                    Keluar
                </button>
            </form>
        </div>
    </div>
@endsection
