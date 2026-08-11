@extends('layouts.app')

@section('title', 'Data Warga')
@section('page-title', 'Data Warga')
@section('page-subtitle', 'Kelola data dan verifikasi akun warga')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Toolbar --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.warga.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, email..."
                       class="w-full rounded-xl border border-border bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 sm:w-72">
            </div>
            <div class="w-full sm:w-48">
                @php 
                    $statusOptions = ['' => 'Semua Status', 'verified' => 'Terverifikasi', 'unverified' => 'Belum Verifikasi']; 
                @endphp
                <x-ui.select name="status" :options="$statusOptions" :value="request('status')" :submitOnChange="true" />
            </div>
        </form>
        <a href="{{ route('admin.warga.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Warga
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="border-b border-border bg-slate-50/50">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Warga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NIK</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($warga as $w)
                        <tr class="transition-colors hover:bg-primary-50/50">
                            <td data-label="Warga" class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-primary-400 to-primary-600 text-sm font-bold text-white">
                                        {{ strtoupper(substr($w->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $w->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $w->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="NIK" class="px-6 py-4 text-sm font-mono text-slate-600">{{ $w->nik }}</td>
                            <td data-label="Kontak" class="px-6 py-4">
                                <p class="text-sm text-slate-600">{{ $w->phone ?? '-' }}</p>
                                <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ $w->address ?? '-' }}</p>
                            </td>
                            <td data-label="Status" class="px-6 py-4">
                                @if($w->is_verified)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700 animate-pulse-soft">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td data-label="Aksi" class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$w->is_verified)
                                        <form method="POST" action="{{ route('admin.warga.verify', $w) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-emerald-50 p-2 text-emerald-600 transition-colors hover:bg-emerald-100" title="Verifikasi" style="cursor: pointer;">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                        <div x-data="{ showModal: false }">
                                            <button @click="showModal = true" type="button" class="rounded-lg bg-red-50 p-2 text-red-600 transition-colors hover:bg-red-100" title="Tolak" style="cursor: pointer;">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            <template x-teleport="body">
                                                <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-0" style="display: none;">
                                                    <div x-show="showModal" 
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         @click="showModal = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
                                                    
                                                    <div x-show="showModal"
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl z-10 text-center text-wrap whitespace-normal">
                                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                        </div>
                                                        <h3 class="text-lg font-bold text-slate-800">Tolak Pendaftaran?</h3>
                                                        <p class="mt-2 text-sm text-slate-500">Anda yakin ingin menolak dan menghapus akun <b>{{ $w->name }}</b>? Tindakan ini tidak dapat dibatalkan.</p>
                                                        <div class="mt-6 flex justify-center gap-3">
                                                            <button @click="showModal = false" type="button" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors" style="cursor: pointer;">Batal</button>
                                                            <form method="POST" action="{{ route('admin.warga.reject', $w) }}">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="rounded-xl px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-colors" style="cursor: pointer;">Ya, Tolak</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    @endif
                                    <a href="{{ route('admin.warga.edit', $w) }}" class="rounded-lg bg-primary-50 p-2 text-primary-600 transition-colors hover:bg-primary-100" title="Edit">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <div x-data="{ showModal: false }">
                                        <button @click="showModal = true" type="button" class="rounded-lg bg-red-50 p-2 text-red-600 transition-colors hover:bg-red-100" title="Hapus" style="cursor: pointer;">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        <template x-teleport="body">
                                            <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-0" style="display: none;">
                                                <div x-show="showModal" 
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0"
                                                     @click="showModal = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
                                                
                                                <div x-show="showModal"
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                     class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl z-10 text-center text-wrap whitespace-normal">
                                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-slate-800">Hapus Data Warga?</h3>
                                                    <p class="mt-2 text-sm text-slate-500">Anda yakin ingin menghapus data warga <b>{{ $w->name }}</b>? Tindakan ini tidak dapat dibatalkan.</p>
                                                    <div class="mt-6 flex justify-center gap-3">
                                                        <button @click="showModal = false" type="button" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors" style="cursor: pointer;">Batal</button>
                                                        <form method="POST" action="{{ route('admin.warga.destroy', $w) }}">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="rounded-xl px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-colors" style="cursor: pointer;">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="mt-3 text-sm text-slate-500">Belum ada data warga</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($warga->hasPages())
            <div class="border-t border-border px-6 py-4">
                {{ $warga->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
