@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white py-14 border-b border-slate-800 text-center">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-500/40 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4">
                <i class="fa-solid fa-industry text-blue-400"></i>
                B2B & Industrial Fleet Solutions
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mb-4 max-w-4xl mx-auto">
                Solusi Suplai Aki & Baterai Sektor Industri Banten
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-8">
                Mitra pengadaan baterai korporat terpercaya untuk pabrik manufaktur Cikande, industri baja/kimia Cilegon, armada logistik, kontraktor alat berat, dan generator standby.
            </p>

            <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20kami%20ingin%20konsultasi%20pengadaan%20aki%20B2B%20untuk%20perusahaan." 
               target="_blank"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-emerald-600/30 transition">
                <i class="fa-brands fa-whatsapp text-lg"></i>
                <span>Konsultasi Pengadaan Korporat B2B</span>
            </a>
        </div>
    </section>

    <!-- APPLICATIONS GRID -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($applications as $app)
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white flex items-center justify-center text-2xl shadow-md group-hover:scale-110 transition transform">
                                    <i class="fa-solid fa-{{ $app->icon ?: 'industry' }}"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                                    {{ $app->products_count }} Produk Ready
                                </span>
                            </div>

                            <h3 class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition mb-2">
                                {{ $app->name }}
                            </h3>

                            <h4 class="text-xs font-bold text-blue-600 mb-3">
                                {{ $app->hero_headline }}
                            </h4>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                                {{ $app->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('applications.show', $app->slug) }}" 
                               class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5 transition">
                                <span>Lihat Solusi & Produk</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                            <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20saya%20tertarik%20dengan%20solusi%20aki%20sektor%20{{ rawurlencode($app->name) }}." 
                               target="_blank" 
                               class="text-emerald-600 hover:text-emerald-700 text-xs font-bold flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp"></i>
                                Tanya WA
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- B2B FLEET PROCUREMENT CTA BANNER -->
            <div class="mt-16 bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-widest block mb-1">
                        Program Kerjasama Perusahaan
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-white">
                        Kontrak Suplai Aki Berkala & Sistem Tempo Perusahaan
                    </h3>
                    <p class="text-slate-300 text-sm mt-2 max-w-2xl leading-relaxed">
                        Dapatkan harga khusus distributor B2B (Corporate Tier), fasilitas garansi unit pengganti kilat, gratis pengecekan berkala armada, dan sistem invoice/PO tempo.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 whitespace-nowrap">
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi%2C%20kami%20ingin%20mengajukan%20kontrak%20pengadaan%20aki%20perusahaan." 
                       target="_blank"
                       class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm px-6 py-3.5 rounded-xl shadow transition">
                        <i class="fa-brands fa-whatsapp mr-1 text-base"></i> Hubungi Key Account Manager
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
