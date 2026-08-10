@extends('layouts.app')

@section('title', 'Input Iuran')
@section('page-title', 'Input Iuran')
@section('page-subtitle', 'Catat pembayaran iuran warga')

@section('content')
<div class="mx-auto max-w-2xl animate-fade-in-up">
    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8">
        @if($errors->any())
            <x-ui.alert type="error" class="mb-6">
                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('admin.iuran.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="user_id" class="mb-1.5 block text-sm font-medium text-slate-700">Warga <span class="text-red-500">*</span></label>
                @php
                    $wargaOptions = [];
                    foreach($warga as $w) {
                        $wargaOptions[$w->id] = $w->name . ' (' . $w->nik . ')';
                    }
                @endphp
                <x-ui.select name="user_id" :options="$wargaOptions" :value="old('user_id')" :searchable="true" placeholder="Pilih warga..." />
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="month_year" class="mb-1.5 block text-sm font-medium text-slate-700">Bulan <span class="text-red-500">*</span></label>
                    <input type="month" id="month_year" name="month_year" value="{{ old('month_year', now()->format('Y-m')) }}" required
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                </div>
                <div>
                    <label for="amount" class="mb-1.5 block text-sm font-medium text-slate-700">Jumlah (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" required min="0"
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                           placeholder="50000">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-medium text-slate-700">Status</label>
                    @php $statusOptions = ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas']; @endphp
                    <x-ui.select name="status" :options="$statusOptions" value="paid" />
                </div>
                <div>
                    <label for="payment_date" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Bayar</label>
                    <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                           class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-border pt-5">
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    Simpan
                </button>
                <a href="{{ route('admin.iuran.index') }}" class="rounded-xl border border-border px-6 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
