@extends('layouts.app')

@section('title', 'Kirim Pengaduan')
@section('page-title', 'Kirim Pengaduan')
@section('page-subtitle', 'Laporkan masalah di lingkungan Anda')

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

        <form method="POST" action="{{ route('warga.pengaduan.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="title" class="mb-1.5 block text-sm font-medium text-slate-700">Judul Pengaduan <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                       placeholder="Contoh: Lampu jalan padam di Gang Melati">
            </div>

            <div>
                <label for="description" class="mb-1.5 block text-sm font-medium text-slate-700">Deskripsi <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="5" required
                          class="w-full rounded-xl border border-border px-4 py-3 text-sm outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 resize-none"
                          placeholder="Jelaskan detail permasalahan, lokasi, dan waktu kejadian...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="photo" class="mb-1.5 block text-sm font-medium text-slate-700">Foto Bukti</label>
                <div x-data="{ preview: null }" class="space-y-3">
                    <div class="relative">
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg"
                               @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = e => preview = e.target.result; reader.readAsDataURL(file); }"
                               class="w-full rounded-xl border border-dashed border-slate-300 px-4 py-6 text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100 transition-colors cursor-pointer">
                    </div>
                    <template x-if="preview">
                        <div class="overflow-hidden rounded-xl border border-border">
                            <img :src="preview" alt="Preview" class="h-48 w-full object-cover">
                        </div>
                    </template>
                    <p class="text-xs text-slate-400">Format: JPG, JPEG, PNG. Maksimal 20MB.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-border pt-5">
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-amber-600/25 transition-all duration-300 hover:shadow-amber-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                    Kirim Pengaduan
                </button>
                <a href="{{ route('warga.pengaduan.index') }}" class="rounded-xl border border-border px-6 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
