@extends('layouts.guest')

@section('title', 'Verifikasi Keamanan Admin')

@section('content')
    <h2 class="mb-6 text-center text-xl font-bold text-white">Verifikasi Keamanan Admin</h2>
    <p class="mb-6 text-center text-sm text-slate-400">
        Untuk alasan keamanan, kami telah mengirimkan 6 digit kode OTP ke email Anda. Silakan masukkan kode tersebut untuk melanjutkan login ke Dashboard Admin.
    </p>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <x-ui.alert type="success" class="mb-6 !bg-emerald-500/10 !border-emerald-500/20 !text-emerald-200">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    {{-- Notifikasi Info --}}
    @if(session('info'))
        <x-ui.alert type="info" class="mb-6 !bg-blue-500/10 !border-blue-500/20 !text-blue-200">
            {{ session('info') }}
        </x-ui.alert>
    @endif

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

    <form action="{{ route('admin.2fa') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium leading-6 text-slate-300 mb-2 text-center">Kode OTP</label>
            <input id="otp" name="otp" type="text" maxlength="6" required 
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-center text-2xl font-bold tracking-[1em] text-white placeholder-slate-500 outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2" 
                   placeholder="------">
        </div>

        <div>
            <button type="submit" class="mt-4 w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30
                       transition-all duration-300 hover:from-primary-600 hover:to-primary-800 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                Verifikasi & Login
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm text-slate-400">
        Belum menerima email?
        <form action="{{ route('admin.2fa.resend') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="font-semibold text-primary-400 hover:text-primary-300 bg-transparent border-none p-0 cursor-pointer transition-colors">
                Kirim Ulang
            </button>
        </form>
    </div>
@endsection
