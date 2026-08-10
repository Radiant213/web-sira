@extends('layouts.app')

@section('title', 'Iuran Bulanan')
@section('page-title', 'Iuran Bulanan')
@section('page-subtitle', 'Riwayat tagihan dan pembayaran iuran Anda')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-border bg-card p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Dibayar</p>
            <p class="mt-1 text-2xl font-bold text-emerald-600">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Belum Dibayar</p>
            <p class="mt-1 text-2xl font-bold text-rose-600">{{ $totalUnpaid }} bulan</p>
        </div>
    </div>

    {{-- List --}}
    <div class="space-y-3 stagger-children">
        @forelse($dues as $due)
            <div class="flex items-center justify-between rounded-2xl border border-border bg-card p-4 shadow-sm sm:p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl
                        {{ $due->status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                        @if($due->status === 'paid')
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::createFromFormat('Y-m', $due->month_year)->translatedFormat('F Y') }}</p>
                        <p class="text-xs text-slate-400">
                            @if($due->payment_date)
                                Dibayar {{ $due->payment_date->format('d M Y') }}
                            @else
                                Belum dibayar
                            @endif
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-slate-800">Rp {{ number_format($due->amount, 0, ',', '.') }}</p>
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide
                        {{ $due->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $due->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-border bg-card p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
                <p class="mt-3 text-sm text-slate-500">Belum ada data iuran</p>
            </div>
        @endforelse
    </div>

    @if($dues->hasPages())
        <div class="flex justify-center">{{ $dues->links() }}</div>
    @endif
</div>
@endsection
