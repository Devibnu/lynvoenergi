<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display Company Profile (Tentang Kami).
     */
    public function about(): View
    {
        return view('pages.about', [
            'metaTitle' => 'Tentang PT Lynvo Energi Prima — Distributor & Solusi Daya Terpercaya',
            'metaDescription' => 'Profil perusahaan PT Lynvo Energi Prima, distributor resmi aki dan baterai industri nasional dengan standar mutu tinggi dan jangkauan suplai 34 provinsi.',
        ]);
    }

    /**
     * Display Contact Page (Kontak & Hotline).
     */
    public function contact(): View
    {
        return view('pages.contact', [
            'metaTitle' => 'Hubungi Kami — Hotline 24 Jam, Alamat & Layanan Pelanggan | Lynvo Energi',
            'metaDescription' => 'Hubungi customer service dan tim sales korporat Lynvo Energi. Siap melayani konsultasi teknis, pengadaan aki, dan bantuan darurat se-Banten.',
        ]);
    }

    /**
     * Display Request for Quotation (RFQ) Page for B2B.
     */
    public function quotation(): View
    {
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('pages.quotation', [
            'categories' => $categories,
            'metaTitle' => 'Minta Penawaran Harga (RFQ) Aki B2B & Proyek Korporat | Lynvo Energi',
            'metaDescription' => 'Formulir resmi permintaan surat penawaran harga (SPH/RFQ) pengadaan aki partai besar, genset, alat berat, dan fleet kendaraan dengan harga tier distributor.',
        ]);
    }

    /**
     * Handle submission of inquiry / quotation forms.
     */
    public function storeInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:b2b_quotation,retail_order,general_contact',
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'target_location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
            'source_url' => 'nullable|string|max:500',
        ]);

        $inquiry = Inquiry::create($validated);

        // Generate pre-filled WhatsApp text for direct sales forward
        $typeLabel = match ($inquiry->type) {
            'b2b_quotation' => 'Permintaan Penawaran Harga B2B (RFQ)',
            'retail_order' => 'Pemesanan Ganti Aki Retail / Home Service',
            default => 'Pesan Kontak Umum',
        };

        $categoryName = '';
        if ($inquiry->category_id) {
            $categoryName = Category::find($inquiry->category_id)->name ?? '';
        }

        $waText = "Halo Tim Sales Lynvo Energi, saya telah mengirimkan *{$typeLabel}* melalui website:\n\n"
            . "• Nama: {$inquiry->name}\n"
            . ($inquiry->company_name ? "• Perusahaan: {$inquiry->company_name}\n" : "")
            . "• No. HP/WA: {$inquiry->phone}\n"
            . ($inquiry->email ? "• Email: {$inquiry->email}\n" : "")
            . ($inquiry->target_location ? "• Lokasi Proyek: {$inquiry->target_location}\n" : "")
            . ($categoryName ? "• Kategori Baterai: {$categoryName}\n" : "")
            . ($inquiry->quantity ? "• Jumlah (Unit/Bank): {$inquiry->quantity}\n" : "")
            . "• Rincian Kebutuhan:\n{$inquiry->message}\n\n"
            . "Mohon segera ditindaklanjuti. Terima kasih!";

        $waUrl = \App\Models\Setting::getWhatsappUrl($waText);

        return redirect()->back()->with([
            'success' => 'Permintaan Anda berhasil kami terima! Tim Sales/Technical Lynvo Energi akan segera menghubungi Anda.',
            'wa_direct_url' => $waUrl,
        ]);
    }
}
