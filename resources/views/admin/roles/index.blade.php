@extends('layouts.app')

@section('title', 'Data Role')
@section('page-title', 'Manajemen Role')
@section('page-subtitle', 'Kelola hak akses dan peran (role) sistem')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Role</h2>
            <p class="text-sm text-slate-500">Kelola role yang ada di dalam sistem.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-primary-700 hover:shadow-md focus:ring-4 focus:ring-primary-500/30">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Role
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500 responsive-table">
                <thead class="bg-slate-50 text-xs uppercase text-slate-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Role</th>
                        <th class="px-6 py-4 font-semibold">Fungsi / Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border stagger-children">
                    @forelse($roles as $role)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800">{{ $role->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $role->description ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-500 transition-colors" title="Edit">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    
                                    @if(!in_array($role->name, ['admin', 'warga']))
                                        <div x-data="{ showModal: false }" class="inline-block">
                                            <button @click="showModal = true" type="button" class="rounded-lg p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors" title="Hapus" style="cursor: pointer;">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>

                                            {{-- Modal Konfirmasi --}}
                                            <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                                                    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
                                                    <div x-show="showModal" x-transition class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                            <div class="sm:flex sm:items-start">
                                                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                                    <h3 class="text-base font-semibold leading-6 text-slate-900">Hapus Role</h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus role <strong>{{ $role->name }}</strong>? Aksi ini tidak dapat dibatalkan.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" style="cursor: pointer;">Ya, Hapus</button>
                                                            </form>
                                                            <button @click="showModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto" style="cursor: pointer;">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Belum ada data role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($roles->hasPages())
            <div class="border-t border-border px-6 py-4">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
