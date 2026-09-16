@extends('layouts.app')

@section('title', 'Permintaan Penawaran Harga (RFQ) Aki B2B & Industri | Lynvo Energi')
@section('meta_description', 'Ajukan formulir Request for Quotation (RFQ) pengadaan baterai industri, genset, alat berat, UPS, dan armada logistik di Banten & Jabodetabek. Dapatkan harga korporat dan faktur pajak resmi.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b15_1px,transparent_1px),linear-gradient(to_bottom,#1e293b15_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/20 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-4 border border-blue-500/30">
                <i class="fas fa-file-invoice-dollar"></i> Corporate B2B Procurement
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                Minta Penawaran Harga (RFQ)
            </h1>
            <p class="mt-4 text-slate-300 text-base sm:text-lg leading-relaxed">
                Dapatkan proposal penawaran harga resmi, ketersediaan stok volume besar, dan jadwal survei teknis untuk kebutuhan baterai industri perusahaan Anda.
            </p>
        </div>
    </div>
</section>

<!-- RFQ Form & Corporate Benefits -->
<section class="py-12 lg:py-16 bg-slate-50">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

        @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
                <div>
                    <h4 class="text-base font-bold text-emerald-900">Permintaan RFQ Berhasil Dikirim!</h4>
                    <p class="text-xs sm:text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
            @if(session('wa_direct_url'))
            <a href="{{ session('wa_direct_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md transition duration-200 shrink-0">
                <i class="fab fa-whatsapp text-base"></i> Hubungi Key Account Manager via WA
            </a>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Left: RFQ Form -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm border border-slate-200">
                    <div class="border-b border-slate-100 pb-6 mb-6">
                        <h2 class="text-2xl font-bold text-slate-900">Formulir Pengadaan Baterai / Aki</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Lengkapi rincian kebutuhan di bawah. Tim Key Account Manager (KAM) kami akan menyusun penawaran dalam format PDF resmi & faktur PPN.
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

                    <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="type" value="b2b_quotation">

                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider">1. Informasi Pemohon / Perusahaan</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama PIC / Kontak <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Hendra Wijaya" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                                <div>
                                    <label for="company_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Perusahaan / PT / CV <span class="text-rose-500">*</span></label>
                                    <input type="text" name="company_name" id="company_name" required value="{{ old('company_name') }}" placeholder="Contoh: PT Surya Logistik Banten" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / Telepon <span class="text-rose-500">*</span></label>
                                    <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Kantor / Perusahaan <span class="text-rose-500">*</span></label>
                                    <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="Contoh: procurement@suryalogistik.co.id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-4">
                            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider">2. Spesifikasi & Kebutuhan Pengadaan</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Baterai</label>
                                    <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="quantity" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estimasi Jumlah (Unit / Bank)</label>
                                    <input type="text" name="quantity" id="quantity" value="{{ old('quantity') }}" placeholder="Contoh: 20 Unit / 4 Bank" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                                <div>
                                    <label for="target_location" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi Pengiriman / Proyek</label>
                                    <input type="text" name="target_location" id="target_location" value="{{ old('target_location') }}" placeholder="Contoh: Kawasan Industri Cikande" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Rincian Tambahan & Spesifikasi Teknis <span class="text-rose-500">*</span></label>
                                <textarea name="message" id="message" rows="4" required placeholder="Sebutkan tipe/model aki yang dibutuhkan (misal: GS N200 200Ah, Yuasa NP65-12), merk yang diinginkan, jenis mesin/genset/alat berat, apakah butuh jasa instalasi on-site, target timeline penerimaan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500">
                                <i class="fas fa-lock text-emerald-600 mr-1"></i> Data perusahaan Anda dijamin aman & hanya digunakan untuk proses penawaran resmi.
                            </p>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md transition duration-200 shrink-0">
                                <i class="fas fa-paper-plane"></i> Ajukan Penawaran Resmi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Corporate Value Propositons -->
            <div class="lg:col-span-4 space-y-6">
                <!-- B2B Advantages Card -->
                <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-6 sm:p-8 shadow-md space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-white">Mengapa Memilih Lynvo Energi untuk B2B?</h3>
                        <p class="text-xs text-slate-300 mt-1">Keuntungan kemitraan pengadaan korporat jangka panjang:</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center shrink-0 text-sm">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Faktur Pajak & Legalitas Lengkap</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Badan usaha resmi dengan penerbitan e-Faktur PPN 11% untuk kepatuhan pembukuan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center shrink-0 text-sm">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Term of Payment (TOP) Fleksibel</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Tersedia skema pembayaran tempo (TOP 14 / 30 / 45 hari) untuk verified vendor agreement.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center shrink-0 text-sm">
                                <i class="fas fa-shield-halved"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Garansi Resmi Pabrik</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Jaminan 100% unit fresh date code baru langsung dari distributor resmi dengan garansi replacement.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center shrink-0 text-sm">
                                <i class="fas fa-toolbox"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Free Technical Site Survey</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Layanan inspeksi baterai genset & bank UPS ke lokasi pabrik Anda di wilayah Banten.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instant Assistance -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <h4 class="text-sm font-bold text-slate-900 mb-2">Butuh Respon Segera untuk Tender / Urgent?</h4>
                    <p class="text-xs text-slate-500 mb-4">
                        Hubungi Key Account Manager kami secara langsung melalui WhatsApp atau saluran telepon kantor.
                    </p>
                    <div class="space-y-2">
                        <a href="https://wa.me/{{ \App\Models\Setting::getValue('site_whatsapp') }}?text=Halo%20KAM%20Lynvo%20Energi,%20kami%20ingin%20mengajukan%20pengadaan%20baterai%20B2B%20urgent" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition">
                            <i class="fab fa-whatsapp text-sm"></i> WhatsApp KAM B2B
                        </a>
                        <a href="tel:0254889900" class="flex items-center justify-center gap-2 w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                            <i class="fas fa-phone-alt text-xs"></i> Telepon: (0254) 889-900
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
