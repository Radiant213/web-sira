@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas terkini RT/RW')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 stagger-children">
        {{-- Total Warga --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Warga</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($stats['total_warga']) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            @if($stats['warga_pending'] > 0)
                <div class="mt-3 flex items-center gap-1 text-xs text-amber-600">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse-soft"></span>
                    {{ $stats['warga_pending'] }} menunggu verifikasi
                </div>
            @endif
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-primary-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>

        {{-- Surat Pending --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Surat Pending</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($stats['surat_pending']) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-amber-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>

        {{-- Pengaduan Aktif --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pengaduan Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-rose-600">{{ number_format($stats['pengaduan_pending']) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-rose-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>

        {{-- Total Iuran --}}
        <div class="card-hover group relative overflow-hidden rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Iuran Terkumpul</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-bold text-emerald-600 flex items-baseline gap-1">
                        <span>Rp</span>
                        <span>{{ number_format($stats['total_iuran'], 0, ',', '.') }}</span>
                    </p>
                    <div class="mt-3 text-xs text-rose-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse-soft"></span>
                        {{ $stats['iuran_belum_bayar'] }} belum bayar
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-emerald-500/5 transition-transform duration-300 group-hover:scale-150"></div>
        </div>
    </div>

    {{-- Chart & Export Section --}}
    <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Grafik Aktivitas SIRA</h3>
            
            {{-- Form Export Hidden --}}
            <form id="exportForm" action="{{ route('admin.dashboard.export') }}" method="POST">
                @csrf
                <input type="hidden" name="chart_image" id="chart_image">
                <button type="button" onclick="exportDashboard()" class="inline-flex items-center gap-2 rounded-xl bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-600 transition-colors hover:bg-primary-100" style="cursor: pointer;">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </button>
            </form>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Recent Letters --}}
        <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800">Surat Terbaru</h3>
                <a href="{{ route('admin.surat.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentLetters as $letter)
                    <a href="{{ route('admin.surat.show', $letter) }}" class="flex items-center gap-3 rounded-xl p-3 transition-colors hover:bg-slate-50">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                            {{ $letter->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($letter->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-700">{{ $letter->letter_type }}</p>
                            <p class="text-xs text-slate-400">{{ $letter->user->name }} • {{ $letter->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                            {{ $letter->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($letter->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                            {{ $letter->status === 'pending' ? 'Pending' : ($letter->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </a>
                @empty
                    <div class="py-8 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="mt-2 text-sm text-slate-400">Belum ada pengajuan surat</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Complaints --}}
        <div class="rounded-2xl border border-border bg-card p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800">Pengaduan Terbaru</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentComplaints as $complaint)
                    <a href="{{ route('admin.pengaduan.show', $complaint) }}" class="flex items-center gap-3 rounded-xl p-3 transition-colors hover:bg-slate-50">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                            {{ $complaint->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($complaint->status === 'process' ? 'bg-primary-50 text-primary-600' : 'bg-emerald-50 text-emerald-600') }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-700">{{ $complaint->title }}</p>
                            <p class="text-xs text-slate-400">{{ $complaint->user->name }} • {{ $complaint->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide
                            {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($complaint->status === 'process' ? 'bg-primary-100 text-primary-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $complaint->status === 'pending' ? 'Pending' : ($complaint->status === 'process' ? 'Diproses' : 'Selesai') }}
                        </span>
                    </a>
                @empty
                    <div class="py-8 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <p class="mt-2 text-sm text-slate-400">Belum ada pengaduan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Surat Pending', 'Pengaduan Aktif', 'Warga Baru/Belum Verifikasi'],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $stats['surat_pending'] }},
                        {{ $stats['pengaduan_pending'] }},
                        {{ $stats['warga_pending'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.2)', // amber
                        'rgba(225, 29, 72, 0.2)', // rose
                        'rgba(16, 185, 129, 0.2)'  // emerald
                    ],
                    borderColor: [
                        'rgb(245, 158, 11)',
                        'rgb(225, 29, 72)',
                        'rgb(16, 185, 129)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        window.exportDashboard = function() {
            const chartImage = dashboardChart.toBase64Image();
            document.getElementById('chart_image').value = chartImage;
            document.getElementById('exportForm').submit();
        }
    });
</script>
@endpush
