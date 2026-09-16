@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO SECTION -->
    <section class="bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white py-14 border-b border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('applications.index') }}" class="hover:text-white transition">Sektor Aplikasi</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <span class="text-blue-400 font-bold">{{ $application->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-500/30">
                        <i class="fa-solid fa-{{ $application->icon ?: 'industry' }} text-blue-400"></i>
                        <span>Solusi Industri B2B</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                        Aki & Baterai Sektor <span class="text-blue-400">{{ $application->name }}</span>
                    </h1>

                    <p class="text-lg font-bold text-amber-300 mb-4">
                        {{ $application->hero_headline }}
                    </p>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-3xl mb-8">
                        {{ $application->description }} Kami menyediakan produk bersertifikasi mutu tinggi dengan daya tahan getaran ekstra, cold cranking amps masif, dan garansi langsung distributor untuk menjamin kelancaran operasional non-stop.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20kami%20ingin%20meminta%20penawaran%20harga%20aki%20untuk%20sektor%20{{ rawurlencode($application->name) }}." 
                           target="_blank"
                           class="bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            <span>Minta Penawaran B2B Sektor Ini</span>
                        </a>
                        <a href="#produk-sektor" 
                           class="bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-sm px-5 py-3.5 rounded-xl transition">
                            Lihat Produk Terkait &darr;
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4 hidden lg:block text-center">
                    <div class="w-44 h-44 mx-auto rounded-3xl bg-gradient-to-tr from-blue-700 to-slate-800 flex items-center justify-center text-7xl text-white shadow-2xl border border-blue-500/30">
                        <i class="fa-solid fa-{{ $application->icon ?: 'industry' }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RELATED BATTERY PRODUCTS FOR THIS APPLICATION -->
    <section id="produk-sektor" class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Rekomendasi Baterai
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                        Pilihan Aki Terbaik untuk Sektor {{ $application->name }}
                    </h2>
                </div>
                <span class="text-xs text-slate-500 font-semibold">
                    Total: {{ $application->products->count() }} produk terverifikasi
                </span>
            </div>

            @if($application->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($application->products as $product)
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl transition flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-blue-100 text-blue-800">
                                        {{ $product->brand ?? 'Aki Resmi' }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                        {{ $product->category?->name }}
                                    </span>
                                </div>

                                <a href="{{ route('products.show', [$product->category?->slug ?? 'aki', $product->slug]) }}" class="block">
                                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition leading-snug mb-2">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <div class="flex flex-wrap gap-2 text-xs text-slate-600 mb-4 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <span class="font-semibold">{{ $product->voltage }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="font-semibold">{{ $product->capacity_ah }} Ah</span>
                                    @if($product->cca)
                                        <span class="text-slate-300">•</span>
                                        <span>{{ $product->cca }} CCA</span>
                                    @endif
                                </div>

                                @if($product->suitable_for)
                                    <p class="text-xs text-slate-500 line-clamp-2 mb-4">
                                        <strong class="text-slate-700">Cocok:</strong> {{ $product->suitable_for }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Harga Retail:</span>
                                    <span class="text-sm font-black text-slate-900">
                                        @if($product->price_retail)
                                            Rp {{ number_format($product->price_retail, 0, ',', '.') }}
                                        @else
                                            <span class="text-blue-600 text-xs font-bold">RFQ / Hubungi B2B</span>
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('products.show', [$product->category?->slug ?? 'aki', $product->slug]) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-3.5 py-2 rounded-lg transition">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <p class="text-sm text-slate-500">Hubungi tim technical support kami untuk mendapatkan penawaran aki kustom sektor ini.</p>
                </div>
            @endif

            <!-- OTHER SECTORS NAVIGATION -->
            <div class="mt-16 pt-10 border-t border-slate-200">
                <h3 class="text-base font-bold text-slate-900 mb-4">Eksplorasi Sektor Industri Lainnya:</h3>
                <div class="flex flex-wrap gap-2.5">
                    @foreach($otherApplications as $other)
                        <a href="{{ route('applications.show', $other->slug) }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 text-xs font-bold text-slate-700 shadow-sm transition">
                            <i class="fa-solid fa-{{ $other->icon ?: 'industry' }} text-blue-500"></i>
                            {{ $other->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
