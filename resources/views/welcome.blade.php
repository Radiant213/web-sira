<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRA - Sistem Informasi Rukun Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .hero-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }
        .hero-bg::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    {{-- Navigation --}}
    <nav :class="{'glass-nav': scrolled, 'bg-transparent': !scrolled}" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-r.jpg') }}" alt="Logo SIRA" class="h-10 w-10 rounded-xl object-cover shadow-lg shadow-primary-500/30">
                    <span class="text-xl font-bold tracking-tight text-slate-900">SIRA</span>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 transition-colors hover:text-primary-600">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:bg-slate-800 hover:shadow-lg focus:ring-4 focus:ring-slate-900/20">
                        Daftar Warga
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-bg relative pt-32 pb-20 lg:pt-48 lg:pb-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50/50 px-4 py-1.5 text-sm font-medium text-primary-700 backdrop-blur-sm mb-6 animate-fade-in-up">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Sistem Digitalisasi RT/RW Modern
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-6xl mb-6 animate-fade-in-up" style="animation-delay: 100ms;">
                    Lingkungan Warga, <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">Lebih Transparan & Mudah</span>
                </h1>
                <p class="text-lg text-slate-600 mb-10 animate-fade-in-up" style="animation-delay: 200ms;">
                    SIRA (Sistem Informasi Rukun Warga) mempermudah pengelolaan data warga, surat pengantar, pelaporan, dan iuran bulanan dalam satu platform digital yang praktis.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 300ms;">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-primary-600 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-primary-600/30 transition-all hover:bg-primary-700 hover:-translate-y-0.5">
                        Daftar Sekarang
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-white px-8 py-3.5 text-base font-semibold text-slate-700 border border-slate-200 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-300">
                        Masuk Sistem
                    </a>
                </div>
            </div>
            
            {{-- Floating UI Dashboard Preview --}}
            <div class="mt-20 mx-auto max-w-5xl relative animate-fade-in-up" style="animation-delay: 500ms;">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-slate-800">Sekilas Fitur Dashboard</h3>
                    <p class="text-slate-500 mt-2">Gambaran informasi yang akan langsung Anda dapatkan saat masuk ke dalam sistem.</p>
                </div>
                <div class="glass-card rounded-3xl p-4 sm:p-6 shadow-2xl ring-1 ring-slate-900/5 overflow-hidden">
                    <div class="flex items-center gap-2 mb-4 px-2">
                        <div class="h-3 w-3 rounded-full bg-rose-400"></div>
                        <div class="h-3 w-3 rounded-full bg-amber-400"></div>
                        <div class="h-3 w-3 rounded-full bg-emerald-400"></div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl border border-slate-100 p-4 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm relative group overflow-hidden">
                            <div class="absolute inset-0 bg-emerald-500/5 translate-y-full transition-transform duration-300 group-hover:translate-y-0"></div>
                            <div class="relative z-10">
                                <div class="h-10 w-10 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Verifikasi Cepat</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">Admin dapat dengan cepat memverifikasi permohonan surat pengantar dari warga tanpa harus bertatap muka.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm relative group overflow-hidden">
                            <div class="absolute inset-0 bg-indigo-500/5 translate-y-full transition-transform duration-300 group-hover:translate-y-0"></div>
                            <div class="relative z-10">
                                <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Jadwal & Rekap</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">Pantau jadwal kegiatan warga dan cetak rekapitulasi data (seperti iuran) dalam bentuk PDF dengan sekali klik.</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm relative group overflow-hidden">
                            <div class="absolute inset-0 bg-rose-500/5 translate-y-full transition-transform duration-300 group-hover:translate-y-0"></div>
                            <div class="relative z-10">
                                <div class="h-10 w-10 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Notifikasi Real-time</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">Dapatkan pemberitahuan seketika (real-time) setiap kali ada informasi penting, tagihan iuran, atau surat selesai diproses.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Kenapa Memilih SIRA?</h2>
                <p class="mt-4 text-lg text-slate-500">Fitur lengkap untuk menjawab seluruh kebutuhan rukun warga.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="rounded-3xl border border-slate-100 p-8 shadow-sm transition-all hover:shadow-md hover:border-primary-100 group">
                    <div class="h-12 w-12 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center mb-6 transition-transform group-hover:-translate-y-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Surat Pengantar Digital</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Tidak perlu repot fotokopi KK atau mendatangi rumah Pak RT malam-malam. Cukup isi form di website, pengurus akan mendapat notifikasi untuk memproses, dan Anda tinggal cetak/download surat pengantar yang telah disetujui dalam bentuk PDF yang rapi.</p>
                </div>
                
                <div class="rounded-3xl border border-slate-100 p-8 shadow-sm transition-all hover:shadow-md hover:border-amber-100 group">
                    <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 transition-transform group-hover:-translate-y-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Sistem Pengaduan</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Ada lampu jalan mati? Atau masalah kebersihan lingkungan? Laporkan langsung melalui sistem dengan menyertakan detail. Pengurus dapat melihat laporan warga, merespon statusnya, dan memastikan lingkungan tetap aman dan nyaman bersama-sama.</p>
                </div>

                <div class="rounded-3xl border border-slate-100 p-8 shadow-sm transition-all hover:shadow-md hover:border-emerald-100 group">
                    <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 transition-transform group-hover:-translate-y-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Transparansi Iuran</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Semua catatan iuran bulanan dari kas RT/RW akan tercatat secara digital. Anda bisa memantau histori pembayaran sendiri, mengecek tagihan yang belum dibayar, serta pengurus dapat dengan mudah melihat rekapitulasi siapa saja warga yang sudah melunasi kewajiban.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-400 py-12 sm:py-16 border-t border-slate-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6 text-white">
                        <img src="{{ asset('images/logo-r.jpg') }}" alt="Logo SIRA" class="h-8 w-8 rounded-lg object-cover bg-white">
                        <span class="text-xl font-bold">SIRA</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-sm">
                        Sistem Informasi Rukun Warga (SIRA) hadir untuk memudahkan pengelolaan data warga, surat menyurat, pengaduan, dan iuran lingkungan dalam satu platform digital terpadu.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk Sistem</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar Warga Baru</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Sekretariat RT/RW Setempat</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>admin@sira.local</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-800 text-center text-sm">
                <p>&copy; {{ date('Y') }} Sistem Informasi Rukun Warga. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
