@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- BREADCRUMB & HEADER -->
    <div class="bg-slate-900 text-white py-4 border-b border-slate-800">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <nav class="flex items-center gap-2 text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <a href="{{ route('projects.index') }}" class="hover:text-white transition">Portofolio Proyek</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-600"></i>
                <span class="text-blue-400 font-bold truncate max-w-xs sm:max-w-md">{{ $project->title }}</span>
            </nav>
        </div>
    </div>

    <!-- MAIN PROJECT CASE STUDY CONTENT -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left: Main Case Study Narrative -->
                <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm">
                    <!-- Tags Removed -->

                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight mb-6">
                        {{ $project->title }}
                    </h1>

                    <!-- Hero Image -->
                    <div class="w-full mb-8 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://placehold.co/800x500/f8fafc/334155?text=Dokumentasi+Proyek' }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-auto object-cover">
                    </div>

                    <!-- Key Project Metadata Box -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200/80 mb-8 text-xs sm:text-sm">
                        @if($project->client_name)
                            <div>
                                <span class="text-slate-400 block font-medium">Klien / Perusahaan:</span>
                                <strong class="text-slate-900 font-bold text-sm sm:text-base">{{ $project->client_name }}</strong>
                            </div>
                        @endif
                        @if($project->location)
                            <div>
                                <span class="text-slate-400 block font-medium">Lokasi Proyek:</span>
                                <strong class="text-slate-900 font-bold text-sm sm:text-base">{{ $project->location }}</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Detailed Case Study Narrative -->
                    <div class="prose max-w-none text-slate-600">
                        {!! $project->description !!}
                    </div>

                    <div class="mt-8">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi,%20saya%20tertarik%20dengan%20proyek%20{{ urlencode($project->title) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow-lg shadow-emerald-600/30">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            Tanya Seputar Proyek Ini
                        </a>
                    </div>

                    <!-- Call to action inside project -->
                    <div class="mt-10 p-6 bg-gradient-to-r from-blue-50 to-slate-100 rounded-2xl border border-blue-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Punya Kebutuhan Serupa untuk Perusahaan Anda?</h4>
                            <p class="text-xs text-slate-600">Konsultasikan kebutuhan baterai armada & fasilitas industri Anda bersama kami.</p>
                        </div>
                        <a href="{{ route('quotation') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl whitespace-nowrap transition shadow">
                            Minta Penawaran B2B
                        </a>
                    </div>
                </div>

                <!-- Right Sidebar: Quick Contact & Other Projects -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-slate-900 text-white rounded-3xl p-6 shadow-xl border border-slate-800 text-center">
                        <i class="fa-solid fa-headset text-3xl text-blue-400 mb-3 block"></i>
                        <h3 class="font-bold text-base text-white mb-2">Konsultasi Proyek B2B</h3>
                        <p class="text-xs text-slate-400 mb-6">
                            Tim teknis kami siap datang ke pabrik / kantor Anda untuk survei kebutuhan baterai.
                        </p>
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20kami%20ingin%20konsultasi%20mengenai%20proyek%20pengadaan%20aki." 
                           target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs py-3 rounded-xl transition">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Chat Tim Engineering (WA)</span>
                        </a>
                    </div>

                    <!-- Related Projects -->
                    @if($relatedProjects->count() > 0)
                        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                            <h4 class="font-bold text-slate-900 text-sm mb-4">Studi Kasus Lainnya:</h4>
                            <div class="space-y-4">
                                @foreach($relatedProjects as $rel)
                                    <div class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                        <a href="{{ route('projects.show', $rel->slug) }}" class="text-xs font-bold text-slate-800 hover:text-blue-600 transition line-clamp-2 mt-0.5">
                                            {{ $rel->title }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
