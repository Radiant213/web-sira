<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIRA') - Sistem Informasi RT/RW</title>
    <meta name="description" content="SIRA - Sistem Informasi & Pelaporan RT/RW untuk digitalisasi layanan warga">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-r.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-primary-950 to-slate-900 font-sans antialiased">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md animate-fade-in-up">
            {{-- Logo --}}
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center overflow-hidden rounded-2xl bg-white/10 backdrop-blur-sm ring-1 ring-white/20 shadow-xl">
                    <img src="{{ asset('images/logo-r.jpg') }}" alt="SIRA Logo" class="h-full w-full object-cover">
                </div>
                <h1 class="text-2xl font-bold text-white">SIRA</h1>
                <p class="mt-1 text-sm text-primary-200/70">Sistem Informasi & Pelaporan RT/RW</p>
            </div>

            {{-- Card --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-xl">
                @yield('content')
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} SIRA. Digitalisasi Layanan RT/RW.
            </p>
        </div>
    </div>
</body>
</html>
