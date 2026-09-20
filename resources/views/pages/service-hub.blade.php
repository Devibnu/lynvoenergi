@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO SECTION -->
    <section class="relative bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white pt-14 pb-20 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-600/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-950/80 border border-blue-500/40 text-blue-300 text-xs sm:text-sm font-semibold mb-6 shadow-sm">
                <i class="fa-solid fa-truck-fast text-blue-400"></i>
                <span>Layanan Home Service & Emergency Delivery Se-Provinsi Banten</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight max-w-4xl mx-auto mb-6">
                Pesan Antar & Pasang <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-amber-300">Aki / Accu 24 Jam</span> di Seluruh Wilayah Banten
            </h1>

            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
                Aki drop di rumah, kantor, jalan tol, atau pabrik? Teknisi Lynvo Energi meluncur cepat membawa aki baru bergaransi resmi, pasang di tempat, dan cek kelistrikan alternator <strong>GRATIS</strong>.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ \App\Models\Setting::getWhatsappUrl('Halo Lynvo Energi, saya butuh layanan pesan antar aki di Banten.') }}"
                   target="_blank"
                   class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-emerald-600/30 transition transform hover:-translate-y-0.5 btn-wa-pulse">
                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                    <span>Panggil Teknisi Terdekat Sekarang</span>
                </a>
                <a href="#area-layanan" 
                   class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-base px-6 py-4 rounded-xl transition">
                    <span>Pilih Kota / Area Layanan</span>
                    <i class="fa-solid fa-arrow-down text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 4 MAIN COVERAGE AREAS GRID -->
    <section id="area-layanan" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Jaringan Outlet & Siaga Teknisi
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3">
                    Pilih Wilayah Layanan Anda di Banten
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">
                    Setiap area didukung oleh teknisi armada motor dan mobil cepat untuk menjangkau titik lokasi Anda secara presisi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($coverageAreas as $area)
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-7 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition">
                                            Toko Aki {{ $area->city_name }}
                                        </h3>
                                        <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Delivery 24 Jam Aktif
                                        </span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-white border border-slate-200 text-xs font-bold text-slate-600 rounded-full">
                                    Banten
                                </span>
                            </div>

                            <p class="text-sm text-slate-600 mb-5 leading-relaxed">
                                {{ $area->custom_intro_text ?: $area->hero_title }}
                            </p>

                            <!-- Districts Preview -->
                            <div class="mb-6">
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">
                                    Cakupan Kecamatan:
                                </span>
                                <p class="text-xs text-slate-500 line-clamp-2 bg-white p-3 rounded-lg border border-slate-200/80">
                                    {{ $area->district_coverage }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-200/80">
                            <a href="{{ route('local.landing', $area->slug) }}" 
                               class="w-full sm:w-1/2 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-4 rounded-xl transition">
                                Lihat Info Wilayah &rarr;
                            </a>
                            <a href="{{ $area->whatsapp_url }}" 
                               target="_blank"
                               class="w-full sm:w-1/2 text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-4 rounded-xl transition flex items-center justify-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                Panggil Teknisi
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SUPPORTED VEHICLE & SECTOR APPLICATIONS -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                    Kategori Kendaraan & Mesin
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3">
                    Aki untuk Segala Kebutuhan Kendaraan & Industri
                </h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-car-side text-3xl text-blue-600 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Mobil Penumpang</h4>
                    <p class="text-[11px] text-slate-500 mt-1">MPV, SUV, Sedan, City Car</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-truck text-3xl text-emerald-600 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Truk & Armada</h4>
                    <p class="text-[11px] text-slate-500 mt-1">Canter, Fuso, Tronton, Bus</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-hard-hat text-3xl text-amber-500 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Alat Berat</h4>
                    <p class="text-[11px] text-slate-500 mt-1">Excavator, Loader, Bulldozer</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-ship text-3xl text-cyan-600 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Kapal / Marine</h4>
                    <p class="text-[11px] text-slate-500 mt-1">Tugboat, Speedboat, Tongkang</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-bolt text-3xl text-rose-500 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Genset Industri</h4>
                    <p class="text-[11px] text-slate-500 mt-1">20 kVA - 2000 kVA Standby</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-500 transition">
                    <i class="fa-solid fa-dolly text-3xl text-purple-600 mb-3 block"></i>
                    <h4 class="font-bold text-sm text-slate-900">Forklift Gudang</h4>
                    <p class="text-[11px] text-slate-500 mt-1">Diesel & Elektrik Battery</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED BATTERY PRODUCTS -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Katalog Populer
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                        Pilihan Aki / Accu Terlaris
                    </h2>
                </div>
                <a href="{{ \App\Models\Setting::getWhatsappUrl() }}" target="_blank" class="text-sm font-bold text-emerald-600 hover:underline">
                    Konsultasi Tipe Aki via WhatsApp &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredProducts as $prod)
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between group">
                        <!-- Product Image Placeholder -->
                        <div class="w-full h-40 overflow-hidden bg-slate-100 border-b border-slate-100">
                            <img src="https://placehold.co/400x300/f8fafc/334155?text=Foto+Produk+Aki" 
                                 alt="{{ $prod->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold px-2.5 py-1 rounded bg-blue-100 text-blue-800">
                                    {{ $prod->getRelationValue('brand')?->name ?? $prod->brand }}
                                </span>
                                <span class="text-xs font-semibold text-emerald-600">Garansi Resmi</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 mb-2">{{ $prod->name }}</h3>
                            <div class="text-xs text-slate-600 mb-4">
                                <p><i class="fa-solid fa-car-battery text-blue-500 mr-1"></i>{{ $prod->capacity_ah }} Ah ({{ $prod->voltage }})</p>
                                @if($prod->suitable_for)
                                    <p class="mt-2 text-slate-500 line-clamp-2">Cocok: {{ $prod->suitable_for }}</p>
                                @endif
                            </div>
                        </div>
                            <div class="pt-4 mt-auto border-t border-slate-200 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Harga Retail Mulai</span>
                                    <span class="text-base font-black text-slate-900">
                                        Rp {{ number_format($prod->price_retail ?? 850000, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ $prod->whatsapp_order_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-lg">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
