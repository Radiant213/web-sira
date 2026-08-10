@extends('layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')
@section('page-subtitle', 'Ubah nama peran sistem')

@section('content')
<div class="mx-auto max-w-2xl animate-fade-in-up">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.roles.index') }}" class="rounded-xl bg-white p-2 text-slate-400 shadow-sm transition-colors hover:bg-slate-50 hover:text-slate-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Edit Role: {{ $role->name }}</h2>
    </div>

    <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Role</label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror" required>
                @error('name')
                    <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Fungsi / Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="3" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition-colors focus:border-primary-500 focus:bg-white focus:ring-primary-500 @error('description') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror" placeholder="Jelaskan fungsi dari role ini...">{{ old('description', $role->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('admin.roles.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/30" style="cursor: pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
