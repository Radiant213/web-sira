@extends('layouts.app')

@section('title', 'Iuran Warga')
@section('page-title', 'Iuran Warga')
@section('page-subtitle', 'Kelola pembayaran iuran bulanan warga')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-border bg-card p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Terkumpul</p>
            <p class="mt-1 text-2xl font-bold text-emerald-600">Rp {{ number_format($totalCollected, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Belum Bayar</p>
            <p class="mt-1 text-2xl font-bold text-rose-600">{{ $totalUnpaid }} tagihan</p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.iuran.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari warga..."
                       class="w-full rounded-xl border border-border bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 sm:w-56">
            </div>
            <input type="month" name="month_year" value="{{ request('month_year') }}" onchange="this.form.submit()"
                   class="rounded-xl border border-border bg-white px-4 py-2.5 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
            <div class="w-full sm:w-48">
                @php 
                    $statusOptions = ['' => 'Semua Status', 'unpaid' => 'Belum Bayar', 'paid' => 'Lunas']; 
                @endphp
                <x-ui.select name="status" :options="$statusOptions" :value="request('status')" :submitOnChange="true" />
            </div>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('admin.iuran.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Input Iuran
            </a>
            {{-- Generate Batch --}}
            <div x-data="{ showGenerate: false }" class="relative">
                <button @click="showGenerate = !showGenerate" type="button"
                        class="inline-flex items-center gap-2 rounded-xl border border-border bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50" style="cursor: pointer;">
                    Generate
                </button>
                <div x-show="showGenerate" @click.away="showGenerate = false" x-transition
                     class="absolute right-0 top-12 z-10 w-72 rounded-xl border border-border bg-white p-4 shadow-xl" style="display:none">
                    <form method="POST" action="{{ route('admin.iuran.generate') }}" class="space-y-3">
                        @csrf
                        <p class="text-sm font-semibold text-slate-700">Generate Tagihan Batch</p>
                        <input type="month" name="month_year" required
                               class="w-full rounded-lg border border-border px-3 py-2 text-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                        <input type="number" name="amount" required placeholder="Jumlah (Rp)" min="0"
                               class="w-full rounded-lg border border-border px-3 py-2 text-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                        <button type="submit" class="w-full rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white hover:bg-primary-700" style="cursor: pointer;">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="border-b border-border bg-slate-50/50">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Warga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Bulan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tgl Bayar</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($dues as $due)
                        <tr class="transition-colors hover:bg-primary-50/50">
                            <td data-label="Warga" class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-800">{{ $due->user->name }}</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $due->user->nik }}</p>
                            </td>
                            <td data-label="Bulan" class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::createFromFormat('Y-m', $due->month_year)->translatedFormat('F Y') }}</td>
                            <td data-label="Jumlah" class="px-6 py-4 text-sm font-semibold text-slate-800">Rp {{ number_format($due->amount, 0, ',', '.') }}</td>
                            <td data-label="Status" class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                                    {{ $due->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $due->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </td>
                            <td data-label="Tgl Bayar" class="px-6 py-4 text-sm text-slate-500">{{ $due->payment_date ? $due->payment_date->format('d M Y') : '-' }}</td>
                            <td data-label="Aksi" class="px-6 py-4 text-right">
                                @if($due->status === 'unpaid')
                                    <form method="POST" action="{{ route('admin.iuran.markPaid', $due) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600 transition-colors hover:bg-emerald-100" style="cursor: pointer;">
                                            ✓ Bayar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
                                <p class="mt-3 text-sm text-slate-500">Belum ada data iuran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($dues->hasPages())
            <div class="border-t border-border px-6 py-4">{{ $dues->links() }}</div>
        @endif
    </div>
</div>
@endsection
