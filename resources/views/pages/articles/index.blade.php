@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white py-14 border-b border-slate-800 text-center">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fa-solid fa-newspaper text-blue-400"></i>
                Blog & Artikel
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                Pusat Informasi & Edukasi Baterai Industri
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Temukan kabar terbaru, tips perawatan, serta panduan teknis seputar aki genset, UPS, alat berat, dan otomotif dari pakar Lynvo Energi.
            </p>
        </div>
    </section>

    <!-- ARTICLES GRID -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                            <!-- Article Image Placeholder -->
                            <div class="w-full h-56 overflow-hidden bg-slate-100 border-b border-slate-100">
                                <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://placehold.co/600x400/f8fafc/334155?text=Artikel' }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 rounded-t-xl">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                                    @if($article->category_name)
                                        <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 font-bold">
                                            {{ $article->category_name }}
                                        </span>
                                    @endif
                                    <div class="flex items-center gap-1.5 ml-auto">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('articles.show', $article->slug) }}" class="block">
                                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition mb-3 leading-snug line-clamp-2">
                                        {{ $article->title }}
                                    </h3>
                                </a>

                                <p class="text-xs text-slate-600 line-clamp-3 mb-5 leading-relaxed">
                                    {{ $article->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                                </p>
                            </div>

                            <div class="p-6 pt-0 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   class="text-xs font-bold text-blue-600 hover:underline pt-3 flex items-center gap-1">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center max-w-2xl mx-auto shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Artikel</h3>
                    <p class="text-sm text-slate-500 mb-6">Saat ini belum ada artikel atau blog yang dipublikasikan. Silakan kembali lagi nanti untuk membaca pembaruan terbaru dari kami.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection
