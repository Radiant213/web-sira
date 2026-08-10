@extends('layouts.app')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')
@section('page-subtitle', 'Review dan tindak lanjut pengaduan warga')

@section('content')
<div class="mx-auto max-w-3xl animate-fade-in-up space-y-6">
    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center justify-between">
            <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wide
                {{ $pengaduan->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($pengaduan->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
                {{ $pengaduan->status === 'pending' ? 'Pending' : ($pengaduan->status === 'process' ? 'Diproses' : 'Selesai') }}
            </span>
            <span class="text-sm text-slate-400">{{ $pengaduan->created_at->format('d M Y, H:i') }}</span>
        </div>

        <h3 class="mb-4 text-lg font-bold text-slate-800">{{ $pengaduan->title }}</h3>

        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-primary-400 to-primary-600 text-xs font-bold text-white">
                {{ strtoupper(substr($pengaduan->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-700">{{ $pengaduan->user->name }}</p>
                <p class="text-xs text-slate-400">NIK: {{ $pengaduan->user->nik }}</p>
            </div>
        </div>

        <p class="mb-4 text-sm text-slate-600 leading-relaxed">{{ $pengaduan->description }}</p>

        @if($pengaduan->photo)
            <div class="mb-4 overflow-hidden rounded-xl">
                <img src="{{ asset('storage/' . $pengaduan->photo) }}" alt="Foto Bukti" class="w-full rounded-xl">
            </div>
        @endif

        @if($pengaduan->admin_response)
            <div class="rounded-xl border border-primary-200 bg-primary-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary-600 mb-1">Respon Admin</p>
                <p class="text-sm text-primary-800">{{ $pengaduan->admin_response }}</p>
            </div>
        @endif
    </div>

    {{-- Update Status Form --}}
    @if($pengaduan->status !== 'resolved')
        <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
            <h4 class="mb-4 text-sm font-bold text-slate-700">Update Status</h4>
            <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $pengaduan) }}" class="space-y-4">
                @csrf @method('PATCH')

                @php $statusOptions = ['pending' => 'Pending', 'process' => 'Diproses', 'resolved' => 'Selesai']; @endphp
                <x-ui.select name="status" :options="$statusOptions" :value="$pengaduan->status" />

                <textarea name="admin_response" rows="3" placeholder="Tulis respon atau keterangan (opsional)..."
                          class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 resize-none">{{ $pengaduan->admin_response }}</textarea>

                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition-all duration-300 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    Update Status
                </button>
            </form>
        </div>
    @endif

    <a href="{{ route('admin.pengaduan.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
        ← Kembali ke daftar
    </a>
</div>
@endsection
