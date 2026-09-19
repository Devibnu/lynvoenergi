@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan | Lynvo Energi')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan. Kembali ke Lynvo Energi untuk kebutuhan aki dan accu Anda.')

@section('content')
<main class="flex-1 flex items-center bg-slate-50 py-16 sm:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-blue-100 text-blue-600 mb-7">
            <i class="fa-solid fa-map-location-dot text-4xl"></i>
        </div>

        <p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-600 mb-3">Error 404</p>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900">
            Halaman tidak ditemukan
        </h1>
        <p class="mt-5 text-base sm:text-lg leading-8 text-slate-600 max-w-2xl mx-auto">
            Maaf, alamat yang Anda buka tidak tersedia atau mungkin sudah dipindahkan.
            Mari kembali dan temukan kebutuhan aki Anda.
        </p>

        <div class="mt-9 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/25 transition hover:-translate-y-0.5 hover:bg-blue-700">
                <i class="fa-solid fa-house"></i>
                Kembali ke Beranda
            </a>
            <a href="{{ route('services.battery_delivery') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700">
                <i class="fa-solid fa-truck-fast"></i>
                Layanan Antar Pasang
            </a>
        </div>

        <div class="mt-10 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm text-emerald-900">
            <i class="fa-brands fa-whatsapp text-emerald-600 mr-2"></i>
            Butuh bantuan cepat?
            <a href="{{ \App\Models\Setting::getWhatsappUrl('Halo Lynvo Energi, saya butuh bantuan') }}"
               target="_blank"
               rel="noopener"
               class="font-bold underline underline-offset-2 hover:text-emerald-700">
                Hubungi teknisi Lynvo Energi
            </a>
        </div>
    </div>
</main>
@endsection
