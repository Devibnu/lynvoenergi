@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')

    <!-- HERO HEADER -->
    <section class="bg-gradient-to-b from-slate-900 to-slate-950 text-white py-16 border-b border-slate-800 text-center">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fa-solid fa-building text-blue-400"></i>
                Profil PT Lynvo Energi Prima
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4 max-w-3xl mx-auto">
                Dedikasi Menghadirkan Solusi Baterai & Daya Terbaik di Indonesia
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Menghubungkan keandalan produk pabrikan global terkemuka dengan layanan teknis profesional untuk kelancaran operasional transportasi dan industri.
            </p>
        </div>
    </section>

    <!-- COMPANY NARRATIVE & STATS -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-5 text-sm sm:text-base text-slate-700 leading-relaxed">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Tentang Kami
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight">
                        Mitra Strategis Kebutuhan Energi & Kelistrikan Anda
                    </h2>
                    <p>
                        <strong>PT Lynvo Energi Prima</strong> adalah perusahaan distributor resmi dan penyedia solusi baterai aki terintegrasi yang melayani dua pilar utama: <strong>Pengadaan Skala Korporat B2B</strong> di seluruh Indonesia serta <strong>Layanan Darurat Ganti Aki Antar-Pasang (Home Service)</strong> di wilayah Banten.
                    </p>
                    <p>
                        Dengan pengalaman bertahun-tahun dalam industri energi otomotif dan industrial power, kami dipercaya oleh ratusan perusahaan logistik, manufaktur pabrik, kontraktor alat berat, dan instansi pemerintah sebagai penyedia baterai berkualitas tinggi yang terjamin keasliannya.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <span class="text-2xl font-black text-blue-600 block">500+</span>
                            <span class="text-xs text-slate-600 font-semibold">Mitra Korporat B2B Aktif</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <span class="text-2xl font-black text-emerald-600 block">34 Prov</span>
                            <span class="text-xs text-slate-600 font-semibold">Jangkauan Pengiriman Nasional</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-gradient-to-tr from-slate-900 via-blue-950 to-slate-900 text-white rounded-3xl p-8 shadow-2xl border border-slate-800">
                        <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bullseye text-amber-400"></i>
                            Visi & Misi Kami
                        </h3>
                        <div class="space-y-4 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            <div>
                                <strong class="text-white block mb-1">Visi:</strong>
                                Menjadi distributor aki dan penyedia solusi energi baterai industri nomor satu di Indonesia yang paling andal, responsif, dan bernilai tambah bagi klien.
                            </div>
                            <div class="border-t border-slate-800 pt-3">
                                <strong class="text-white block mb-1">Misi:</strong>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li>Menyediakan hanya produk 100% original dan berstandar pabrikan resmi.</li>
                                    <li>Memberikan respon tercepat dan layanan emergency 24 jam berkualitas tinggi.</li>
                                    <li>Mendukung efisiensi biaya operasional mitra B2B melalui harga kompetitif dan program pemeliharaan preventif.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Nilai Layanan
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                    Kenapa Mempercayakan Kebutuhan Aki pada Lynvo Energi?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl mx-auto mb-4">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900 mb-2">100% Original & Segel</h4>
                    <p class="text-xs text-slate-600">Garansi resmi dari pabrikan langsung. Tidak ada barang rekondisi atau abal-abal.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl mx-auto mb-4">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900 mb-2">Respon Cepat & Siaga</h4>
                    <p class="text-xs text-slate-600">Teknisi siaga 24 jam siap meluncur dalam 30-60 menit ke titik lokasi darurat.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl mx-auto mb-4">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900 mb-2">Faktur Pajak & Legalitas</h4>
                    <p class="text-xs text-slate-600">Perusahaan berbadan hukum resmi PT dengan dokumen faktur pajak PPN lengkap.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl mx-auto mb-4">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900 mb-2">Kerjasama Tempo B2B</h4>
                    <p class="text-xs text-slate-600">Fasilitas sistem pembayaran termin PO untuk perusahaan mitra berkala.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
