@extends('layouts.app')

@section('title', 'Pengaduan Warga')
@section('page-title', 'Pengaduan Warga')
@section('page-subtitle', 'Kelola pengaduan dan laporan dari warga')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Toolbar --}}
    <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau nama..."
                   class="w-full rounded-xl border border-border bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 sm:w-64">
        </div>
        <div class="w-full sm:w-48">
            @php 
                $statusOptions = ['' => 'Semua Status', 'pending' => 'Pending', 'process' => 'Diproses', 'resolved' => 'Selesai']; 
            @endphp
            <x-ui.select name="status" :options="$statusOptions" :value="request('status')" :submitOnChange="true" />
        </div>
    </form>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 stagger-children">
        @forelse($complaints as $complaint)
            <a href="{{ route('admin.pengaduan.show', $complaint) }}"
               class="card-hover group rounded-2xl border border-border bg-card p-5 shadow-sm block">
                <div class="mb-3 flex items-center justify-between">
                    <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                        {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($complaint->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
                        {{ $complaint->status === 'pending' ? 'Pending' : ($complaint->status === 'process' ? 'Diproses' : 'Selesai') }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $complaint->created_at->diffForHumans() }}</span>
                </div>
                <h4 class="mb-2 text-sm font-bold text-slate-800 group-hover:text-primary-600 transition-colors">{{ $complaint->title }}</h4>
                <p class="mb-3 text-xs text-slate-500 line-clamp-2">{{ $complaint->description }}</p>
                @if($complaint->photo)
                    <div class="mb-3 overflow-hidden rounded-xl">
                        <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Pengaduan"
                             class="h-32 w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-primary-400 to-primary-600 text-[10px] font-bold text-white">
                        {{ strtoupper(substr($complaint->user->name, 0, 1)) }}
                    </div>
                    <span class="text-xs text-slate-500">{{ $complaint->user->name }}</span>
                </div>
            </a>
        @empty
            <div class="col-span-full py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <p class="mt-3 text-sm text-slate-500">Belum ada pengaduan</p>
            </div>
        @endforelse
    </div>

    @if($complaints->hasPages())
        <div class="flex justify-center">{{ $complaints->links() }}</div>
    @endif
</div>
@endsection
