@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('schema_json')
    <script type="application/ld+json">
        {!! json_encode($schemaProduct, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')

    <!-- BREADCRUMB & HEADER -->
    <div class="bg-slate-900 text-white py-4 border-b border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <nav class="flex flex-wrap items-center gap-2 text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('products.index') }}" class="hover:text-white transition">Katalog Produk</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('products.category', $product->category->slug ?? 'aki') }}" class="hover:text-white transition">
                    {{ $product->category->name }}
                </a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <span class="text-blue-400 font-bold truncate max-w-xs sm:max-w-md">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- MAIN PRODUCT DETAILS -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <!-- Left Column: Product Visual Mockup & Quick Specs -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm text-center sticky top-24">
                        <!-- Battery Visual Box -->
                        <!-- Battery Visual Box -->
                        <div class="relative w-full h-64 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden mb-6 group border border-slate-200">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/800x600/f8fafc/334155?text=No+Image' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <!-- Quick Specs Summary Box -->
                        <div class="grid grid-cols-2 gap-3 text-left text-xs mb-6">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">SKU / Kode:</span>
                                <strong class="text-slate-900 font-bold">{{ $product->sku ?: 'LYN-' . $product->id }}</strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Tipe Baterai:</span>
                                <strong class="text-slate-900 font-bold">{{ $product->battery_type ?: 'Maintenance Free' }}</strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Kutub / Terminal:</span>
                                <strong class="text-slate-900 font-bold">{{ $product->terminal_type ?: 'Standard' }}</strong>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Dimensi (P x L x T):</span>
                                <strong class="text-slate-900 font-bold">{{ $product->dimensions ?: 'Standard Size' }}</strong>
                            </div>
                        </div>

                        <!-- Service Guarantees -->
                        <div class="space-y-2 text-xs text-slate-600 text-left border-t border-slate-100 pt-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                <span>100% Produk Baru & Bergaransi Resmi Pabrik</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-truck-fast text-blue-500"></i>
                                <span>Layanan Antar & Pasang di Tempat Se-Banten</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-recycle text-amber-500"></i>
                                <span>Menerima Tukar Tambah Aki Lama Anda</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Product Overview, Pricing, Features & Specs -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Title & Badges -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-wide">
                                {{ $product->brand }}
                            </span>
                            <a href="{{ route('products.category', $product->category->slug ?? 'aki') }}" 
                               class="px-3 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                {{ $product->category->name }}
                            </a>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight mb-4">
                            {{ $product->name }}
                        </h1>

                        <!-- Pricing Section -->
                        <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2">
                                <div>
                                    <span class="text-xs text-slate-500 block font-medium">Estimasi Harga Retail Pasang di Tempat:</span>
                                    <div class="text-2xl sm:text-3xl font-black text-slate-900">
                                        @if($product->is_price_visible && $product->price)
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        @else
                                            <span class="text-blue-600 text-xl">Harga: Hubungi Kami</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-xs text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg">
                                    ⚡ Potongan Tukar Tambah s/d Rp 150.000
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">
                                *Harga sudah termasuk pengiriman langsung ke lokasi, jasa pemasangan teknisi, dan gratis tes pengisian alternator dinamo.
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 mb-6">
                            <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm px-6 py-4 rounded-xl shadow-lg shadow-emerald-600/30 transition btn-wa-pulse">
                                <i class="fa-brands fa-whatsapp text-xl"></i>
                                <span>Pesan & Pasang via WhatsApp</span>
                            </a>
                            <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20kami%20ingin%20meminta%20Surat%20Penawaran%20Harga%20%28RFQ%29%20untuk%20produk%20{{ rawurlencode($product->name) }}%20untuk%20kebutuhan%20perusahaan%20kami." 
                               target="_blank"
                               class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm px-6 py-4 rounded-xl transition">
                                <i class="fa-solid fa-file-invoice-dollar text-amber-400"></i>
                                <span>Minta Penawaran B2B / PO</span>
                            </a>
                        </div>

                        <!-- Description Text -->
                        <div class="prose prose-slate max-w-none text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-6">
                            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                            <p>{{ $product->description ?: 'Aki berkualitas tinggi dengan performa andal dalam segala kondisi kerja operasional.' }}</p>
                        </div>
                    </div>

                    <!-- Key Features Box -->
                    @if(!empty($product->features) && is_array($product->features))
                        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-star text-amber-500"></i>
                                Keunggulan & Fitur Utama
                            </h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-700">
                                @foreach($product->features as $feature)
                                    <li class="flex items-start gap-2.5 p-3 rounded-lg bg-slate-50 border border-slate-100">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5 font-bold"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Detailed Technical Specification Table -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm overflow-hidden">
                        <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-blue-600"></i>
                            Spesifikasi Teknis Detail
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs sm:text-sm text-slate-700 border-collapse">
                                <tbody>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="py-3 px-4 font-bold text-slate-900 w-1/3">Merk / Brand</th>
                                        <td class="py-3 px-4 font-semibold text-blue-600">{{ $product->brand ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 px-4 font-bold text-slate-900">Kategori</th>
                                        <td class="py-3 px-4">{{ $product->category->name ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="py-3 px-4 font-bold text-slate-900">Tegangan (Voltage)</th>
                                        <td class="py-3 px-4 font-bold text-slate-900">{{ $product->voltage ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100">
                                        <th class="py-3 px-4 font-bold text-slate-900">Kapasitas (Capacity)</th>
                                        <td class="py-3 px-4 font-bold text-emerald-600">{{ $product->capacity_ah ? $product->capacity_ah . ' Ah' : '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-slate-100 bg-slate-50">
                                        <th class="py-3 px-4 font-bold text-slate-900">Cold Cranking Amps (CCA)</th>
                                        <td class="py-3 px-4">{{ $product->cca ? $product->cca . ' CCA' : '-' }}</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="py-3 px-4 font-bold text-slate-900">Cocok Untuk</th>
                                        <td class="py-3 px-4">{{ $product->compatibility ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Suitable Vehicles & Application Sectors -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                        <h3 class="text-base font-extrabold text-slate-900 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-car text-blue-600"></i>
                            Rekomendasi Kendaraan & Mesin
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ $product->compatibility ?: 'Cocok untuk berbagai kendaraan dan operasional mesin sesuai spesifikasi daya.' }}
                        </p>

                        @if($product->applications->count() > 0)
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                                Relevan untuk Sektor Industri:
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->applications as $app)
                                    <a href="{{ route('applications.show', $app->slug) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-600 hover:text-white text-xs font-semibold text-slate-700 transition">
                                        <i class="fa-solid fa-industry text-blue-500"></i>
                                        {{ $app->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RELATED PRODUCTS SECTION -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16 pt-12 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Pilihan Serupa</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Produk Aki Terkait</h2>
                        </div>
                        <a href="{{ route('products.index') }}" class="text-xs font-bold text-blue-600 hover:underline">
                            Lihat Semua Produk &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rel)
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-lg transition">
                                <div>
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 mb-2 inline-block">
                                        {{ $rel->brand }}
                                    </span>
                                    <h3 class="text-sm font-extrabold text-slate-900 mb-1 leading-snug">
                                        {{ $rel->name }}
                                    </h3>
                                    <p class="text-xs text-slate-500 mb-3">{{ $rel->capacity_ah ?? '-' }} Ah ({{ $rel->voltage ?? '-' }})</p>
                                </div>
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-xs font-black text-slate-900">
                                        @if($rel->is_price_visible && $rel->price)
                                            Rp {{ number_format($rel->price, 0, ',', '.') }}
                                        @else
                                            Hubungi Kami
                                        @endif
                                    </span>
                                    <a href="{{ route('products.show', [$rel->category->slug ?? 'aki', $rel->slug]) }}" 
                                       class="text-xs font-bold text-blue-600 hover:underline">
                                        Detail &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
