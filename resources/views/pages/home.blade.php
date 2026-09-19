@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- ========================================================================= -->
    <!-- 1. HERO SECTION (SPLIT LAYOUT DENGAN FOTO INDUSTRI NYATA & 3 FLOATING BADGES) -->
    <!-- ========================================================================= -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white pt-12 pb-20 lg:pt-16 lg:pb-28 overflow-hidden border-b border-slate-800">
        <!-- Ambient Background Glows -->
        <div class="absolute -top-32 left-1/4 w-[650px] h-[350px] bg-blue-600/20 blur-[140px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-[450px] h-[400px] bg-emerald-500/15 blur-[130px] rounded-full pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-25 pointer-events-none"></div>

        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                
                <!-- Kolom Kiri: Copywriting & CTAs -->
                <div class="lg:col-span-7">
                    <!-- Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-950/90 border border-blue-500/40 text-blue-300 text-xs sm:text-sm font-bold mb-6 shadow-lg shadow-blue-900/30">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="tracking-wide uppercase">DISTRIBUSI & PENGADAAN BATERAI NASIONAL</span>
                    </div>

                    <!-- H1 Main Headline -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight mb-6">
                        Solusi Aki & Accu Terpercaya untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-amber-300">Industri, Bisnis dan Kendaraan</span> di Seluruh Indonesia
                    </h1>

                    <!-- Description -->
                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8 max-w-2xl">
                        Pusat pengadaan baterai & aki resmi terlengkap untuk kebutuhan <strong>B2B industri, armada logistik, genset, alat berat, marine, UPS</strong> ke 34 provinsi, serta layanan <strong>ganti aki antar-pasang darurat 24 jam</strong> langsung ke lokasi se-Banten.
                    </p>

                    <!-- Dual CTAs: Green WhatsApp + Dark Navy RFQ -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20ingin%20konsultasi%20kebutuhan%20aki%20dan%20baterai." 
                           target="_blank"
                           class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-base px-8 py-4 rounded-xl shadow-xl shadow-emerald-600/30 transition duration-200 transform hover:-translate-y-0.5 btn-wa-pulse">
                            <i class="fa-brands fa-whatsapp text-2xl text-emerald-100"></i>
                            <span>Konsultasi via WhatsApp</span>
                        </a>

                        <a href="{{ route('quotation') }}" 
                           class="inline-flex items-center justify-center gap-2.5 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 hover:border-blue-500 font-extrabold text-base px-7 py-4 rounded-xl shadow-xl transition duration-200 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-file-invoice-dollar text-amber-400"></i>
                            <span>Minta Penawaran B2B</span>
                        </a>
                    </div>

                    <!-- Trust Stats Bar -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-8 border-t border-slate-800/90">
                        <div class="bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                            <span class="text-2xl sm:text-3xl font-black text-white block">100%</span>
                            <span class="text-xs text-slate-400 font-medium">Original Bergaransi</span>
                        </div>
                        <div class="bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                            <span class="text-2xl sm:text-3xl font-black text-emerald-400 block">500+</span>
                            <span class="text-xs text-slate-400 font-medium">Mitra Korporat B2B</span>
                        </div>
                        <div class="bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                            <span class="text-2xl sm:text-3xl font-black text-blue-400 block">34</span>
                            <span class="text-xs text-slate-400 font-medium">Provinsi Terjangkau</span>
                        </div>
                        <div class="bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                            <span class="text-2xl sm:text-3xl font-black text-amber-400 block">24/7</span>
                            <span class="text-xs text-slate-400 font-medium">Siaga Darurat Banten</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Foto Industri Resolusi Tinggi & 3 Floating Badges Putih -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        
                        <!-- High-Res Industrial Photography Container -->
                        <div class="relative rounded-3xl overflow-hidden border-2 border-slate-700/80 shadow-2xl shadow-blue-950/60 group">
                            <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1000&q=80" 
                                 alt="Lynvo Energi Baterai Industri & Accu Suplai Nasional" 
                                 class="w-full h-[420px] sm:h-[480px] object-cover object-center group-hover:scale-105 transition duration-700">
                            
                            <!-- Gradient Overlay for Contrast & Depth -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                            
                            <!-- Bottom Badge inside image -->
                            <div class="absolute bottom-4 left-4 right-4 p-3.5 rounded-2xl bg-slate-900/90 backdrop-blur-md border border-slate-700/80 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span class="text-xs font-bold text-white">Stok Gudang Siap Kirim Nasional</span>
                                </div>
                                <span class="text-[10px] font-mono text-emerald-400 bg-emerald-950 px-2 py-0.5 rounded border border-emerald-500/40">Tier 1</span>
                            </div>
                        </div>

                        <!-- Floating Badge 1 (Top Left): Produk Original & Bergaransi -->
                        <div class="absolute -top-4 -left-3 sm:-top-5 sm:-left-6 bg-white text-slate-900 px-4 py-3 rounded-2xl shadow-2xl border border-slate-100 flex items-center gap-3 z-20 transform hover:scale-105 transition duration-200">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 block leading-tight">Produk Original & Bergaransi</span>
                                <span class="text-[11px] text-slate-500">100% Segel Resmi Pabrikan</span>
                            </div>
                        </div>

                        <!-- Floating Badge 2 (Center Right): Harga Kompetitif B2B -->
                        <div class="absolute top-1/2 -right-3 sm:-right-6 -translate-y-1/2 bg-white text-slate-900 px-4 py-3 rounded-2xl shadow-2xl border border-slate-100 flex items-center gap-3 z-20 transform hover:scale-105 transition duration-200">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 block leading-tight">Harga Kompetitif B2B</span>
                                <span class="text-[11px] text-slate-500">Tier Distributor & Faktur Pajak</span>
                            </div>
                        </div>

                        <!-- Floating Badge 3 (Bottom Left): Layanan Kirim Seluruh Indonesia -->
                        <div class="absolute -bottom-4 -left-2 sm:-bottom-5 sm:-left-4 bg-white text-slate-900 px-4 py-3 rounded-2xl shadow-2xl border border-slate-100 flex items-center gap-3 z-20 transform hover:scale-105 transition duration-200">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 block leading-tight">Layanan Kirim Seluruh Indonesia</span>
                                <span class="text-[11px] text-slate-500">Ekspedisi Nasional & Antar Banten</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 2. 4 VALUE PROPOSITION BAR (STRIP PUTIH HORIZONTAL) -->
    <!-- ========================================================================= -->
    <section class="relative z-20 -mt-6 sm:-mt-8 max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                
                <!-- Prop 1: Pengalaman & Terpercaya -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 shadow-sm border border-blue-100">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Pengalaman & Terpercaya</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Mitra teruji ratusan pabrik, armada logistik, dan kontraktor alat berat di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Prop 2: Produk Lengkap Merek Ternama -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0 shadow-sm border border-emerald-100">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Produk Lengkap Merek Ternama</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Distributor resmi GS Astra, Yuasa, Incoe, Amaron, Varta & Bosch terlengkap.
                        </p>
                    </div>
                </div>

                <!-- Prop 3: Harga Kompetitif & Faktur Pajak -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl flex-shrink-0 shadow-sm border border-amber-100">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Harga Kompetitif & Faktur Pajak</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Penawaran harga tier distributor langsung, transparan, dan terbit Faktur Pajak PPN resmi.
                        </p>
                    </div>
                </div>

                <!-- Prop 4: Layanan Kirim Nasional & Antar Pasang Banten -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl flex-shrink-0 shadow-sm border border-sky-100">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Layanan Kirim & Antar Pasang</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Ekspedisi ke 34 provinsi serta teknisi darurat 30-60 menit langsung di area Banten.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 3. KATEGORI PRODUK AKI (GRID 6 KOTAK PUTIH DENGAN FOTO UNSPLASH STABIL) -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 border border-blue-200/60 px-3.5 py-1.5 rounded-full inline-block mb-2">
                        KATALOG PRODUK SPESIALIS
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Kategori Pilihan Aki, Accu & Baterai Industri
                    </h2>
                    <p class="text-slate-600 text-sm mt-2 max-w-2xl">
                        Tersedia berbagai pilihan kapasitas ampere (Ah), cold cranking amps (CCA), dan tipe teknologi aki (MF Kering, Basah, VRLA, AGM) sesuai spesifikasi teknis mesin Anda.
                    </p>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition group flex-shrink-0">
                    <span>Lihat Semua Katalog Produk</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition transform"></i>
                </a>
            </div>

            <!-- Dynamic Category Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse($categories as $category)
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-500/80 hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Photo Thumbnail -->
                            <div class="h-48 overflow-hidden relative bg-slate-100">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="https://placehold.co/600x400/0f172a/ffffff?text=Foto+{{ urlencode($category->name) }}" 
                                         alt="{{ $category->name }}" 
                                         class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-blue-600 transition mb-2">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    {{ $category->description ?? 'Menyediakan ' . $category->name . ' terbaik untuk kebutuhan Anda.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">{{ $category->products_count ?? 0 }} Produk</span>
                            <a href="{{ route('products.category', $category->slug) }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
                                <span>Lihat Produk</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-slate-500 text-sm">Belum ada kategori yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 4. SEKTOR INDUSTRI BANNER (DARK NAVY DENGAN FOTO TEKNISI REAL UNSPLASH) -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white relative overflow-hidden border-y border-slate-800">
        <!-- Ambient Lighting -->
        <div class="absolute top-1/2 left-0 w-96 h-96 bg-blue-600/10 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left: Headline & Sektor Grid Strip -->
                <div class="lg:col-span-7">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 border border-emerald-500/30 px-3.5 py-1.5 rounded-full inline-block mb-4">
                        SEKTOR INDUSTRI & APLIKASI B2B
                    </span>
                    <h2 class="text-2xl sm:text-4xl lg:text-4xl font-black text-white tracking-tight leading-tight mb-4">
                        Mendukung Keandalan Daya & Produktivitas di Setiap Industri
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8">
                        Lynvo Energi hadir sebagai mitra strategis pengadaan baterai industri dan pemeliharaan kontinuitas daya untuk berbagai sektor bisnis vital di Indonesia.
                    </p>

                    <!-- 6 Industrial Sectors Strip Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        
                        <!-- 1. Manufaktur -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-blue-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-blue-950 text-blue-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-industry"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Industri Manufaktur</h4>
                                <p class="text-[11px] text-slate-400">Pabrik kimia, semen, baja & kawasan industri Cikande/Cilegon.</p>
                            </div>
                        </div>

                        <!-- 2. Armada Logistik -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-emerald-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-emerald-950 text-emerald-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-truck-moving"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Armada Logistik</h4>
                                <p class="text-[11px] text-slate-400">Truk kontainer, fuso ekspedisi lintas Jawa-Sumatera.</p>
                            </div>
                        </div>

                        <!-- 3. Pelabuhan & Marine -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-sky-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-sky-950 text-sky-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-ship"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Pelabuhan & Marine</h4>
                                <p class="text-[11px] text-slate-400">Kapal tunda Merak, dermaga Bojonegara & pelayaran.</p>
                            </div>
                        </div>

                        <!-- 4. RS & Data Center -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-purple-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-purple-950 text-purple-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-hospital"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Rumah Sakit & Data Center</h4>
                                <p class="text-[11px] text-slate-400">Sistem catu daya kritis UPS & genset darurat tanpa henti.</p>
                            </div>
                        </div>

                        <!-- 5. Tambang & Konstruksi -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-amber-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-amber-950 text-amber-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-trowel-bricks"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Pertambangan & Konstruksi</h4>
                                <p class="text-[11px] text-slate-400">Alat berat excavator tambang pasir, quarry & proyek sipil.</p>
                            </div>
                        </div>

                        <!-- 6. Genset Komersial -->
                        <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-rose-500/60 transition flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-rose-950 text-rose-400 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-building-circle-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Genset Komersial</h4>
                                <p class="text-[11px] text-slate-400">Gedung perkantoran, perhotelan, pusat perbelanjaan & industri.</p>
                            </div>
                        </div>

                    </div>

                    <a href="{{ route('applications.index') }}" 
                       class="inline-flex items-center gap-2 text-sm font-bold text-blue-400 hover:text-blue-300 transition">
                        <span>Eksplorasi Rincian Seluruh Sektor Industri</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Right: Foto Real Engineer Pabrik / Teknisi K3 Unsplash -->
                <div class="lg:col-span-5 relative">
                    <div class="relative rounded-2xl overflow-hidden border border-slate-700/80 shadow-2xl shadow-blue-950/70 group">
                        <!-- Real Industrial Engineer Photo -->
                        <img src="https://placehold.co/800x600/0f172a/ffffff?text=Foto+Teknisi+K3" 
                             alt="Teknisi Spesialis Lynvo Energi Inspeksi Baterai Industri" 
                             class="w-full h-[450px] sm:h-[500px] object-cover object-center group-hover:scale-105 transition duration-700">
                        
                        <!-- Smooth Dark Navy Gradient Blend Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

                        <!-- Floating Badges on Image -->
                        <div class="absolute top-4 right-4 bg-slate-900/90 backdrop-blur-md border border-slate-700 text-white px-3.5 py-1.5 rounded-full text-xs font-bold flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>Teknisi Siaga Banten</span>
                        </div>

                        <!-- Bottom Content Overlay inside image -->
                        <div class="absolute bottom-4 left-4 right-4 p-5 rounded-2xl bg-slate-900/95 backdrop-blur-md border border-slate-700/80">
                            <h3 class="text-base font-extrabold text-white mb-1">
                                Tim Teknisi Bersertifikat Standar K3
                            </h3>
                            <p class="text-xs text-slate-300 leading-relaxed mb-3">
                                Dilengkapi digital conductance analyzer & toolkit modern untuk diagnosa dinamo serta penggantian baterai presisi di lokasi.
                            </p>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-800 text-xs">
                                <span class="font-bold text-emerald-400">Respon Cepat 30-60 Mnt</span>
                                <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}" target="_blank" class="text-white bg-emerald-600 hover:bg-emerald-500 font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp"></i> Panggil
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 5. PROJECT KAMI (GRID 4 KOLOM DENGAN FOTO THUMBNAIL NYATA & CARD PUTIH) -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <!-- Section Header -->
            <div class="mb-12">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 border border-blue-200/60 px-3.5 py-1.5 rounded-full inline-block mb-2">
                    PORTOFOLIO IMPLEMENTASI
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Studi Kasus Proyek Pengadaan & Instalasi Baterai
                </h2>
                <p class="text-slate-600 text-sm mt-2 max-w-2xl mb-5">
                    Bukti nyata keandalan pasokan baterai industri, instalasi genset standby, dan kontrak pengadaan armada logistik bersama Lynvo Energi.
                </p>
                <a href="{{ route('projects.index') }}" 
                   class="inline-flex items-center gap-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-lg shadow-sm transition group">
                    <span>Lihat Semua Portofolio Proyek</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition transform"></i>
                </a>
            </div>

            <!-- 4 Column Real Photo Projects Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                @forelse($latestProjects as $index => $proj)
                    @php
                        $photoUrl = $proj->image
                            ? asset('storage/' . $proj->image)
                            : 'https://placehold.co/600x400/f8fafc/334155?text=Dokumentasi+Proyek';
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-500/80 hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Real Photo Thumbnail with Category Badge -->
                            <div class="h-48 overflow-hidden relative bg-slate-100">
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $proj->title }}" 
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-600 text-white shadow">
                                    {{ $proj->category }}
                                </span>
                                
                                <span class="absolute bottom-2.5 right-3 text-[11px] font-bold text-white/90">
                                    {{ $proj->completion_year ?? '2025' }}
                                </span>
                            </div>

                            <!-- Content Body -->
                            <div class="p-5">
                                <div class="flex items-center gap-1.5 text-[11px] text-rose-600 font-bold mb-2">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span class="line-clamp-1">{{ $proj->location }}</span>
                                </div>

                                <a href="{{ route('projects.show', $proj->slug) }}" class="block">
                                    <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-blue-600 transition mb-2 line-clamp-2 leading-snug">
                                        {{ $proj->title }}
                                    </h3>
                                </a>

                                <p class="text-xs text-slate-500 line-clamp-3 mb-3 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($proj->description), 150) }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer Link -->
                        <div class="p-5 pt-0 border-t border-slate-100 bg-slate-50/50">
                            <a href="{{ route('projects.show', $proj->slug) }}" 
                               class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center justify-between pt-3">
                                <span>Detail Studi Kasus</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback 4 Cards jika data kosong -->
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <span class="text-xs font-bold text-blue-600">Genset Industri</span>
                        <h4 class="font-extrabold text-sm text-slate-900 mt-1">Pabrik Manufaktur Cikande</h4>
                    </div>
                @endforelse
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 6. HORIZONTAL QUICK CONSULTATION FORM (CARD PUTIH BERSIH ELEGAN) -->
    <!-- ========================================================================= -->
    <section class="py-14 bg-slate-100/70">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="bg-white rounded-3xl p-7 sm:p-10 shadow-2xl border border-slate-200/90 text-slate-900 relative">
                
                <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2 border border-emerald-200">
                            ⚡ Respon Cepat Tim Teknis Lynvo Energi
                        </span>
                        <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Konsultasikan Kebutuhan Aki & Accu Anda Bersama Tim Kami
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm mt-1">
                            Dapatkan rekomendasi tipe aki yang tepat, estimasi harga tier distributor, dan penawaran resmi dalam hitungan menit.
                        </p>
                    </div>

                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-extrabold text-sm flex-shrink-0 bg-emerald-50 border border-emerald-200 px-4 py-2.5 rounded-xl transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>WhatsApp Langsung 24 Jam</span>
                    </a>
                </div>

                <!-- High Contrast Form -->
                <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="b2b_quotation">
                    <input type="hidden" name="source_url" value="{{ url()->current() }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Input Nama -->
                        <div>
                            <label for="quick_name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap / Perusahaan</label>
                            <input type="text" 
                                   id="quick_name" 
                                   name="name" 
                                   required 
                                   placeholder="cth: Bpk. Hendra / PT Mandiri" 
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-xs focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition">
                        </div>

                        <!-- Input No WhatsApp -->
                        <div>
                            <label for="quick_phone" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp</label>
                            <input type="tel" 
                                   id="quick_phone" 
                                   name="phone" 
                                   required 
                                   placeholder="cth: 0812-3456-7890" 
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-xs focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition">
                        </div>

                        <!-- Input Kebutuhan Aki -->
                        <div>
                            <label for="quick_message" class="block text-xs font-bold text-slate-700 mb-1.5">Kebutuhan Aki / Tipe Mesin</label>
                            <input type="text" 
                                   id="quick_message" 
                                   name="message" 
                                   required 
                                   placeholder="cth: Aki Truk N100 (10 Unit) / Genset" 
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-xs focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition">
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full py-3.5 px-6 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs sm:text-sm transition duration-200 shadow-xl shadow-slate-900/20 flex items-center justify-center gap-2 group">
                                <span>Kirim Sekarang</span>
                                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition transform"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-[11px] text-slate-500 pt-2 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-emerald-600"></i>
                        <span>Data Anda terenkripsi aman dan langsung ditangani oleh Key Account Manager Lynvo Energi.</span>
                    </div>
                </form>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 7. ARTIKEL & EDUKASI BATERAI (GRID 3 KOLOM DENGAN FOTO REAL THUMBNAIL) -->
    <!-- ========================================================================= -->
    <section class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-200/60 px-3.5 py-1.5 rounded-full inline-block mb-2">
                        EDUKASI & WAWASAN TEKNIS
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Panduan & Artikel Seputar Aki & Baterai Industri
                    </h2>
                    <p class="text-slate-600 text-sm mt-2 max-w-2xl">
                        Tingkatkan wawasan teknis Anda untuk memperpanjang usia pakai aki, memilih kapasitas yang presisi, dan menjaga kontinuitas daya operasional.
                    </p>
                </div>
            </div>

            <!-- 3 Columns Educational Real Photo Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $styleMap = [
                        ['border' => 'hover:border-blue-500/80', 'bg' => 'bg-blue-600', 'text' => 'group-hover:text-blue-600', 'link' => 'text-blue-600 hover:text-blue-800'],
                        ['border' => 'hover:border-emerald-500/80', 'bg' => 'bg-emerald-600', 'text' => 'group-hover:text-emerald-600', 'link' => 'text-emerald-600 hover:text-emerald-800'],
                        ['border' => 'hover:border-amber-500/80', 'bg' => 'bg-amber-600', 'text' => 'group-hover:text-amber-600', 'link' => 'text-amber-600 hover:text-amber-800'],
                    ];
                @endphp
                
                @forelse($articles as $article)
                @php
                    $style = $styleMap[$loop->index % 3];
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl {{ $style['border'] }} hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Photo Thumbnail -->
                        <div class="h-48 overflow-hidden relative bg-slate-100">
                            @if($article->image)
                                <img src="{{ Storage::url($article->image) }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                            @else
                                <img src="https://placehold.co/600x400/0f172a/ffffff?text={{ urlencode($article->category_name ?? 'Artikel') }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                            @endif
                            
                            @if($article->category_name)
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold {{ $style['bg'] }} text-white uppercase tracking-wider shadow">
                                {{ $article->category_name }}
                            </span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-base font-extrabold text-slate-900 {{ $style['text'] }} transition mb-2 leading-snug">
                                {{ $article->title }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                {{ $article->excerpt }}
                            </p>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : 'Baru' }}</span>
                            </div>
                        </div>
                    </div>
                    @if($article->action_label && $article->action_url)
                    <div class="p-6 pt-0 border-t border-slate-100 bg-slate-50/50">
                        <a href="{{ Str::startsWith($article->action_url, 'http') ? $article->action_url : url($article->action_url) }}" class="text-xs font-bold {{ $style['link'] }} flex items-center justify-between pt-3">
                            <span>{{ $article->action_label }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    @endif
                </div>
                @empty
                    <div class="col-span-full text-center text-slate-500 py-8">
                        Belum ada artikel edukasi terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 8. BONUS CONTINUITY: AUTHORIZED BRANDS -->
    <!-- ========================================================================= -->
    <section class="py-14 bg-white border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">AUTHORIZED BATTERY BRANDS</span>
                <h3 class="text-xl font-black text-slate-900 mt-1">Merek Aki Resmi yang Kami Distribusikan</h3>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 text-center">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand->slug) }}" 
                       class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-500 hover:shadow-md transition">
                        <span class="text-xs font-black text-slate-800 block">{{ $brand->name }}</span>
                        <span class="text-[10px] text-slate-400">100% Original</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

@endsection
