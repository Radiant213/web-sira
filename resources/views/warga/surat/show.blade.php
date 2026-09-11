@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('page-title', 'Detail Surat')
@section('page-subtitle', 'Informasi lengkap status pengajuan surat pengantar Anda')

@section('content')
<div class="mx-auto max-w-3xl space-y-6 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <a href="{{ route('warga.surat.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Riwayat
        </a>

        <span class="rounded-full px-3.5 py-1.5 text-xs font-bold uppercase tracking-wide
            {{ $surat->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($surat->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
            {{ $surat->status === 'pending' ? 'Menunggu Persetujuan' : ($surat->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
        </span>
    </div>

    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8 space-y-6">
        <div class="border-b border-border pb-6">
            <span class="text-xs font-semibold uppercase tracking-wider text-primary-600">Jenis Surat</span>
            <h3 class="mt-1 text-xl font-bold text-slate-800">{{ $surat->letter_type }}</h3>
            <p class="mt-1 text-xs text-slate-400">Diajukan pada: {{ $surat->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keperluan Pengajuan</span>
            <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-relaxed text-slate-700 border border-slate-100">
                {{ $surat->purpose }}
            </div>
        </div>

        @if($surat->status === 'rejected' && $surat->rejection_reason)
            <div class="rounded-xl border border-red-200 bg-red-50/80 p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <h5 class="text-xs font-bold uppercase tracking-wider text-red-700">Catatan Penolakan oleh Pengurus</h5>
                        <p class="mt-1 text-sm text-red-700">{{ $surat->rejection_reason }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($surat->status === 'approved')
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/80 p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h5 class="text-xs font-bold uppercase tracking-wider text-emerald-800">Surat Telah Diverifikasi</h5>
                        <p class="mt-1 text-sm text-emerald-700">Surat pengantar Anda telah disetujui oleh pengurus RT/RW. Anda dapat mengambil berkas fisik yang telah ditandatangani dan dicap di kantor sekretariat RT atau mengunduh salinan digital jika disediakan.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
