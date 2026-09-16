<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display listing of all battery brands.
     */
    public function index(): View
    {
        $brands = Brand::withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->get();

        return view('pages.brands.index', [
            'brands' => $brands,
            'metaTitle' => 'Distributor Resmi Merk Aki Terkemuka di Banten | Lynvo Energi',
            'metaDescription' => 'Pusat aki original GS Astra, Yuasa, Incoe, Amaron, Varta, Bosch, Panasonic, Delkor bergaransi resmi langsung pabrikan.',
        ]);
    }

    /**
     * Display brand profile and battery products.
     */
    public function show(string $slug): View
    {
        $brand = Brand::where('slug', $slug)
            ->with(['products' => function ($q) {
                $q->where('is_active', true)->with('category');
            }])
            ->firstOrFail();

        $otherBrands = Brand::where('id', '!=', $brand->id)->get();

        return view('pages.brands.show', [
            'brand' => $brand,
            'otherBrands' => $otherBrands,
            'metaTitle' => "Aki & Accu Merk {$brand->name} — Daftar Tipe, Harga & Garansi Resmi Banten | Lynvo Energi",
            'metaDescription' => "Distributor resmi aki {$brand->name} di Banten. {$brand->description} Siap antar pasang dan suplai skala besar.",
        ]);
    }
}
