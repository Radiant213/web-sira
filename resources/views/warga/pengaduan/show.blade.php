@extends('layouts.app')

@section('title', 'Detail Pengaduan Lingkungan')
@section('page-title', 'Detail Pengaduan')
@section('page-subtitle', 'Informasi dan status tindak lanjut keluhan warga')

@section('content')
<div class="mx-auto max-w-3xl space-y-6 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <a href="{{ route('warga.pengaduan.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pengaduan
        </a>

        <span class="rounded-full px-3.5 py-1.5 text-xs font-bold uppercase tracking-wide
            {{ $pengaduan->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($pengaduan->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
            {{ $pengaduan->status === 'pending' ? 'Menunggu Review' : ($pengaduan->status === 'process' ? 'Sedang Ditindaklanjuti' : 'Selesai Ditangani') }}
        </span>
    </div>

    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8 space-y-6">
        <div class="border-b border-border pb-6">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-600">Topik Pengaduan</span>
            <h3 class="mt-1 text-xl font-bold text-slate-800">{{ $pengaduan->title }}</h3>
            <p class="mt-1 text-xs text-slate-400">Dilaporkan pada: {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Deskripsi Masalah</span>
            <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-relaxed text-slate-700 border border-slate-100">
                {{ $pengaduan->description }}
            </div>
        </div>

        @if($pengaduan->photo)
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lampiran Foto Bukti</span>
                <div class="mt-2 overflow-hidden rounded-xl border border-border">
                    <img src="{{ asset('storage/' . $pengaduan->photo) }}" alt="Foto Bukti" class="h-64 w-full object-cover">
                </div>
            </div>
        @endif

        @if($pengaduan->admin_response)
            <div class="rounded-xl border border-primary-200 bg-primary-50/80 p-5">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-primary-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <div>
                        <h5 class="text-xs font-bold uppercase tracking-wider text-primary-700">Tanggapan & Penanganan Pengurus RT</h5>
                        <p class="mt-1 text-sm text-slate-700 leading-relaxed">{{ $pengaduan->admin_response }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-500 italic">
                Laporan ini sedang dalam antrean pengurus RT/RW dan akan segera direspons.
            </div>
        @endif
    </div>
</div>
@endsection
