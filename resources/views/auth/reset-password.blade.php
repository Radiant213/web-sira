@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <h2 class="mb-6 text-center text-xl font-bold text-white">Reset Password</h2>
    <p class="mb-6 text-center text-sm text-slate-400">
        Masukkan 6 digit kode OTP yang kami kirimkan ke email Anda, lalu buat password baru.
    </p>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <x-ui.alert type="success" class="mb-6 !bg-emerald-500/10 !border-emerald-500/20 !text-emerald-200">
            {{ session('success') }}
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

    <form action="{{ route('password.update') }}" method="POST" class="space-y-5" x-data="otpInput()">
        @csrf
        
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label class="block text-sm font-medium leading-6 text-slate-300 mb-2 text-center">Kode OTP</label>
            <input id="otp" name="otp" type="text" maxlength="6" required 
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-center text-2xl font-bold tracking-[1em] text-white placeholder-slate-500 outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2" 
                   placeholder="------">
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-300">Password Baru</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required 
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500 outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-300">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-slate-500 outline-none ring-primary-500/50 transition-all duration-200 focus:border-primary-500 focus:bg-white/10 focus:ring-2">
        </div>

        <div>
            <button type="submit" class="mt-4 w-full rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30
                       transition-all duration-300 hover:from-primary-600 hover:to-primary-800 hover:shadow-primary-600/40 hover:scale-[1.02] active:scale-[0.98]" style="cursor: pointer;">
                Reset Password
            </button>
        </div>
    </form>

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
