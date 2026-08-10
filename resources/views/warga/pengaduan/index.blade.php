@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')
@section('page-title', 'Pengaduan')
@section('page-subtitle', 'Riwayat pengaduan dan laporan Anda')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div class="flex justify-end">
        <a href="{{ route('warga.pengaduan.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-amber-600/25 transition-all duration-300 hover:shadow-amber-600/40 hover:scale-[1.02] active:scale-[0.98]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Kirim Pengaduan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 stagger-children">
        @forelse($complaints as $complaint)
            <div class="card-hover rounded-2xl border border-border bg-card p-5 shadow-sm">
                <div class="mb-3 flex items-center justify-between">
                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                        {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($complaint->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
                        {{ $complaint->status === 'pending' ? 'Pending' : ($complaint->status === 'process' ? 'Diproses' : 'Selesai') }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $complaint->created_at->diffForHumans() }}</span>
                </div>
                <h4 class="mb-2 text-sm font-bold text-slate-800">{{ $complaint->title }}</h4>
                <p class="mb-3 text-xs text-slate-500 line-clamp-2">{{ $complaint->description }}</p>
                @if($complaint->photo)
                    <div class="mb-3 overflow-hidden rounded-xl">
                        <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto" class="h-32 w-full object-cover">
                    </div>
                @endif
                @if($complaint->admin_response)
                    <div class="rounded-lg border border-primary-200 bg-primary-50 p-3">
                        <p class="text-[10px] font-semibold uppercase text-primary-600">Respon Admin</p>
                        <p class="text-xs text-primary-800">{{ $complaint->admin_response }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-border bg-card p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <p class="mt-3 text-sm text-slate-500">Belum ada pengaduan</p>
                <a href="{{ route('warga.pengaduan.create') }}" class="mt-4 inline-block text-sm font-semibold text-primary-600 hover:text-primary-700">Kirim pengaduan →</a>
            </div>
        @endforelse
    </div>

    @if($complaints->hasPages())
        <div class="flex justify-center">{{ $complaints->links() }}</div>
    @endif
</div>
@endsection
