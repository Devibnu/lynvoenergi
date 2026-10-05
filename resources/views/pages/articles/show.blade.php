@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)
@section('og_type', 'article')
@if($article->image)
    @section('og_image', asset('storage/' . $article->image))
@endif

@section('schema_json')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": "{{ $article->title }}",
  "image": "{{ $article->image ? asset('storage/' . $article->image) : '' }}",
  "datePublished": "{{ $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String() }}",
  "author": {
    "@@id": "{{ url('/') }}#organization"
  }
}
</script>
@endsection

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-slate-950 pt-20 pb-12 border-b border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-1.5 text-slate-400 hover:text-white text-sm font-semibold transition mb-6">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Daftar Artikel
            </a>

            <div class="flex flex-wrap items-center gap-3 mb-4 text-xs font-semibold">
                @if($article->category_name)
                    <span class="px-2.5 py-1 rounded-md bg-blue-600 text-white">
                        {{ $article->category_name }}
                    </span>
                @endif
                <span class="text-slate-400 flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar"></i>
                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight mb-6 leading-tight">
                {{ $article->title }}
            </h1>
            
            @if($article->excerpt)
            <p class="text-slate-300 text-lg leading-relaxed mb-6 font-medium">
                {{ $article->excerpt }}
            </p>
            @endif
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            @if($article->image)
                <div class="w-full rounded-2xl overflow-hidden mb-12 shadow-lg border border-slate-100">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" width="1200" height="800" fetchpriority="high" loading="eager" decoding="async" class="w-full object-cover">
                </div>
            @endif

            <!-- Markdown / HTML Content Wrapper -->
            <div class="prose prose-slate prose-lg max-w-none 
                        prose-headings:font-black prose-headings:text-slate-900 
                        prose-a:text-blue-600 prose-a:font-semibold hover:prose-a:text-blue-700
                        prose-img:rounded-xl prose-img:shadow-sm mb-12">
                {!! $article->content !!}
            </div>
            
            @if($article->action_label && $article->action_url)
                <div class="mt-8 mb-12 p-6 bg-blue-50 border border-blue-100 rounded-xl text-center">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">Punya pertanyaan seputar informasi ini?</h4>
                    <a href="{{ $article->action_url }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-md">
                        {{ $article->action_label }} <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif

            <!-- COMMERCIAL BRIDGE -->
            @if(!($article->action_label && $article->action_url))
                <div class="mt-8 mb-12 p-6 bg-slate-50 border border-slate-200 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 mb-1">Lagi Cari Aki Berkualitas?</h4>
                        <p class="text-sm text-slate-600">Temukan pilihan aki terbaik untuk berbagai kebutuhan di katalog produk kami.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="shrink-0 inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition shadow-sm">
                        Lihat Katalog Produk <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            @endif

            <hr class="border-slate-200 mb-12">

            <!-- RELATED ARTICLES -->
            @if($relatedArticles->count() > 0)
                <h3 class="text-2xl font-black text-slate-900 mb-6 tracking-tight">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $related)
                        <div class="bg-slate-50 rounded-xl border border-slate-100 overflow-hidden hover:shadow-md transition group">
                            <div class="h-40 overflow-hidden bg-slate-200">
                                <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://placehold.co/400x300/f8fafc/334155?text=Artikel' }}" 
                                     alt="{{ $related->title }}" 
                                     width="400"
                                     height="300"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5">
                                <a href="{{ route('articles.show', $related->slug) }}" class="block">
                                    <h4 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition mb-2 line-clamp-2 leading-snug">
                                        {{ $related->title }}
                                    </h4>
                                </a>
                                <div class="text-[10px] text-slate-500 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

@endsection
