@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white/80 backdrop-blur-xl px-4 py-8 shadow sm:rounded-2xl sm:px-10 border border-white/20">
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Lupa Password?</h2>
            <p class="mt-2 text-sm text-slate-600">
                Masukkan email yang terdaftar untuk menerima kode OTP reset password.
            </p>
        </div>

        {{-- Notifikasi Error --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Alamat Email</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 px-4 transition-all" placeholder="contoh@email.com" value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center rounded-xl bg-primary-600 px-3 py-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">
                    Kirim Kode OTP
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold leading-6 text-primary-600 hover:text-primary-500 transition-colors">
                Kembali ke halaman Login
            </a>
        </div>
    </div>
</div>
@endsection
