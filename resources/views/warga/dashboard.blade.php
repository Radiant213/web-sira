@extends('layouts.app')

@section('title', 'Dashboard Warga')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 stagger-children">
        {{-- Surat --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Surat Pengantar</p>
                    <p class="mt-2 text-3xl font-bold text-primary-600">{{ $stats['surat_pending'] + $stats['surat_approved'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-3 text-xs">
                @if($stats['surat_pending'] > 0)
                    <span class="flex items-center gap-1 text-amber-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse-soft"></span>
                        {{ $stats['surat_pending'] }} pending
                    </span>
                @endif
                <span class="text-emerald-600">{{ $stats['surat_approved'] }} disetujui</span>
            </div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-primary-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>

        {{-- Pengaduan --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pengaduan</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['pengaduan_pending'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-emerald-600">{{ $stats['pengaduan_resolved'] }} selesai</div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-amber-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>

        {{-- Iuran --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Iuran Bulanan</p>
                </div>
                <div>
                    @if($currentDue)
                        <p class="text-xl sm:text-2xl font-bold {{ $currentDue->status === 'paid' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $currentDue->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500 flex items-baseline gap-1">
                            <span>Rp</span>
                            <span>{{ number_format($currentDue->amount, 0, ',', '.') }}</span>
                        </p>
                    @else
                        <p class="text-xl sm:text-2xl font-bold text-slate-400">Tidak ada tagihan</p>
                    @endif
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-emerald-500/5 transition-transform duration-300 group-hover:scale-150"></div>
            @if($stats['iuran_unpaid'] > 0)
                <div class="mt-3 flex items-center gap-1 text-xs text-rose-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse-soft"></span>
                    {{ $stats['iuran_unpaid'] }} bulan belum bayar
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <a href="{{ route('warga.surat.create') }}"
           class="card-hover flex items-center gap-4 rounded-2xl border border-border bg-card p-5 shadow-sm transition-colors hover:border-primary-200">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 text-white shadow-lg shadow-primary-600/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">Ajukan Surat Pengantar</p>
                <p class="text-xs text-slate-400">Buat pengajuan surat baru</p>
            </div>
        </a>
        <a href="{{ route('warga.pengaduan.create') }}"
           class="card-hover flex items-center gap-4 rounded-2xl border border-border bg-card p-5 shadow-sm transition-colors hover:border-amber-200">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-600/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">Kirim Pengaduan</p>
                <p class="text-xs text-slate-400">Laporkan masalah di lingkungan</p>
            </div>
        </a>
    </div>

    {{-- Recent Activities --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800">Surat Terbaru</h3>
                <a href="{{ route('warga.surat.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentLetters as $letter)
                    <div class="flex items-center gap-3 rounded-xl p-3 hover:bg-slate-50 transition-colors">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                            {{ $letter->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($letter->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-700">{{ $letter->letter_type }}</p>
                            <p class="text-xs text-slate-400">{{ $letter->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase
                            {{ $letter->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($letter->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                            {{ $letter->status === 'pending' ? 'Pending' : ($letter->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-slate-400">Belum ada pengajuan surat</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800">Pengaduan Terbaru</h3>
                <a href="{{ route('warga.pengaduan.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentComplaints as $complaint)
                    <div class="flex items-center gap-3 rounded-xl p-3 hover:bg-slate-50 transition-colors">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                            {{ $complaint->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($complaint->status === 'process' ? 'bg-primary-50 text-primary-600' : 'bg-emerald-50 text-emerald-600') }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-700">{{ $complaint->title }}</p>
                            <p class="text-xs text-slate-400">{{ $complaint->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase
                            {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($complaint->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $complaint->status === 'pending' ? 'Pending' : ($complaint->status === 'process' ? 'Diproses' : 'Selesai') }}
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-slate-400">Belum ada pengaduan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
