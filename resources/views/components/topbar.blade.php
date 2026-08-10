<header class="flex h-16 items-center justify-between border-b border-border bg-card px-4 sm:px-6 lg:px-8 shadow-sm">
    {{-- Left: Hamburger + Page Title --}}
    <div class="flex items-center gap-4">
        <button @click="window.innerWidth < 1024 ? sidebarOpen = !sidebarOpen : sidebarCollapsed = !sidebarCollapsed" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors" style="cursor: pointer;">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
            <p class="hidden text-xs text-slate-400 sm:block">@yield('page-subtitle', '')</p>
        </div>
    </div>

    {{-- Right: Notifications & User Menu --}}
    <div class="flex items-center gap-2">
        {{-- Notifications --}}
        @php
            $unreadNotifications = auth()->user()->unreadNotifications;
        @endphp
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors" style="cursor: pointer;">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                @if($unreadNotifications->count() > 0)
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                @endif
            </button>
            
            <div x-show="open" x-transition.opacity class="absolute right-0 mt-2 w-80 rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden" style="display: none;">
                <div class="border-b border-slate-100 bg-slate-50 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-800">Notifikasi</h3>
                    @if($unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[10px] font-semibold uppercase tracking-wider text-primary-600 hover:text-primary-800" style="cursor: pointer;">Tandai Dibaca</button>
                        </form>
                    @endif
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block border-b border-slate-50 px-4 py-3 hover:bg-slate-50 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-primary-50/30' }}">
                            <p class="text-sm font-semibold text-slate-800">{{ $notification->data['title'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $notification->data['message'] }}</p>
                            <p class="text-[10px] text-slate-400 mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-50">
                                <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">Belum ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="h-6 w-px bg-slate-200 mx-2"></div>
        <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="hidden items-center gap-2 sm:flex hover:bg-slate-50 p-1.5 rounded-xl transition-colors" style="cursor: pointer;">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400">{{ auth()->user()->isAdmin() ? 'Admin' : 'Warga' }}</p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-700 text-sm font-bold text-white shadow-md">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="userMenuOpen" x-transition.opacity class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden" style="display: none;">
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
