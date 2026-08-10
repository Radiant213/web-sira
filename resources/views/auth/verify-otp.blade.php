@extends('layouts.guest')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white/80 backdrop-blur-xl px-4 py-8 shadow sm:rounded-2xl sm:px-10 border border-white/20">
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Verifikasi Email</h2>
            <p class="mt-2 text-sm text-slate-600">
                Kami telah mengirimkan 6 digit kode OTP ke email Anda.
            </p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

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

        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6" x-data="otpInput()">
            @csrf

            <div>
                <label class="block text-sm font-medium leading-6 text-slate-900 mb-2 text-center">Kode OTP</label>
                <div class="flex justify-center gap-2 sm:gap-3">
                    <template x-for="(i, index) in 6" :key="index">
                        <input type="text" maxlength="1" name="otp[]"
                               x-ref="'input' + index"
                               @input="handleInput($event, index)"
                               @keydown.backspace="handleBackspace($event, index)"
                               @paste="handlePaste($event)"
                               class="w-10 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold rounded-xl border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:leading-6">
                    </template>
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center rounded-xl bg-primary-600 px-3 py-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">
                    Verifikasi OTP
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500">
            Belum menerima email?
            <form action="{{ route('otp.resend') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="font-semibold text-primary-600 hover:text-primary-500 bg-transparent border-none p-0 cursor-pointer">
                    Kirim Ulang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function otpInput() {
        return {
            handleInput(e, index) {
                const input = e.target;
                if (input.value.length > 0) {
                    if (index < 5) {
                        this.$refs['input' + (index + 1)].focus();
                    }
                }
            },
            handleBackspace(e, index) {
                if (e.target.value === '') {
                    if (index > 0) {
                        this.$refs['input' + (index - 1)].focus();
                    }
                }
            },
            handlePaste(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 6).split('');
                for (let i = 0; i < pastedData.length; i++) {
                    if (this.$refs['input' + i]) {
                        this.$refs['input' + i].value = pastedData[i];
                        if (i < 5) {
                            this.$refs['input' + (i + 1)].focus();
                        }
                    }
                }
            }
        }
    }
</script>
@endsection
