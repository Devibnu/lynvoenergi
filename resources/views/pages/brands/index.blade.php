@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white py-14 border-b border-slate-800 text-center">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fa-solid fa-certificate text-blue-400"></i>
                Authorized & Multi-Brand Distributor
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                Merk & Brand Aki Resmi Terpercaya
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Seluruh aki yang kami jual dijamin 100% original, fresh baru dari pabrikan resmi, bergaransi resmi, dan didukung sertifikasi mutu standar nasional & internasional.
            </p>
        </div>
    </section>

    <!-- BRANDS GRID -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($brands as $brand)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl transition flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center font-black text-blue-700 text-xl border border-slate-200 group-hover:bg-blue-600 group-hover:text-white transition">
                                    {{ substr($brand->name, 0, 2) }}
                                </div>
                                @if($brand->is_featured)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                        Paling Populer
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition mb-2">
                                {{ $brand->name }}
                            </h3>

                            <p class="text-xs text-slate-600 leading-relaxed mb-6">
                                {{ $brand->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-400 font-medium">
                                {{ $brand->products_count }} Tipe Tersedia
                            </span>
                            <a href="{{ route('brands.show', $brand->slug) }}" 
                               class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <span>Lihat Aki</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
