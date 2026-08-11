@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <h2 class="mb-6 text-center text-xl font-bold text-white">Lupa Password?</h2>
    <p class="mb-6 text-center text-sm text-slate-400">
        Masukkan email yang terdaftar untuk menerima kode OTP reset password.
    </p>

    {{-- Notifikasi Error --}}
    @if($errors->any())
        <x-ui.alert type="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-200">
            <div class="space-y-1 mt-0.5">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </x-ui.alert>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Alamat Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required 
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500
                          outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2" 
                   placeholder="nama@email.com" value="{{ old('email') }}">
        </div>

        <div>
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30
                       transition-all duration-300 hover:from-primary-600 hover:to-primary-800 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                Kirim Kode OTP
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm">
        <a href="{{ route('login') }}" class="font-semibold text-primary-400 hover:text-primary-300 transition-colors">
            Kembali ke halaman Login
        </a>
    </div>
@endsection
