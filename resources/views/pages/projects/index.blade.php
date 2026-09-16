@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white py-14 border-b border-slate-800 text-center">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fa-solid fa-briefcase text-blue-400"></i>
                Track Record & Project Portfolio
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                Portofolio Proyek & Pengadaan Baterai Industri
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Studi kasus implementasi, instalasi baterai standby, dan suplai berkala armada logistik, pabrik manufaktur, dan pertambangan oleh Lynvo Energi.
            </p>
        </div>
    </section>

    <!-- CATEGORY FILTER & PROJECTS GRID -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <!-- Filter Pills -->

            <!-- Projects Grid -->
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                            <!-- Project Image Placeholder -->
                            <div class="w-full h-56 overflow-hidden bg-slate-100 border-b border-slate-100">
                                <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://placehold.co/600x400/f8fafc/334155?text=Dokumentasi+Proyek' }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 rounded-t-xl">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                                    <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 font-bold">
                                        Proyek Pilihan
                                    </span>
                                </div>

                                <a href="{{ route('projects.show', $project->slug) }}" class="block">
                                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition mb-3 leading-snug">
                                        {{ $project->title }}
                                    </h3>
                                </a>

                                <p class="text-xs text-slate-600 line-clamp-3 mb-5 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($project->description), 120) }}
                                </p>

                                <div class="space-y-1.5 text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-slate-400 w-4"></i>
                                        <strong class="text-slate-700">{{ $project->client_name ?? 'Confidential' }}</strong>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-rose-500 w-4"></i>
                                        <span>{{ $project->location ?? 'Banten' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 pt-0 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                                <a href="{{ route('projects.show', $project->slug) }}" 
                                   class="text-xs font-bold text-blue-600 hover:underline pt-3 flex items-center gap-1">
                                    <span>Lihat Studi Kasus</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <p class="text-sm text-slate-500">Tidak ada proyek dalam kategori ini.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
