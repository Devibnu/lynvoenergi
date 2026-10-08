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

@php
    $publishedDate = $article->published_at ?? $article->created_at;
    $articleUrl = url()->current();
    $shareText = $article->title . ' — ' . $articleUrl;
    $waConsultUrl = \App\Models\Setting::getWhatsappUrl('Halo Lynvo Energi, saya ingin konsultasi setelah membaca artikel: ' . $article->title);
    $waTechnicianUrl = \App\Models\Setting::getWhatsappUrl('Halo Lynvo Energi, saya butuh bantuan pesan antar aki sekarang.');
    $phoneUrl = \App\Models\Setting::getPhoneUrl();
@endphp

@section('content')

<article class="bg-white">

    {{-- ============ ARTICLE HEADER ============ --}}
    <header class="relative bg-slate-950 border-b border-slate-800 overflow-hidden">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-60"
             style="background: radial-gradient(60% 80% at 85% 0%, rgba(37,99,235,.22), transparent 70%);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-8 sm:pt-8 sm:pb-10">

            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb" class="mb-5 sm:mb-6">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[13px] sm:text-sm text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 rounded transition">Beranda</a></li>
                    <li aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i></li>
                    <li><a href="{{ route('articles.index') }}" class="hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 rounded transition">Artikel &amp; Edukasi</a></li>
                    <li aria-hidden="true" class="hidden sm:block"><i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i></li>
                    <li aria-current="page" class="hidden sm:block text-slate-300 truncate max-w-xs lg:max-w-md">{{ $article->title }}</li>
                </ol>
            </nav>

            <div class="lg:max-w-[960px]">
                {{-- Category + date --}}
                <div class="flex flex-wrap items-center gap-3 mb-4 text-sm font-semibold">
                    @if($article->category_name)
                        <span class="inline-flex items-center px-3 py-1 rounded-md bg-emerald-500/15 text-emerald-300 border border-emerald-400/30 text-xs uppercase tracking-wider">
                            {{ $article->category_name }}
                        </span>
                    @endif
                    <time datetime="{{ $publishedDate->toDateString() }}" class="text-slate-400 flex items-center gap-1.5 font-medium">
                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                        {{ $publishedDate->format('d M Y') }}
                    </time>
                </div>

                {{-- H1 (only one on the page) --}}
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight break-words leading-[1.1]">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                    <p class="mt-4 sm:mt-5 text-slate-300 text-[18px] leading-[1.5] sm:text-[19px] sm:leading-[1.6] max-w-[760px]">
                        {{ $article->excerpt }}
                    </p>
                @endif

                {{-- Share --}}
                <div class="mt-6 flex flex-wrap items-center gap-3" x-data="{ copied: false }">
                    <span class="text-[13px] sm:text-sm font-semibold text-slate-400 mr-1">Bagikan:</span>
                    <a href="https://wa.me/?text={{ rawurlencode($shareText) }}" target="_blank" rel="noopener"
                       aria-label="Bagikan via WhatsApp"
                       class="share-btn hover:bg-emerald-600 hover:border-emerald-500 w-11 h-11">
                        <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($articleUrl) }}" target="_blank" rel="noopener"
                       aria-label="Bagikan ke Facebook"
                       class="share-btn hover:bg-blue-600 hover:border-blue-500 w-11 h-11">
                        <i class="fa-brands fa-facebook-f text-sm" aria-hidden="true"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ rawurlencode($articleUrl) }}&text={{ rawurlencode($article->title) }}" target="_blank" rel="noopener"
                       aria-label="Bagikan ke X"
                       class="share-btn hover:bg-slate-700 hover:border-slate-500 w-11 h-11">
                        <i class="fa-brands fa-x-twitter text-sm" aria-hidden="true"></i>
                    </a>
                    <button type="button"
                            @click="navigator.clipboard.writeText(@js($articleUrl)).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                            :aria-label="copied ? 'Link tersalin' : 'Salin link artikel'"
                            aria-label="Salin link artikel"
                            class="share-btn hover:bg-slate-700 hover:border-slate-500 w-11 h-11">
                        <i class="fa-solid text-sm" :class="copied ? 'fa-check text-emerald-400' : 'fa-link'" aria-hidden="true"></i>
                    </button>
                    <span x-show="copied" x-cloak x-transition.opacity class="text-xs font-semibold text-emerald-400" role="status">Link tersalin</span>
                </div>
            </div>
        </div>
    </header>

    {{-- ============ MAIN + SIDEBAR ============ --}}
    <div class="bg-slate-50/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-[32px]">

                {{-- MAIN ARTICLE --}}
                <div class="w-full lg:flex-1 min-w-0 lg:max-w-[880px]">

                    @if($article->image)
                        <figure class="mb-5 sm:mb-8 rounded-[16px] sm:rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-[0_8px_30px_-12px_rgba(15,23,42,0.25)]">
                            <img src="{{ asset('storage/' . $article->image) }}"
                                 alt="{{ $article->title }}"
                                 width="1200" height="800"
                                 fetchpriority="high" loading="eager" decoding="async"
                                 class="w-full h-auto block">
                        </figure>
                    @endif

                    {{-- Article body (existing content, presentation only) --}}
                    <section aria-label="Isi artikel" class="article-body">
                        <div class="max-w-[820px]">
                        @if($formattedContent['mode'] === 'html')
                            <div class="article-prose">
                                {!! $formattedContent['html'] !!}
                            </div>
                        @else
                            @php $stepsOpen = false; @endphp
                            @foreach($formattedContent['blocks'] as $i => $block)
                                @if($block['type'] === 'step' && ! $stepsOpen)
                                    @php $stepsOpen = true; @endphp
                                    <ol class="my-10 space-y-5 list-none p-0">
                                @elseif($block['type'] !== 'step' && $stepsOpen)
                                    @php $stepsOpen = false; @endphp
                                    </ol>
                                @endif

                                @if($block['type'] === 'paragraph')
                                    <p class="{{ $i === 0 ? 'text-[17px] sm:text-[19px] text-slate-800 font-medium' : 'text-[16px] sm:text-[18px] text-slate-800' }} leading-[1.7] sm:leading-[1.75] mb-4 sm:mb-6">{{ $block['text'] }}</p>

                                @elseif($block['type'] === 'heading')
                                    <h2 class="mt-10 mb-5 text-2xl sm:text-[1.7rem] font-extrabold text-slate-900 tracking-tight leading-snug pl-4 border-l-4 border-emerald-500">{{ $block['text'] }}</h2>

                                @elseif($block['type'] === 'step')
                                    <li class="relative bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 hover:border-blue-200 transition">
                                        <div class="flex items-start gap-4 sm:gap-5">
                                            <div class="shrink-0 flex flex-col items-center gap-2">
                                                <span class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-slate-900 text-white font-extrabold text-lg flex items-center justify-center" aria-hidden="true">{{ $block['number'] }}</span>
                                                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center" aria-hidden="true">
                                                    <i class="fa-solid {{ $block['icon'] }} text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h2 class="text-lg sm:text-xl font-bold text-slate-900 leading-snug mb-2">
                                                    <span class="sr-only">{{ $block['number'] }}. </span>{{ $block['title'] }}
                                                </h2>
                                                @foreach($block['paragraphs'] as $paragraph)
                                                    <p class="text-[17px] text-slate-700 leading-[1.8] {{ ! $loop->last ? 'mb-3' : '' }}">{{ $paragraph }}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            @if($stepsOpen)
                                </ol>
                            @endif
                        @endif
                        </div>
                    </section>

                    {{-- Article-specific action (existing data) --}}
                    @if($article->action_label && $article->action_url)
                        <div class="mt-6 sm:mt-8 p-5 sm:p-7 bg-blue-50/80 border border-blue-100 rounded-2xl w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <p class="text-lg font-bold text-slate-900">{{ $article->title ? 'Punya pertanyaan seputar informasi ini?' : '' }}</p>
                            <a href="{{ $article->action_url }}"
                               class="shrink-0 inline-flex items-center justify-center w-full sm:w-auto gap-2 min-h-[48px] px-6 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                                {{ $article->action_label }} <i class="fa-solid fa-arrow-right text-sm" aria-hidden="true"></i>
                            </a>
                        </div>
                    @else
                        {{-- Commercial bridge (existing) --}}
                        <div class="mt-6 sm:mt-8 p-5 sm:p-7 bg-white border border-slate-200 rounded-2xl w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-lg font-bold text-slate-900 mb-1">Lagi Cari Aki Berkualitas?</p>
                                <p class="text-slate-600 text-sm sm:text-base">Temukan pilihan aki terbaik untuk berbagai kebutuhan di katalog produk kami.</p>
                            </div>
                            <a href="{{ route('products.index') }}"
                               class="shrink-0 inline-flex items-center justify-center w-full sm:w-auto gap-2 min-h-[48px] px-6 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2 transition">
                                Lihat Katalog Produk <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- SIDEBAR --}}
                <aside class="w-full lg:w-[320px] lg:flex-none" aria-label="Informasi tambahan">
                    <div class="lg:sticky lg:top-28 space-y-6">

                        {{-- Module 1: Help CTA --}}
                        <section class="rounded-2xl bg-slate-900 text-white p-6 sm:p-7 border border-slate-800">
                            <div class="w-11 h-11 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center mb-4" aria-hidden="true">
                                <i class="fa-solid fa-headset text-lg"></i>
                            </div>
                            <h2 class="text-xl font-extrabold leading-snug mb-2">Butuh Bantuan Seputar Aki?</h2>
                            <p class="text-slate-300 leading-relaxed mb-5">Tim Lynvo Energi siap membantu Anda memilih aki yang tepat sesuai kendaraan.</p>

                            <div class="space-y-3 mb-6">
                                <a href="{{ $waConsultUrl }}" target="_blank" rel="noopener"
                                   class="flex items-center justify-center gap-2 w-full min-h-[48px] px-5 rounded-xl bg-emerald-600 hover:bg-emerald-500 font-bold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                                    <i class="fa-brands fa-whatsapp text-lg" aria-hidden="true"></i>
                                    Konsultasi via WhatsApp
                                </a>
                                <a href="{{ $phoneUrl }}"
                                   class="flex items-center justify-center gap-2 w-full min-h-[48px] px-5 rounded-xl border border-blue-400/50 text-blue-200 hover:bg-blue-600 hover:border-blue-600 hover:text-white font-bold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                                    <i class="fa-solid fa-phone text-sm" aria-hidden="true"></i>
                                    Telepon Teknisi
                                </a>
                            </div>

                            <ul class="space-y-2.5 text-sm text-slate-300 border-t border-slate-800 pt-5">
                                @foreach(['Respon cepat', 'Gratis cek dinamo & kelistrikan', 'Layanan antar & pasang', 'Tersedia untuk mobil, armada & genset'] as $benefit)
                                    <li class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-circle-check text-emerald-400 mt-0.5" aria-hidden="true"></i>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </section>

                        {{-- Module 2: Related articles --}}
                        @if($relatedArticles->count() > 0)
                            <section class="rounded-2xl bg-white border border-slate-200 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-extrabold text-slate-900">Artikel Terkait</h2>
                                    <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
                                </div>
                                <ul class="divide-y divide-slate-100">
                                    @foreach($relatedArticles as $related)
                                        @php $relatedDate = $related->published_at ?? $related->created_at; @endphp
                                        <li>
                                            <a href="{{ route('articles.show', $related->slug) }}"
                                               class="group flex gap-4 py-4 first:pt-0 last:pb-0 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                                <div class="shrink-0 w-24 h-20 rounded-lg overflow-hidden bg-slate-100 border border-slate-100">
                                                    @if($related->image)
                                                        <img src="{{ asset('storage/' . $related->image) }}"
                                                             alt="{{ $related->title }}"
                                                             width="192" height="160" loading="lazy" decoding="async"
                                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-400" aria-hidden="true">
                                                            <i class="fa-solid fa-car-battery text-xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    @if($related->category_name)
                                                        <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-600 mb-1">{{ $related->category_name }}</span>
                                                    @endif
                                                    <h3 class="text-[15px] font-bold text-slate-900 group-hover:text-blue-600 leading-snug line-clamp-2 transition">{{ $related->title }}</h3>
                                                    <time datetime="{{ $relatedDate->toDateString() }}" class="mt-1 block text-xs text-slate-500">{{ $relatedDate->format('d M Y') }}</time>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        {{-- Module 3: Categories (existing data only) --}}
                        @if($categories->count() > 0)
                            <section class="rounded-2xl bg-white border border-slate-200 p-5">
                                <h2 class="text-lg font-extrabold text-slate-900 mb-4">Kategori Artikel</h2>
                                <ul class="flex flex-wrap gap-2">
                                    @foreach($categories as $category)
                                        <li class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-semibold border {{ $category->category_name === $article->category_name ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-slate-50 border-slate-200 text-slate-700' }}">
                                            {{ $category->category_name }}
                                            <span class="text-xs font-bold text-slate-400">{{ $category->total }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</article>

{{-- ============ COMMERCIAL CTA ============ --}}
<section class="bg-slate-50/60 pb-6 pt-4 sm:pb-10 sm:pt-6" aria-labelledby="article-cta-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-[20px] sm:rounded-3xl bg-slate-950 border border-slate-800 p-5 sm:px-10 sm:py-10">
            <div aria-hidden="true" class="hidden lg:block pointer-events-none absolute -right-10 -bottom-16 text-slate-800/60">
                <i class="fa-solid fa-car-battery text-[14rem]"></i>
            </div>
            <div class="relative grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-center">
                <div class="lg:col-span-7">
                    <h2 id="article-cta-title" class="text-[26px] leading-[1.2] sm:text-4xl font-extrabold text-white tracking-tight">Aki Mobil Bermasalah?</h2>
                    <p class="mt-2 sm:mt-3 text-[15px] sm:text-lg text-slate-300">Teknisi Lynvo Energi siap membantu Anda.</p>
                    <div class="mt-5 sm:mt-7 flex flex-col sm:flex-row gap-3">
                        <a href="{{ $waTechnicianUrl }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 min-h-[48px] sm:min-h-[52px] px-5 sm:px-7 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
                            <i class="fa-brands fa-whatsapp text-lg" aria-hidden="true"></i>
                            Chat Teknisi
                        </a>
                        <a href="{{ route('quotation') }}"
                           class="inline-flex items-center justify-center gap-2 min-h-[48px] sm:min-h-[52px] px-5 sm:px-7 rounded-xl border border-blue-400/50 text-blue-100 hover:bg-blue-600 hover:border-blue-600 hover:text-white font-bold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
                            <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true"></i>
                            Minta RFQ B2B
                        </a>
                    </div>
                </div>
                <ul class="lg:col-span-5 grid grid-cols-2 gap-y-3 gap-x-2 sm:gap-3 mt-4 sm:mt-0 pt-4 sm:pt-0 border-t border-slate-800 sm:border-none">
                    @foreach([
                        ['fa-stopwatch', 'Respon Cepat'],
                        ['fa-wrench', 'Gratis Cek Dinamo'],
                        ['fa-truck-fast', 'Antar & Pasang'],
                        ['fa-recycle', 'Tukar Tambah'],
                    ] as [$icon, $label])
                        <li class="flex flex-row items-start sm:items-center gap-2 sm:gap-3 sm:min-h-0 sm:rounded-xl sm:bg-slate-900 sm:border sm:border-slate-800 sm:p-4">
                            <i class="fa-solid {{ $icon }} text-emerald-400 text-[14px] sm:text-base shrink-0 mt-0.5 sm:mt-0" aria-hidden="true"></i>
                            <span class="text-[12px] sm:text-sm font-medium sm:font-semibold text-slate-200 sm:text-white leading-tight">{{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection
