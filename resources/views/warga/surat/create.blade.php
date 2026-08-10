@extends('layouts.app')

@section('title', 'Ajukan Surat Pengantar')
@section('page-title', 'Ajukan Surat Pengantar')
@section('page-subtitle', 'Buat pengajuan surat pengantar baru')

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

        <form method="POST" action="{{ route('warga.surat.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="letter_type" class="mb-1.5 block text-sm font-medium text-slate-700">Jenis Surat <span class="text-red-500">*</span></label>
                @php
                    $letterTypes = [
                        'Pengantar KTP' => 'Pengantar KTP',
                        'Pengantar SKCK' => 'Pengantar SKCK',
                        'Pengantar Kelahiran' => 'Pengantar Kelahiran',
                        'Pengantar Kematian' => 'Pengantar Kematian',
                        'Pengantar Pindah' => 'Pengantar Pindah',
                        'Keterangan Domisili' => 'Keterangan Domisili',
                        'Keterangan Tidak Mampu' => 'Keterangan Tidak Mampu',
                        'Lainnya' => 'Lainnya',
                    ];
                @endphp
                <x-ui.select name="letter_type" :options="$letterTypes" placeholder="Pilih jenis surat..." />
            </div>

            <div>
                <label for="purpose" class="mb-1.5 block text-sm font-medium text-slate-700">Keperluan / Alasan <span class="text-red-500">*</span></label>
                <textarea id="purpose" name="purpose" rows="4" required
                          class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 resize-none"
                          placeholder="Jelaskan keperluan pembuatan surat ini...">{{ old('purpose') }}</textarea>
            </div>

            <x-ui.alert type="info" :dismissible="false">
                Pengajuan surat akan diverifikasi oleh Pengurus RT. Setelah disetujui, surat akan tersedia untuk dicetak.
                Proses verifikasi biasanya memakan waktu 1-3 hari kerja.
            </x-ui.alert>

            <div class="flex items-center gap-3 border-t border-border pt-5">
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    Kirim Pengajuan
                </button>
                <a href="{{ route('warga.surat.index') }}" class="rounded-xl border border-border px-6 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
