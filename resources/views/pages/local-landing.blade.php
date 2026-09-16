@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('schema_json')
    <script type="application/ld+json">
        {!! json_encode($schemaLocalBusiness, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode($schemaFaq, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')

    <!-- HERO SECTION: High Conversion Dual-Keyword (Aki & Accu) -->
    <section class="relative bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white pt-12 pb-20 overflow-hidden">
        <!-- Background Ambient Glow -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-600/20 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/3 -right-40 w-[400px] h-[300px] bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('services.battery_delivery') }}" class="hover:text-white transition">Layanan Antar Pasang</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <span class="text-blue-400 font-semibold">{{ $area->city_name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Column: Copywriting & CTAs -->
                <div class="lg:col-span-7">
                    <!-- Urgent Emergency Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm font-semibold mb-6 shadow-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>⚡ Layanan Antar & Pasang Aki / Accu Cepat di {{ $area->city_name }}</span>
                    </div>

                    <!-- Main H1 with Dual-Keyword -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-[1.15] mb-6">
                        Toko Aki & Accu <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-amber-300">{{ $area->city_name }}</span> — Beli Aki / Ganti Accu, Kami Antar & Pasang di Tempat!
                    </h1>

                    <!-- Subheadline & Value Proposition -->
                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                        Aki mobil Anda drop, soak, atau kendaraan mogok di jalan maupun rumah? 
                        <strong>Teknisi Lynvo Energi siap meluncur langsung ke lokasi Anda di wilayah {{ $area->city_name }}</strong>. 
                        Bawa aki baru 100% original, pasang langsung, gratis cek alternator kelistrikan, dan terima tukar tambah aki lama Anda!
                    </p>

                    <!-- Direct Dual CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ $area->whatsapp_url }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-emerald-600/30 transition transform hover:-translate-y-0.5 btn-wa-pulse">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                            <div class="text-left">
                                <span class="block text-xs font-medium text-emerald-100 uppercase tracking-wider leading-none">Respon Cepat 24 Jam</span>
                                <span class="block text-base font-extrabold leading-tight">Pesan Aki & Panggil Teknisi</span>
                            </div>
                        </a>
                        <a href="tel:081288889999" 
                           class="inline-flex items-center justify-center gap-3 bg-slate-800/80 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-base px-6 py-4 rounded-xl transition">
                            <i class="fa-solid fa-phone text-blue-400 text-xl"></i>
                            <div class="text-left">
                                <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider leading-none">Hotline Telepon</span>
                                <span class="block text-base font-bold text-white leading-tight">{{ \App\Models\Setting::getValue('hero_phone') }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- Quick Guarantee Pills -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs text-slate-300">
                        <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 p-2.5 rounded-lg">
                            <i class="fa-solid fa-truck-fast text-emerald-400"></i>
                            <span>Antar 30-60 Mnt</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 p-2.5 rounded-lg">
                            <i class="fa-solid fa-wrench text-blue-400"></i>
                            <span>Gratis Pasang</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 p-2.5 rounded-lg">
                            <i class="fa-solid fa-certificate text-amber-400"></i>
                            <span>Garansi Resmi</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 p-2.5 rounded-lg">
                            <i class="fa-solid fa-handshake text-teal-400"></i>
                            <span>Bayar di Tempat</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Emergency Card & Highlight Feature -->
                <div class="lg:col-span-5">
                    <div class="bg-gradient-to-b from-slate-800/90 to-slate-900/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur-md relative">
                        <div class="flex items-center justify-between pb-5 border-b border-slate-700 mb-6">
                            <div>
                                <span class="text-xs font-bold text-blue-400 uppercase tracking-wider block">Wilayah Siaga</span>
                                <h3 class="text-xl font-black text-white flex items-center gap-2 mt-0.5">
                                    <i class="fa-solid fa-map-pin text-rose-500"></i>
                                    {{ $area->city_name }}, Banten
                                </h3>
                            </div>
                            <span class="px-3 py-1 bg-emerald-950 text-emerald-300 border border-emerald-500/30 text-xs font-bold rounded-full">
                                Unit Ready
                            </span>
                        </div>

                        <!-- Highlights List -->
                        <div class="space-y-4 text-sm text-slate-300">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fa-solid fa-car-battery text-xs"></i>
                                </div>
                                <div>
                                    <strong class="text-white block font-semibold">Stok Aki Mobil & Truk Lengkap</strong>
                                    <span class="text-xs text-slate-400">Tersedia aki GS Astra, Yuasa, Incoe, Amaron, Varta, Bosch untuk semua merk mobil bensin, diesel & hybrid.</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fa-solid fa-gauge-high text-xs"></i>
                                </div>
                                <div>
                                    <strong class="text-white block font-semibold">Cek Dinamo Alternator & Arus Bocor</strong>
                                    <span class="text-xs text-slate-400">Teknisi membawa Digital Battery & Alternator Analyzer untuk memastikan sistem pengisian mobil Anda normal.</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fa-solid fa-recycle text-xs"></i>
                                </div>
                                <div>
                                    <strong class="text-white block font-semibold">Tukar Tambah Aki Bekas Dihargai Tinggi</strong>
                                    <span class="text-xs text-slate-400">Hemat budget ganti aki! Aki lama yang rusak kami beli dengan harga terbaik langsung potong nota.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Instant Action Box -->
                        <div class="mt-8 pt-6 border-t border-slate-700 bg-slate-950/50 -mx-6 -mb-6 sm:-mx-8 sm:-mb-8 p-6 rounded-b-2xl">
                            <p class="text-xs text-slate-400 text-center mb-3">
                                Butuh rekomendasi tipe aki yang pas untuk mobil Anda?
                            </p>
                            <a href="{{ $area->whatsapp_url }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded-xl text-sm transition">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                                Konsultasi Tipe Aki Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STEP-BY-STEP ORDERING FLOW -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Proses Praktis & Bebas Repot
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3">
                    Cara Mudah Pesan & Ganti Aki di {{ $area->city_name }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">
                    Tidak perlu capek dorong mobil atau datang ke bengkel. 4 langkah mudah aki baru terpasang rapi di kendaraan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="relative bg-slate-50 border border-slate-200/80 rounded-2xl p-6 hover:shadow-lg transition group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-xl mb-5 group-hover:scale-110 transition transform">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hubungi WhatsApp / Telp</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kirim lokasi Anda (share live location) dan sebutkan merk / tipe kendaraan Anda kepada admin kami.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative bg-slate-50 border border-slate-200/80 rounded-2xl p-6 hover:shadow-lg transition group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-xl mb-5 group-hover:scale-110 transition transform">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pilih Merk & Harga Aki</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Admin memberikan rekomendasi merk aki (GS Astra, Yuasa, Incoe, dll) dengan opsi harga transparan & diskon tukar tambah.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative bg-slate-50 border border-slate-200/80 rounded-2xl p-6 hover:shadow-lg transition group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-xl mb-5 group-hover:scale-110 transition transform">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Teknisi Tiba di Lokasi</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi berpengalaman meluncur dalam estimasi 30-60 menit membawa aki baru segel resmi langsung dari distributor.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative bg-slate-50 border border-slate-200/80 rounded-2xl p-6 hover:shadow-lg transition group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl mb-5 group-hover:scale-110 transition transform">
                        4
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pasang, Tes Dinamo & Bayar</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Aki dipasang, dinamo alternator dicek gratis. Setelah mobil hidup lancar, Anda baru melakukan pembayaran di tempat (COD/Transfer).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- POPULAR PRODUCTS CATALOG -->
    <section id="katalog" class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                        Stok Ready Siap Antar
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                        Pilihan Aki / Accu Terlaris di {{ $area->city_name }}
                    </h2>
                    <p class="text-slate-600 text-sm mt-1">
                        Aki 100% baru, bergaransi resmi, siap kirim dan pasang di tempat sekarang juga.
                    </p>
                </div>
                <a href="{{ $area->whatsapp_url }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                    <span>Tanya Tipe Aki Lainnya</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($popularProducts as $prod)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                        <!-- Product Image Placeholder -->
                        <div class="w-full h-40 overflow-hidden bg-slate-100 border-b border-slate-100">
                            <img src="https://placehold.co/400x300/f8fafc/334155?text=Foto+Produk+Aki" 
                                 alt="{{ $prod->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <!-- Top Card Badges -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wide">
                                    {{ $prod->brand ?? 'Aki Resmi' }}
                                </span>
                                <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    Garansi Resmi
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition leading-snug mb-2">
                                {{ $prod->name }}
                            </h3>

                            <!-- Specs Pill -->
                            <div class="flex flex-wrap gap-2 text-xs text-slate-600 mb-4 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                <span class="font-semibold"><i class="fa-solid fa-bolt text-amber-500 mr-1"></i>{{ $prod->voltage }}</span>
                                <span class="text-slate-300">•</span>
                                <span class="font-semibold"><i class="fa-solid fa-car-battery text-blue-500 mr-1"></i>{{ $prod->capacity_ah }} Ah</span>
                                @if($prod->cca)
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $prod->cca }} CCA</span>
                                @endif
                            </div>

                            <!-- Suitable vehicles preview -->
                            @if($prod->suitable_for)
                                <div class="text-xs text-slate-500 mb-4">
                                    <span class="font-semibold text-slate-700 block mb-0.5">Cocok untuk mobil:</span>
                                    <p class="line-clamp-2 text-[11px]">{{ $prod->suitable_for }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer & Pricing -->
                        <div class="p-6 pt-0 border-t border-slate-100 bg-slate-50/50">
                            <div class="py-3 flex items-baseline justify-between">
                                <div>
                                    <span class="text-[11px] text-slate-400 block font-medium">Harga Retail Mulai:</span>
                                    <span class="text-lg font-black text-slate-900">
                                        Rp {{ number_format($prod->price_retail ?? 850000, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-1 rounded">
                                    Bisa Tukar Tambah
                                </span>
                            </div>

                            <a href="{{ $prod->whatsapp_order_url }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-sm">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                                Pesan & Pasang Aki Ini
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Trade-In Value Box -->
            <div class="mt-10 bg-gradient-to-r from-amber-50 via-amber-100/50 to-amber-50 border border-amber-200/80 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="fa-solid fa-recycle"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900">Program Tukar Tambah Aki Bekas (Trade-In Extra Hemat)</h4>
                        <p class="text-sm text-slate-700 mt-1 max-w-2xl">
                            Jangan buang aki lama Anda! Tukar aki mati/soak Anda saat teknisi tiba untuk potongan harga langsung sebesar 
                            <strong class="text-amber-800">Rp 50.000 hingga Rp 250.000</strong> per unit.
                        </p>
                    </div>
                </div>
                <a href="{{ $area->whatsapp_url }}" 
                   target="_blank"
                   class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl whitespace-nowrap shadow transition">
                    Cek Nilai Tukar Tambah Aki
                </a>
            </div>
        </div>
    </section>

    <!-- DISTRICT COVERAGE & LOCAL SEO KEYWORD SECTION -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-5">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Jangkauan Layanan {{ $area->city_name }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3 mb-4">
                        Cakupan Wilayah Antar Pasang Aki Cepat di {{ $area->city_name }}
                    </h2>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        {{ $area->custom_intro_text ?: "Lynvo Energi melayani pengiriman dan pemasangan aki darurat untuk rumah tangga, perkantoran, ruko, bengkel, serta pabrik dan pergudangan di seluruh penjuru {$area->city_name} dan sekitarnya." }}
                    </p>
                    
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-headset text-blue-600"></i>
                            Hotline Darurat {{ $area->city_name }}
                        </h4>
                        <p class="text-sm font-semibold text-slate-900">
                            Pesan sekarang, teknisi terdekat langsung menuju lokasi:
                        </p>
                        <a href="{{ $area->whatsapp_url }}" target="_blank" class="text-emerald-600 font-extrabold text-base hover:underline block mt-1">
                            <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp: {{ \App\Models\Setting::getValue('hero_phone') }}
                        </a>
                    </div>
                </div>

                <!-- District Tags Cloud -->
                <div class="lg:col-span-7">
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8">
                        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                            Daftar Kecamatan & Kawasan yang Kami Layani:
                        </h3>
                        
                        @php
                            $districts = array_map('trim', explode(',', $area->district_coverage));
                        @endphp

                        <div class="flex flex-wrap gap-2.5">
                            @foreach($districts as $district)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-800 shadow-sm hover:border-blue-400 hover:text-blue-600 transition">
                                    <i class="fa-solid fa-location-dot text-[11px] text-blue-500"></i>
                                    Aki {{ $district }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Other Banten Area Links -->
                        <div class="mt-8 pt-6 border-t border-slate-200">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                                Layanan di Wilayah Banten Lainnya:
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($otherAreas as $other)
                                    <a href="{{ route('local.landing', $other->slug) }}" 
                                       class="text-xs font-semibold text-slate-700 bg-slate-200/80 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg transition">
                                        Toko Aki {{ $other->city_name }} &rarr;
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TRUST & VALUE MATRIX -->
    <section class="py-16 bg-slate-900 text-white">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-400 bg-emerald-950 px-3 py-1 rounded-full border border-emerald-500/30">
                    Kenapa Memilih Lynvo Energi?
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white mt-3">
                    Keunggulan Layanan Toko Aki & Accu Lynvo Energi
                </h2>
                <p class="text-slate-400 text-sm mt-2">
                    Kami memberikan jaminan kenyamanan, kepastian originalitas, dan keselamatan sistem kelistrikan kendaraan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700">
                    <div class="w-12 h-12 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center text-2xl mb-4">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">100% Baru & Segel Pabrik</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Kami tidak menjual aki rekondisi/bekas. Semua aki kami fresh baru dari pabrikan resmi (Astra Otoparts, Yuasa Battery, Amaron).
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center text-2xl mb-4">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Peralatan Digital Modern</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Pengecekan aki dan dinamo alternator menggunakan Digital CCA Tester akurat, memastikan apakah aki Anda benar-benar perlu diganti atau hanya kendala pengisian.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700">
                    <div class="w-12 h-12 rounded-xl bg-amber-600/20 text-amber-400 flex items-center justify-center text-2xl mb-4">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Garansi Jelas & Mudah Diklaim</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Dapatkan kartu garansi resmi toko dan pabrik. Jika ada kendala selama masa garansi, tim teknisi kami siap bantu pengecekan dan penggantian unit baru.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ ACCORDION SECTION -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Frequently Asked Questions
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                    Pertanyaan Seputar Toko Aki {{ $area->city_name }}
                </h2>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <details class="group bg-slate-50 border border-slate-200 rounded-xl p-5 [&_summary::-webkit-details-marker]:hidden" {{ $index === 0 ? 'open' : '' }}>
                        <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-question text-blue-600"></i>
                                {{ $faq['question'] }}
                            </span>
                            <span class="ml-4 flex-shrink-0 transition duration-300 group-open:-rotate-180">
                                <i class="fa-solid fa-chevron-down text-xs text-slate-500"></i>
                            </span>
                        </summary>
                        <p class="mt-4 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            {{ $faq['answer'] }}
                        </p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FINAL CALL TO ACTION BANNER -->
    <section class="bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 text-white py-14">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 text-center">
            <h2 class="text-2xl sm:text-4xl font-black mb-4">
                Mobil Mogok di {{ $area->city_name }}? Jangan Panik, Kami Siap Datang!
            </h2>
            <p class="text-slate-200 text-sm sm:text-base max-w-2xl mx-auto mb-8">
                Hubungi kami sekarang. Teknisi berpengalaman segera meluncur ke lokasi Anda membawa aki baru bergaransi resmi.
            </p>
            <a href="{{ $area->whatsapp_url }}" 
               target="_blank"
               class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-base px-8 py-4 rounded-xl shadow-2xl transition transform hover:scale-105">
                <i class="fa-brands fa-whatsapp text-2xl text-slate-950"></i>
                <span>Panggil Teknisi ke Lokasi Sekarang (WA)</span>
            </a>
        </div>
    </section>

@endsection
