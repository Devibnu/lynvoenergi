@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@push('styles')
<style>
/* Force filter sidebar always visible on desktop regardless of Alpine state */
@media (min-width: 1024px) {
    .filter-panel { display: block !important; }
}
</style>
@endpush

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white py-12 border-b border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('products.index') }}" class="text-blue-400 font-semibold">Katalog Produk</a>
                @if($selectedCategory)
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                    <span class="text-white font-bold">{{ $selectedCategory->name }}</span>
                @endif
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                        @if($selectedCategory)
                            {{ $selectedCategory->name }}
                        @else
                            Katalog Aki & Accu Terlengkap
                        @endif
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-2xl">
                        @if($selectedCategory)
                            {{ $selectedCategory->description }}
                        @else
                            Distributor aki resmi GS Astra, Yuasa, Incoe, Amaron, Varta, Bosch. Melayani eceran ganti aki di tempat & pengadaan B2B proyek se-Banten.
                        @endif
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('katalog.pdf') }}" 
                       class="inline-flex items-center gap-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-blue-600/30 whitespace-nowrap transition">
                        <i class="fa-solid fa-download text-lg"></i>
                        <span>Download Katalog PDF</span>
                    </a>
                    <!-- Fast WhatsApp Order Button -->
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20mau%20tanya%20stok%20dan%20harga%20aki." 
                       target="_blank"
                       class="inline-flex items-center gap-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-emerald-600/30 whitespace-nowrap transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Tanya Tipe Aki via WA</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CATALOG CONTAINER WITH SIDEBAR -->
    <section class="py-12 bg-slate-50 min-h-[600px]">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start"
                 x-data="{ showFilter: false }">

                <!-- SIDEBAR FILTERS -->
                <div>
                    <!-- Mobile Filter Toggle Button -->
                    <button @click="showFilter = !showFilter"
                            class="lg:hidden w-full flex items-center justify-between gap-2 bg-white border border-slate-200 shadow-sm rounded-xl px-4 py-3 mb-3 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:border-blue-300 transition">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-blue-600"></i>
                            <span x-text="showFilter ? 'Sembunyikan Filter' : 'Tampilkan Filter'"></span>
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="showFilter ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Filter Panel: hidden on mobile until toggled, always visible on desktop -->
                    <div x-show="showFilter"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="filter-panel bg-white rounded-2xl border border-slate-200 p-6 shadow-sm lg:sticky lg:top-24"
                         x-cloak>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-blue-600"></i>
                            Filter Produk
                        </h3>
                        @if(request()->hasAny(['q', 'category', 'brand', 'battery_type', 'min_ah', 'max_ah', 'sort']))
                            <a href="{{ route('products.index') }}" class="text-xs text-rose-600 hover:underline font-semibold">
                                Reset
                            </a>
                        @endif
                    </div>

                    <form action="{{ $selectedCategory ? route('products.category', $selectedCategory->slug) : route('products.index') }}" method="GET" class="space-y-6">
                        <!-- Search Box -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Cari Nama / SKU / Mobil
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="q" 
                                       value="{{ request('q') }}" 
                                       placeholder="Contoh: NS40ZL, Avanza..." 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-9">
                                <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-blue-600">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Categories List -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                                Kategori Aki
                            </label>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1 text-xs">
                                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']))) }}" 
                                   class="flex items-center justify-between px-3 py-2 rounded-lg transition {{ empty($selectedCategory) && !request('category') ? 'bg-blue-600 text-white font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
                                    <span>Semua Kategori</span>
                                </a>
                                @foreach($categories as $cat)
                                    @php
                                        $isActive = ($selectedCategory && $selectedCategory->id === $cat->id) || request('category') === $cat->slug;
                                    @endphp
                                    <a href="{{ route('products.category', $cat->slug) }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-lg transition {{ $isActive ? 'bg-blue-600 text-white font-bold' : 'text-slate-700 hover:bg-slate-100' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="text-[11px] opacity-80">({{ $cat->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brand Checkboxes -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                                Merek / Brand
                            </label>
                            <div class="space-y-2 max-h-44 overflow-y-auto pr-1 text-xs text-slate-700">
                                @foreach($brands as $b)
                                    <label class="flex items-center justify-between cursor-pointer hover:text-blue-600">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" 
                                                   name="brand[]" 
                                                   value="{{ $b->slug }}" 
                                                   {{ in_array($b->slug, (array) request('brand', [])) ? 'checked' : '' }}
                                                   onchange="this.form.submit()"
                                                   class="rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                                            <span>{{ $b->name }}</span>
                                        </div>
                                        <span class="text-slate-400 text-[10px]">({{ $b->products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Capacity (Ah) Filter -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Kapasitas (Ah)
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" 
                                       name="min_ah" 
                                       value="{{ request('min_ah') }}" 
                                       placeholder="Min Ah" 
                                       class="bg-slate-50 border border-slate-200 rounded-lg p-2 text-xs">
                                <input type="number" 
                                       name="max_ah" 
                                       value="{{ request('max_ah') }}" 
                                       placeholder="Max Ah" 
                                       class="bg-slate-50 border border-slate-200 rounded-lg p-2 text-xs">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-2.5 rounded-xl transition shadow">
                            Terapkan Filter
                        </button>
                    </form>
                    </div>
                </div>

                <!-- PRODUCTS GRID & TOOLBAR -->
                <div class="lg:col-span-3">
                    <!-- Top Toolbar -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 mb-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="text-xs text-slate-600">
                            Menampilkan <strong class="text-slate-900 font-bold">{{ $products->total() }}</strong> produk aki terverifikasi
                        </div>

                        <!-- Sorting -->
                        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                            @foreach(request()->except('sort') as $k => $v)
                                @if(is_array($v))
                                    @foreach($v as $subV)
                                        <input type="hidden" name="{{ $k }}[]" value="{{ $subV }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endif
                            @endforeach
                            <label for="sort" class="text-xs text-slate-500 whitespace-nowrap">Urutkan:</label>
                            <select name="sort" 
                                    id="sort" 
                                    onchange="this.form.submit()" 
                                    class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-semibold focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling Populer</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="capacity_desc" {{ request('sort') === 'capacity_desc' ? 'selected' : '' }}>Kapasitas (Ah) Terbesar</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                                    <!-- Product Image Placeholder -->
                                    <div class="w-full h-48 overflow-hidden bg-slate-100 border-b border-slate-100">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/f8fafc/334155?text=No+Image' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-xl group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="p-6">
                                        <!-- Card Top Badges -->
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wide">
                                                {{ $product->brand }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                                {{ $product->category->name }}
                                            </span>
                                        </div>

                                        <!-- Product Title -->
                                        <a href="{{ route('products.show', [$product->category?->slug ?? 'aki', $product->slug]) }}" class="block">
                                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition leading-snug mb-2">
                                                {{ $product->name }}
                                            </h3>
                                        </a>

                                        <!-- Specs Pill -->
                                        <div class="flex flex-wrap gap-2 text-xs text-slate-600 mb-4 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                            {{ $product->voltage ?? '-' }} • {{ $product->capacity_ah ?? '-' }} Ah • {{ $product->cca ?? '-' }} CCA
                                        </div>

                                        <!-- Suitable preview -->
                                        @if($product->compatibility)
                                            <p class="text-xs text-slate-500 line-clamp-2 mb-4">
                                                <strong class="text-slate-700">Cocok:</strong> {{ $product->compatibility }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Bottom Action & Pricing -->
                                    <div class="p-6 pt-0 border-t border-slate-100 bg-slate-50/50">
                                        <div class="py-3 flex items-baseline justify-between">
                                            <div>
                                                <span class="text-[10px] text-slate-400 block font-medium">Harga Retail</span>
                                                @if($product->is_price_visible && $product->price)
                                                    <p class="text-lg font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                @else
                                                    <p class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-md inline-block">Harga: Hubungi Kami</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 mt-1">
                                            <a href="{{ route('products.show', [$product->category?->slug ?? 'aki', $product->slug]) }}" 
                                               class="text-center bg-white hover:bg-slate-100 text-slate-800 border border-slate-200 font-bold text-xs py-2.5 px-2 rounded-xl transition">
                                                Lihat Detail
                                            </a>
                                            <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}" 
                                               target="_blank" 
                                               class="text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-2 rounded-xl transition flex items-center justify-center gap-1">
                                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                                Pesan WA
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                            <i class="fa-solid fa-car-battery text-5xl text-slate-300 mb-4 block"></i>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Tidak Ada Produk yang Sesuai</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                                Coba kurangi filter atau cari dengan kata kunci lain. Hubungi admin kami jika Anda mencari spesifikasi aki khusus.
                            </p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl">
                                Reset Semua Filter
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
