@extends('layouts.app')

@section('title', 'Hubungi Kami - Konsultasi & Layanan Darurat Aki Banten | Lynvo Energi')
@section('meta_description', 'Hubungi tim technical support dan hotline darurat Lynvo Energi untuk pengadaan baterai industri, genset, alat berat, armada logistik, serta layanan antar pasang aki se-Banten.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b15_1px,transparent_1px),linear-gradient(to_bottom,#1e293b15_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/20 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fas fa-headset"></i> Respon Cepat & Siaga Banten
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                Hubungi Lynvo Energi
            </h1>
            <p class="mt-4 text-slate-300 text-base sm:text-lg leading-relaxed">
                Punya pertanyaan seputar spesifikasi teknis baterai, butuh penawaran B2B, atau memerlukan layanan ganti aki darurat di wilayah Banten? Tim kami siap membantu Anda.
            </p>
        </div>
    </div>
</section>

<!-- Content & Contact Grid -->
<section class="py-12 lg:py-16 bg-slate-50">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        
        @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-check text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-emerald-900">Pesan Berhasil Terkirim!</h4>
                    <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
            @if(session('wa_direct_url'))
            <a href="{{ session('wa_direct_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition duration-200 shrink-0">
                <i class="fab fa-whatsapp text-sm"></i> Teruskan via WhatsApp Sales
            </a>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Left: Contact Details & Service Hours -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Direct Channels -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                    <h2 class="text-xl font-bold text-slate-900">Saluran Komunikasi Langsung</h2>
                    
                    <div class="space-y-4">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20Lynvo%20Energi,%20saya%20ingin%20konsultasi%20baterai/aki" target="_blank" rel="noopener noreferrer" class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 hover:border-emerald-300 hover:bg-emerald-50/50 transition duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center shrink-0 transition duration-200">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-slate-500">WhatsApp Hotline & CS</div>
                                <div class="text-base font-bold text-slate-900 group-hover:text-emerald-600">0812-3456-7890</div>
                                <p class="text-xs text-slate-500 mt-0.5">Respon cepat via chat untuk konsultasi & order darurat</p>
                            </div>
                        </a>

                        <a href="tel:0254889900" class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50/50 transition duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center shrink-0 transition duration-200">
                                <i class="fas fa-phone-alt text-lg"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-slate-500">Telepon Kantor (B2B Procurement)</div>
                                <div class="text-base font-bold text-slate-900 group-hover:text-blue-600">(0254) 889-900</div>
                                <p class="text-xs text-slate-500 mt-0.5">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                            </div>
                        </a>

                        <a href="mailto:{{ \App\Models\Setting::getValue('site_email') }}" class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center shrink-0 transition duration-200">
                                <i class="fas fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-slate-500">Email Korespondensi Resmi</div>
                                <div class="text-base font-bold text-slate-900 group-hover:text-indigo-600">{{ \App\Models\Setting::getValue('site_email') }}</div>
                                <p class="text-xs text-slate-500 mt-0.5">Pengiriman dokumen tender, PO, & RFQ resmi</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Office & Hub Location -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-4">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-rose-500"></i> Kantor Pusat & Hub Distribusi Banten
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        <strong>PT Lynvo Energi Nusantara</strong><br>
                        Kawasan Industri & Komersial Banten, Jl. Raya Serang - Cilegon KM 8, Serang, Banten 42162, Indonesia.
                    </p>
                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                        <span><i class="fas fa-truck-fast text-blue-600 mr-1"></i> Hub Antar Pasang:</span>
                        <span class="font-semibold text-slate-700">Serang, Cilegon, Tangerang</span>
                    </div>
                </div>

                <!-- Emergency Banner -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-2xl p-6 shadow-md">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-bolt text-2xl"></i>
                        <h4 class="font-black text-lg">Layanan Darurat Aki Mogok</h4>
                    </div>
                    <p class="text-xs text-amber-50 leading-relaxed mb-4">
                        Kendaraan, genset, atau alat berat Anda mati total di jalan/lokasi proyek? Teknisi kami siap meluncur dengan aki baru dan tester profesional.
                    </p>
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=DARURAT:%20Aki%20Mogok%20butuh%20ganti%20segera%20di%20wilayah%20Banten" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-white text-orange-600 hover:bg-orange-50 text-xs font-bold rounded-xl transition duration-200 shadow-sm">
                        Panggil Tim Darurat Sekarang
                    </a>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm border border-slate-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-slate-900">Kirim Pesan / Pertanyaan</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Isi formulir di bawah ini dan konsultan kami akan menghubungi Anda dalam waktu maksimal 1x24 jam kerja.
                        </p>
                    </div>

                    @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="type" value="general_contact">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                            <div>
                                <label for="company_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Perusahaan / Instansi</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="Contoh: PT Surya Logistik Banten" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp / Telepon <span class="text-rose-500">*</span></label>
                                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Contoh: budi@perusahaan.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                        </div>

                        <div>
                            <label for="target_location" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Proyek / Wilayah Operasi</label>
                            <input type="text" name="target_location" id="target_location" value="{{ old('target_location') }}" placeholder="Contoh: Cilegon, Kawasan Industri Modern Cikande, BSD" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Detail Pertanyaan / Kebutuhan <span class="text-rose-500">*</span></label>
                            <textarea name="message" id="message" rows="4" required placeholder="Tuliskan spesifikasi aki yang dicari, jenis kendaraan/mesin, kendala teknis, atau pertanyaan lainnya..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md transition duration-200">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
