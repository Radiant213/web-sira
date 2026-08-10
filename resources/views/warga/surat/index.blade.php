@extends('layouts.app')

@section('title', 'Riwayat Surat')
@section('page-title', 'Surat Pengantar')
@section('page-subtitle', 'Riwayat pengajuan surat pengantar Anda')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div class="flex justify-end">
        <a href="{{ route('warga.surat.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan Surat Baru
        </a>
    </div>

    <div class="space-y-4 stagger-children">
        @forelse($letters as $letter)
            <div class="card-hover rounded-2xl border border-border bg-card p-5 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl
                            {{ $letter->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($letter->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">{{ $letter->letter_type }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-1">{{ $letter->purpose }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $letter->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wide
                            {{ $letter->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($letter->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                            {{ $letter->status === 'pending' ? 'Pending' : ($letter->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </div>
                </div>
                @if($letter->status === 'rejected' && $letter->rejection_reason)
                    <div class="mt-3 rounded-lg border border-red-200 bg-red-50 p-3">
                        <p class="text-xs text-red-700"><strong>Alasan penolakan:</strong> {{ $letter->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="rounded-2xl border border-border bg-card p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="mt-3 text-sm text-slate-500">Belum ada pengajuan surat</p>
                <a href="{{ route('warga.surat.create') }}" class="mt-4 inline-block text-sm font-semibold text-primary-600 hover:text-primary-700">Ajukan sekarang →</a>
            </div>
        @endforelse
    </div>

    @if($letters->hasPages())
        <div class="flex justify-center">{{ $letters->links() }}</div>
    @endif
</div>
@endsection
