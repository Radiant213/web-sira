@extends('layouts.app')

@section('title', 'Surat Pengantar')
@section('page-title', 'Surat Pengantar')
@section('page-subtitle', 'Kelola pengajuan surat pengantar warga')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Toolbar --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.surat.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..."
                       class="w-full rounded-xl border border-border bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 sm:w-64">
            </div>
            <div class="w-full sm:w-48">
                @php 
                    $statusOptions = ['' => 'Semua Status', 'pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak']; 
                @endphp
                <x-ui.select name="status" :options="$statusOptions" :value="request('status')" :submitOnChange="true" />
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="border-b border-border bg-slate-50/50">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Pemohon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis Surat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Keperluan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($letters as $letter)
                        <tr class="transition-colors hover:bg-primary-50/50">
                            <td data-label="Pemohon" class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-800">{{ $letter->user->name }}</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $letter->user->nik }}</p>
                            </td>
                            <td data-label="Jenis Surat" class="px-6 py-4 text-sm text-slate-700">{{ $letter->letter_type }}</td>
                            <td data-label="Keperluan" class="px-6 py-4 text-sm text-slate-600 max-w-[200px] truncate">{{ $letter->purpose }}</td>
                            <td data-label="Status" class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                                    {{ $letter->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($letter->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $letter->status === 'pending' ? 'Pending' : ($letter->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                </span>
                            </td>
                            <td data-label="Tanggal" class="px-6 py-4 text-sm text-slate-500">{{ $letter->created_at->format('d M Y') }}</td>
                            <td data-label="Aksi" class="px-6 py-4 text-right">
                                <a href="{{ route('admin.surat.show', $letter) }}" class="rounded-lg bg-primary-50 p-2 text-primary-600 transition-colors hover:bg-primary-100 inline-block" title="Detail">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="mt-3 text-sm text-slate-500">Belum ada pengajuan surat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($letters->hasPages())
            <div class="border-t border-border px-6 py-4">{{ $letters->links() }}</div>
        @endif
    </div>
</div>
@endsection
