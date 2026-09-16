<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lynvo Energi - Distributor & Layanan Antar Pasang Aki / Accu Banten')</title>
    <meta name="description" content="@yield('meta_description', 'Distributor aki mobil, truk, genset dan industri di Banten. Layanan pesan antar pasang aki 24 jam cepat ke rumah & kantor.')">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Social Meta -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Lynvo Energi - Distributor & Layanan Antar Pasang Aki Banten')">
    <meta property="og:description" content="@yield('meta_description', 'Pesan antar pasang aki mobil & truk cepat bergaransi resmi se-Banten.')">
    <meta property="og:image" content="{{ asset('assets/img/og-lynvo.jpg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-navy-900 { background-color: #0f172a; }
        .bg-navy-800 { background-color: #1e293b; }
        .text-navy-900 { color: #0f172a; }
        .text-electric-blue { color: #2563eb; }
        .bg-electric-blue { background-color: #2563eb; }
        .bg-wa-green { background-color: #22c55e; }
        .hover\:bg-wa-dark:hover { background-color: #16a34a; }
        .text-wa-green { color: #22c55e; }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 15px rgba(34, 197, 94, 0.4); }
            50% { box-shadow: 0 0 25px rgba(34, 197, 94, 0.8); }
        }
        .btn-wa-pulse {
            animation: pulse-glow 2.5s infinite;
        }
        [x-cloak] { display: none !important; }
    </style>

    @yield('schema_json')
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen antialiased selection:bg-blue-600 selection:text-white pb-16 md:pb-0">

    <!-- Top Urgent Notice Bar -->
    <div class="bg-slate-900 text-white text-xs sm:text-sm py-2 border-b border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-500 text-slate-950 uppercase tracking-wider animate-pulse">
                    ⚡ Delivery 24/7
                </span>
                <span class="text-slate-300 hidden sm:inline">{{ \App\Models\Setting::getValue('promo_text') }}</span>
                <span class="text-slate-300 sm:hidden">Pesan Antar Pasang Aki Cepat se-Banten</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="tel:081288889999" class="text-slate-300 hover:text-white flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-phone text-amber-400"></i>
                    <span class="font-semibold">{{ \App\Models\Setting::getValue('hero_phone') }}</span>
                </a>
                <span class="text-slate-600">|</span>
                <span class="text-emerald-400 font-medium flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Teknisi Siaga
                </span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm"
            x-data="{ mobileOpen: false, layananOpen: false }">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @php
                        $siteLogo = \App\Models\Setting::getValue('site_logo');
                    @endphp
                    @if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Lynvo Energi" class="h-12 w-auto group-hover:scale-105 transition transform">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-amber-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition transform">
                            <i class="fa-solid fa-car-battery text-2xl"></i>
                        </div>
                    @endif
                    <div>
                        <span class="text-2xl font-black tracking-tight text-slate-900 block leading-none">
                            LYNVO <span class="text-blue-600">ENERGI</span>
                        </span>
                        <span class="text-[11px] font-semibold tracking-wider text-slate-500 uppercase block mt-1">
                            Pusat Aki &amp; Accu Banten
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
                    <a href="{{ route('home') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Beranda
                    </a>
                    
                    <a href="{{ route('products.index') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Katalog Produk
                    </a>

                    <a href="{{ route('applications.index') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('applications.*') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Sektor B2B
                    </a>

                    <a href="{{ route('projects.index') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('projects.*') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Proyek
                    </a>
                    
                    <!-- Dropdown Area Banten & Layanan -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors py-2">
                            Jaringan Layanan
                            <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 text-slate-400 group-hover:text-blue-600 transition"></i>
                        </button>
                        <div class="absolute top-full -left-4 w-60 bg-white rounded-xl shadow-xl border border-slate-100 p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <a href="{{ route('services.battery_delivery') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-blue-700 bg-blue-50/50 hover:bg-blue-100 font-bold transition mb-1">
                                <i class="fa-solid fa-truck-fast text-blue-600 w-4"></i>
                                Hub Pesan Antar Pasang
                            </a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <a href="{{ route('local.landing', 'toko-aki-serang') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-location-dot text-blue-600 w-4"></i>
                                Toko Aki Serang
                            </a>
                            <a href="{{ route('local.landing', 'toko-aki-cilegon') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-location-dot text-blue-600 w-4"></i>
                                Toko Aki Cilegon
                            </a>
                            <a href="{{ route('local.landing', 'toko-aki-cikande') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-location-dot text-blue-600 w-4"></i>
                                Toko Aki Cikande Modern
                            </a>
                            <a href="{{ route('local.landing', 'toko-aki-tangerang') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-location-dot text-blue-600 w-4"></i>
                                Toko Aki Tangerang
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('about') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('about') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Tentang Kami
                    </a>

                    <a href="{{ route('contact') }}" class="text-base font-medium whitespace-nowrap {{ request()->routeIs('contact') ? 'text-blue-600' : 'text-slate-700' }} hover:text-blue-600 transition">
                        Kontak
                    </a>
                </nav>

                <!-- Header CTA Button (Desktop) -->
                <div class="hidden lg:flex items-center gap-2.5 flex-shrink-0">
                    <a href="{{ route('quotation') }}" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 border border-blue-600 text-blue-600 hover:bg-blue-50 text-base font-semibold rounded-xl transition whitespace-nowrap">
                        <i class="fa-solid fa-file-invoice-dollar"></i> <span class="whitespace-nowrap">Minta RFQ B2B</span>
                    </a>
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20butuh%20bantuan%20pesan%20antar%20aki%20sekarang." 
                       target="_blank"
                       class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-base font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition transform hover:-translate-y-0.5 btn-wa-pulse whitespace-nowrap">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span class="whitespace-nowrap">Panggil Teknisi</span>
                    </a>
                </div>

                <!-- Mobile Right: Hamburger Only -->
                <div class="flex items-center lg:hidden">
                    <!-- Hamburger Button -->
                    <button @click="mobileOpen = !mobileOpen"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition focus:outline-none"
                            :aria-expanded="mobileOpen"
                            aria-label="Toggle navigation menu">
                        <i class="fa-solid text-lg" :class="mobileOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.outside="mobileOpen = false"
             class="lg:hidden border-t border-slate-100 bg-white shadow-xl"
             x-cloak>
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 py-4 space-y-1">

                <!-- Menu Items -->
                <a href="{{ route('home') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-house w-5 text-center text-blue-500"></i>
                    Beranda
                </a>

                <a href="{{ route('products.index') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-car-battery w-5 text-center text-blue-500"></i>
                    Katalog Produk
                </a>

                <a href="{{ route('applications.index') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('applications.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-industry w-5 text-center text-blue-500"></i>
                    Sektor B2B
                </a>

                <a href="{{ route('projects.index') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('projects.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-folder-open w-5 text-center text-blue-500"></i>
                    Proyek
                </a>

                <!-- Jaringan Layanan Accordion -->
                <div>
                    <button @click="layananOpen = !layananOpen"
                            class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-truck-fast w-5 text-center text-blue-500"></i>
                            Jaringan Layanan
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="layananOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="layananOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-1 ml-8 space-y-1 border-l-2 border-blue-100 pl-3">
                        <a href="{{ route('services.battery_delivery') }}" @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold text-blue-700 bg-blue-50/60 hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-truck-fast text-blue-600 text-xs"></i>
                            Hub Pesan Antar Pasang
                        </a>
                        <a href="{{ route('local.landing', 'toko-aki-serang') }}" @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-location-dot text-blue-500 text-xs"></i>
                            Toko Aki Serang
                        </a>
                        <a href="{{ route('local.landing', 'toko-aki-cilegon') }}" @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-location-dot text-blue-500 text-xs"></i>
                            Toko Aki Cilegon
                        </a>
                        <a href="{{ route('local.landing', 'toko-aki-cikande') }}" @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-location-dot text-blue-500 text-xs"></i>
                            Toko Aki Cikande Modern
                        </a>
                        <a href="{{ route('local.landing', 'toko-aki-tangerang') }}" @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-location-dot text-blue-500 text-xs"></i>
                            Toko Aki Tangerang
                        </a>
                    </div>
                </div>

                <a href="{{ route('about') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-circle-info w-5 text-center text-blue-500"></i>
                    Tentang Kami
                </a>

                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }} transition-colors">
                    <i class="fa-solid fa-headset w-5 text-center text-blue-500"></i>
                    Kontak
                </a>

                <!-- CTA Buttons in Mobile Menu -->
                <div class="pt-3 mt-2 border-t border-slate-100 grid grid-cols-2 gap-2">
                    <a href="{{ route('quotation') }}" @click="mobileOpen = false"
                       class="flex items-center justify-center gap-1.5 px-4 py-2.5 border border-blue-600 text-blue-600 hover:bg-blue-50 text-sm font-semibold rounded-xl transition">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        Minta RFQ B2B
                    </a>
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20butuh%20bantuan%20pesan%20antar%20aki%20sekarang."
                       target="_blank"
                       class="flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition">
                        <i class="fa-brands fa-whatsapp"></i>
                        Panggil Teknisi
                    </a>
                </div>
            </div>
        </div>
    </header>




    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Trust & Guarantee Banner -->
    <section class="bg-slate-900 text-white py-12 border-t border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/50">
                    <i class="fa-solid fa-shield-halved text-3xl text-emerald-400 mb-3 block"></i>
                    <h4 class="text-base font-semibold text-white">100% Produk Original</h4>
                    <p class="text-sm text-slate-300 mt-1">Aki baru bergaransi resmi langsung distributor pabrikan.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/50">
                    <i class="fa-solid fa-stopwatch-20 text-3xl text-blue-400 mb-3 block"></i>
                    <h4 class="text-base font-semibold text-white">Respon Cepat 30-60 Mnt</h4>
                    <p class="text-sm text-slate-300 mt-1">Teknisi siaga langsung meluncur ke titik lokasi Anda.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/50">
                    <i class="fa-solid fa-wrench text-3xl text-amber-400 mb-3 block"></i>
                    <h4 class="text-base font-semibold text-white">Gratis Pasang &amp; Tes Dinamo</h4>
                    <p class="text-sm text-slate-300 mt-1">Pengecekan alternator &amp; kebocoran arus gratis di tempat.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/50">
                    <i class="fa-solid fa-recycle text-3xl text-teal-400 mb-3 block"></i>
                    <h4 class="text-base font-semibold text-white">Terima Tukar Tambah</h4>
                    <p class="text-sm text-slate-300 mt-1">Aki lama Anda dihargai tinggi untuk potongan harga langsung.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Footer Dark Navy (5 Kolom Sesuai Mockup Referensi) -->
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-12 border-t border-slate-800 text-sm">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-6 pb-12 border-b border-slate-800">
                <!-- Kolom 1: Profil Lynvo Energi & Media Sosial -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-md shadow-blue-500/30">
                            <i class="fa-solid fa-car-battery"></i>
                        </div>
                        <span class="text-xl font-black text-white tracking-tight">LYNVO <span class="text-blue-500">ENERGI</span></span>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-5">
                        <strong>PT Lynvo Energi Prima</strong> — Distributor resmi &amp; pusat pengadaan baterai industri, aki armada truk, alat berat, marine, genset, dan layanan darurat ganti aki 24 jam se-Banten.
                    </p>
                    <div class="flex items-center gap-2.5">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 hover:border-emerald-500 hover:bg-emerald-600 flex items-center justify-center text-slate-300 hover:text-white transition" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                        <a href="tel:081288889999" class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 hover:border-blue-500 hover:bg-blue-600 flex items-center justify-center text-slate-300 hover:text-white transition" title="Telepon">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </a>
                        <a href="mailto:{{ \App\Models\Setting::getValue('site_email') }}" class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500 hover:bg-amber-600 flex items-center justify-center text-slate-300 hover:text-white transition" title="Email">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 hover:border-sky-500 hover:bg-sky-600 flex items-center justify-center text-slate-300 hover:text-white transition" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Kolom 2: Navigasi Menu Cepat -->
                <div x-data="{ open: false }" class="border-b border-slate-800 lg:border-none pb-4 lg:pb-0">
                    <h5 @click="open = !open" class="text-white font-bold text-base mb-4 flex items-center justify-between cursor-pointer lg:cursor-default w-full">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-compass text-blue-500 text-xs"></i>
                            Menu Navigasi
                        </span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200 lg:hidden" :class="open ? 'rotate-180' : ''"></i>
                    </h5>
                    <ul x-show="open" class="space-y-2 text-sm text-slate-300 lg:!block" x-cloak>
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Beranda Utama</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Katalog Aki &amp; Baterai</a></li>
                        <li><a href="{{ route('applications.index') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Sektor B2B &amp; Industri</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Portofolio Proyek</a></li>
                        <li><a href="{{ route('services.battery_delivery') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Layanan Antar Pasang</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-angle-right text-[10px] text-blue-500"></i> Tentang Lynvo Energi</a></li>
                        <li><a href="{{ route('quotation') }}" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-file-invoice text-[10px] text-amber-400"></i> Minta Penawaran B2B</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kategori Produk Aki -->
                <div x-data="{ open: false }" class="border-b border-slate-800 lg:border-none pb-4 lg:pb-0">
                    <h5 @click="open = !open" class="text-white font-bold text-base mb-4 flex items-center justify-between cursor-pointer lg:cursor-default w-full">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-boxes-stacked text-blue-500 text-xs"></i>
                            Kategori Produk
                        </span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200 lg:hidden" :class="open ? 'rotate-180' : ''"></i>
                    </h5>
                    <ul x-show="open" class="space-y-2 text-sm text-slate-300 lg:!block" x-cloak>
                        <li><a href="{{ route('products.category', 'aki-mobil') }}" class="hover:text-white transition-colors">Aki Mobil (MF / Basah)</a></li>
                        <li><a href="{{ route('products.category', 'aki-truk-bus') }}" class="hover:text-white transition-colors">Aki Truk &amp; Bus Heavy Duty</a></li>
                        <li><a href="{{ route('products.category', 'aki-alat-berat') }}" class="hover:text-white transition-colors">Aki Excavator &amp; Alat Berat</a></li>
                        <li><a href="{{ route('products.category', 'aki-kapal-marine') }}" class="hover:text-white transition-colors">Aki Kapal Marine Deep Cycle</a></li>
                        <li><a href="{{ route('products.category', 'aki-genset') }}" class="hover:text-white transition-colors">Aki Starter Genset Standby</a></li>
                        <li><a href="{{ route('products.category', 'aki-ups-backup-power') }}" class="hover:text-white transition-colors">Baterai VRLA UPS &amp; Server</a></li>
                        <li><a href="{{ route('brands.index') }}" class="text-amber-400 hover:text-amber-300 font-medium transition-colors">Merek: GS Astra, Yuasa, Incoe</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Kontak & Alamat Gudang/Kantor Banten -->
                <div x-data="{ open: false }" class="border-b border-slate-800 lg:border-none pb-4 lg:pb-0">
                    <h5 @click="open = !open" class="text-white font-bold text-base mb-4 flex items-center justify-between cursor-pointer lg:cursor-default w-full">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-headset text-blue-500 text-xs"></i>
                            Kontak &amp; Gudang
                        </span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200 lg:hidden" :class="open ? 'rotate-180' : ''"></i>
                    </h5>
                    <div x-show="open" class="space-y-3 text-sm text-slate-300 lg:!block" x-cloak>
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-rose-500 mt-0.5 text-xs"></i>
                            <div>
                                <strong class="text-slate-100 block">Hub Logistik &amp; Workshop:</strong>
                                <span>Jl. Raya Serang - Jkt KM 68, Kawasan Cikande &amp; Serang, Banten</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400 mt-0.5 text-xs"></i>
                            <div>
                                <strong class="text-slate-100 block">Hotline 24 Jam / WA:</strong>
                                <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}" class="hover:text-emerald-400 hover:transition-colors font-semibold text-slate-300">{{ \App\Models\Setting::getValue('hero_phone') }}</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-envelope text-blue-400 mt-0.5 text-xs"></i>
                            <div>
                                <strong class="text-slate-100 block">Email Pengadaan B2B:</strong>
                                <a href="mailto:{{ \App\Models\Setting::getValue('site_email') }}" class="hover:text-blue-300 transition-colors">{{ \App\Models\Setting::getValue('site_email') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 5: Grafis Peta Jangkauan Pengiriman Indonesia -->
                <div x-data="{ open: false }" class="border-b border-slate-800 lg:border-none pb-4 lg:pb-0">
                    <h5 @click="open = !open" class="text-white font-bold text-base mb-4 flex items-center justify-between cursor-pointer lg:cursor-default w-full">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-earth-asia text-emerald-400 text-xs"></i>
                            Jangkauan Distribusi
                        </span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200 lg:hidden" :class="open ? 'rotate-180' : ''"></i>
                    </h5>
                    <div x-show="open" class="p-3.5 rounded-xl bg-slate-900 border border-slate-800 lg:!block" x-cloak>
                        <!-- Stylized Minimal Indonesia Map Graphic SVG -->
                        <div class="relative w-full h-24 mb-2 flex items-center justify-center bg-slate-950/80 rounded-lg p-2 overflow-hidden border border-slate-800/80">
                            <svg viewBox="0 0 400 160" class="w-full h-full text-slate-700 fill-current opacity-80" xmlns="http://www.w3.org/2000/svg">
                                <!-- Sumatra -->
                                <path d="M 40,30 L 75,70 L 95,110 L 80,125 L 60,95 L 30,50 Z" class="fill-slate-700 hover:fill-blue-500 transition"></path>
                                <!-- Java -->
                                <path d="M 95,128 L 130,126 L 175,130 L 210,135 L 205,142 L 130,138 L 95,135 Z" class="fill-blue-500"></path>
                                <!-- Kalimantan -->
                                <path d="M 130,45 L 175,40 L 195,75 L 180,110 L 140,105 L 125,75 Z" class="fill-slate-700 hover:fill-blue-500 transition"></path>
                                <!-- Sulawesi -->
                                <path d="M 215,65 L 235,50 L 245,75 L 230,95 L 245,120 L 235,125 L 225,100 L 215,85 Z" class="fill-slate-700 hover:fill-blue-500 transition"></path>
                                <!-- Maluku & Papua -->
                                <path d="M 270,75 L 285,85 L 275,100 Z M 305,65 L 360,75 L 375,105 L 350,120 L 310,95 Z" class="fill-slate-700 hover:fill-blue-500 transition"></path>
                            </svg>
                            <!-- Glowing Delivery Beacon over Banten / Java -->
                            <div class="absolute top-[82px] left-[105px] -translate-x-1/2 -translate-y-1/2 flex items-center justify-center">
                                <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping absolute"></span>
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            </div>
                            <span class="absolute bottom-1 right-2 text-[9px] font-mono text-emerald-400 bg-emerald-950/80 px-1.5 py-0.5 rounded border border-emerald-500/30">
                                34 Provinsi
                            </span>
                        </div>
                        <div class="text-sm text-slate-300 leading-snug">
                            <span class="text-white font-semibold block">Suplai Ekspedisi Nasional:</span>
                            Jawa, Sumatera, Kalimantan, Sulawesi, Bali, NTB, NTT &amp; Papua.
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-400">
                <p>&copy; {{ date('Y') }} PT Lynvo Energi Prima. All rights reserved. Spesialis Pengadaan Aki &amp; Accu Nasional.</p>
                <div class="flex items-center gap-5">
                    <a href="{{ route('services.battery_delivery') }}" class="hover:text-slate-200 transition-colors">Layanan Antar Pasang</a>
                    <a href="{{ route('quotation') }}" class="hover:text-slate-200 transition-colors">Permintaan RFQ B2B</a>
                    <a href="{{ route('contact') }}" class="hover:text-slate-200 transition-colors">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Sticky Mobile Bottom Bar (High Conversion) -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-slate-200 py-2 px-4 flex items-center justify-around md:hidden shadow-2xl">
        <a href="{{ route('home') }}" class="flex flex-col items-center text-[10px] font-semibold text-slate-600 hover:text-blue-600">
            <i class="fa-solid fa-house text-lg mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('services.battery_delivery') }}" class="flex flex-col items-center text-[10px] font-semibold text-slate-600 hover:text-blue-600">
            <i class="fa-solid fa-truck-fast text-lg mb-0.5"></i>
            <span>Layanan</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center text-[10px] font-semibold text-slate-600 hover:text-blue-600">
            <i class="fa-solid fa-car-battery text-lg mb-0.5"></i>
            <span>Katalog</span>
        </a>
        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20mau%20ganti%20aki%20antar%20ke%20lokasi%20sekarang." 
           target="_blank"
           class="flex items-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 py-2 rounded-full shadow-lg shadow-emerald-500/40">
            <i class="fa-brands fa-whatsapp text-lg animate-bounce"></i>
            <span>Panggil Teknisi</span>
        </a>
    </div>

    @stack('scripts')
</body>
</html>
