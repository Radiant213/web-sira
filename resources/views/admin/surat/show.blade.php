@extends('layouts.app')

@section('title', 'Detail Surat')
@section('page-title', 'Detail Surat Pengantar')
@section('page-subtitle', 'Review dan tindak lanjut pengajuan surat')

@section('content')
<div class="mx-auto max-w-3xl animate-fade-in-up space-y-6">
    {{-- Detail Card --}}
    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center justify-between">
            <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wide
                {{ $surat->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($surat->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                {{ $surat->status === 'pending' ? 'Pending' : ($surat->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
            </span>
            <span class="text-sm text-slate-400">{{ $surat->created_at->format('d M Y, H:i') }}</span>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Pemohon</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $surat->user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">NIK</p>
                <p class="mt-1 text-sm font-mono text-slate-700">{{ $surat->user->nik }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat</p>
                <p class="mt-1 text-sm text-slate-700">{{ $surat->user->address ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis Surat</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $surat->letter_type }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keperluan</p>
                <p class="mt-1 text-sm text-slate-700 leading-relaxed">{{ $surat->purpose }}</p>
            </div>

            @if($surat->status === 'rejected' && $surat->rejection_reason)
                <div class="sm:col-span-2">
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-red-600">Alasan Penolakan</p>
                        <p class="mt-1 text-sm text-red-700">{{ $surat->rejection_reason }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    @if($surat->status === 'pending')
        <div class="flex flex-col gap-4 sm:flex-row">
            {{-- Approve --}}
            <form method="POST" action="{{ route('admin.surat.approve', $surat) }}" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all duration-300 hover:shadow-emerald-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    ✓ Setujui Surat
                </button>
            </form>

            {{-- Reject --}}
            <div class="flex-1" x-data="{ showReject: false }">
                <button @click="showReject = !showReject" type="button"
                        class="w-full rounded-xl border border-red-200 bg-red-50 px-6 py-3 text-sm font-semibold text-red-600 transition-all duration-200 hover:bg-red-100" style="cursor: pointer;">
                    ✕ Tolak Surat
                </button>
                <form method="POST" action="{{ route('admin.surat.reject', $surat) }}" x-show="showReject" x-transition class="mt-3" style="display:none">
                    @csrf @method('PATCH')
                    <textarea name="rejection_reason" required rows="3" placeholder="Tuliskan alasan penolakan..."
                              class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-red-500 focus:ring-2 focus:ring-red-500/20 resize-none"></textarea>
                    <button type="submit" class="mt-2 w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-red-700" style="cursor: pointer;">Kirim Penolakan</button>
                </form>
            </div>
        </div>
    @endif

    @if($surat->status === 'approved')
        <a href="{{ route('admin.surat.print', $surat) }}" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Surat PDF
        </a>
    @endif

    <a href="{{ route('admin.surat.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
        ← Kembali ke daftar
    </a>
</div>
@endsection
