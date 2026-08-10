@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h2 class="mb-6 text-center text-xl font-bold text-white">Masuk ke Akun Anda</h2>

    @if($errors->any())
        <x-ui.alert type="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-200">
            <div class="space-y-1 mt-0.5">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </x-ui.alert>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                   placeholder="nama@email.com">
        </div>

        {{-- Password --}}
        <div>
            <div class="mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
            </div>
            <div class="relative" x-data="{ showPass: false }">
                <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 pr-12 text-sm text-white placeholder-slate-500
                              outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2"
                       placeholder="••••••••">
                <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors" style="cursor: pointer;">
                    <svg x-show="!showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </div>

        {{-- Remember & Forgot Password --}}
        <div class="mb-6 flex items-center justify-between">
            <x-ui.checkbox name="remember" class="!border-white/20 !bg-white/5 !text-primary-500 peer-checked:!border-primary-500 peer-checked:!bg-primary-500">
                <span class="text-slate-300 group-hover:text-white">Ingat saya</span>
            </x-ui.checkbox>
            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-semibold text-primary-400 hover:text-primary-300 transition-colors">Lupa password?</a>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30
                       transition-all duration-300 hover:from-primary-600 hover:to-primary-800 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
            Masuk
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-400">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-primary-400 hover:text-primary-300 transition-colors">Daftar Sekarang</a>
    </p>
@endsection
