@php
    $isAdmin = auth()->user()->isAdmin();
    $prefix = $isAdmin ? 'admin' : 'warga';
@endphp

<aside
    :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', sidebarCollapsed ? 'lg:w-20' : 'lg:w-72']"
    class="fixed inset-y-0 left-0 z-50 transform bg-sidebar transition-all duration-300 ease-in-out lg:relative lg:translate-x-0 lg:z-auto flex flex-col overflow-y-hidden"
>
    {{-- Logo Section --}}
    <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6 overflow-hidden">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white/10 ring-1 ring-white/20"
             :class="sidebarCollapsed ? 'mx-auto' : ''">
            <img src="{{ asset('images/logo.jpg') }}" alt="SIRA" class="h-full w-full object-cover">
        </div>
        <div x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms class="whitespace-nowrap">
            <h2 class="text-lg font-bold text-white tracking-tight">SIRA</h2>
            <p class="text-[10px] font-medium uppercase tracking-widest text-primary-300/60">RT/RW Digital</p>
        </div>
        <button @click="sidebarOpen = false" class="ml-auto rounded-lg p-1.5 text-slate-400 hover:bg-white/10 hover:text-white transition-colors lg:hidden" style="cursor: pointer;">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-1 scrollbar-hide">
        <p x-show="!sidebarCollapsed" class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500 whitespace-nowrap">Menu Utama</p>
        <p x-show="sidebarCollapsed" class="mb-3 text-center text-[10px] font-semibold uppercase tracking-widest text-slate-500">•••</p>

        @if($isAdmin)
            {{-- Admin Navigation --}}
            <a href="{{ route('admin.dashboard') }}" title="Dashboard"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('admin.warga.index') }}" title="Data Warga"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.warga.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Warga</span>
                @php $pendingCount = \App\Models\User::where('role','warga')->where('is_verified', false)->count(); @endphp
                @if($pendingCount > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 px-1.5 text-center text-[10px] font-bold leading-none text-white animate-pulse-soft">{{ $pendingCount }}</span>
                    <span x-show="sidebarCollapsed" class="absolute right-2 top-2 h-2 w-2 rounded-full bg-amber-500 animate-pulse-soft"></span>
                @endif
            </a>
            
            <a href="{{ route('admin.users.index') }}" title="Data User"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.users.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data User</span>
            </a>

            <a href="{{ route('admin.roles.index') }}" title="Manajemen Role"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.roles.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Manajemen Role</span>
            </a>

            <a href="{{ route('admin.surat.index') }}" title="Surat Pengantar"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.surat.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Surat Pengantar</span>
                @php $suratPending = \App\Models\LetterRequest::pending()->count(); @endphp
                @if($suratPending > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 px-1.5 text-center text-[10px] font-bold leading-none text-white animate-pulse-soft">{{ $suratPending }}</span>
                    <span x-show="sidebarCollapsed" class="absolute right-2 top-2 h-2 w-2 rounded-full bg-amber-500 animate-pulse-soft"></span>
                @endif
            </a>

            <a href="{{ route('admin.pengaduan.index') }}" title="Pengaduan"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.pengaduan.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Pengaduan</span>
                @php $pengaduanActive = \App\Models\Complaint::where('status','!=','resolved')->count(); @endphp
                @if($pengaduanActive > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto flex h-5 min-w-[20px] items-center justify-center rounded-full bg-rose-500 px-1.5 text-center text-[10px] font-bold leading-none text-white animate-pulse-soft">{{ $pengaduanActive }}</span>
                    <span x-show="sidebarCollapsed" class="absolute right-2 top-2 h-2 w-2 rounded-full bg-rose-500 animate-pulse-soft"></span>
                @endif
            </a>

            <a href="{{ route('admin.iuran.index') }}" title="Iuran Warga"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.iuran.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Iuran Warga</span>
            </a>
        @else
            {{-- Warga Navigation --}}
            <a href="{{ route('warga.dashboard') }}" title="Dashboard"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('warga.dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('warga.surat.index') }}" title="Surat Pengantar"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('warga.surat.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Surat Pengantar</span>
            </a>

            <a href="{{ route('warga.pengaduan.index') }}" title="Pengaduan"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('warga.pengaduan.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Pengaduan</span>
            </a>

            <a href="{{ route('warga.iuran.index') }}" title="Iuran Bulanan"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('warga.iuran.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
               :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Iuran Bulanan</span>
            </a>
        @endif
    </nav>

    {{-- Logout --}}
    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Keluar" style="cursor: pointer;"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400 transition-all duration-200 hover:bg-red-500/10 hover:text-red-400"
                    :class="sidebarCollapsed ? 'justify-center px-0' : ''">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>
