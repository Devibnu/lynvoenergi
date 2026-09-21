<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display product catalog with dynamic filters and search.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with(['category', 'brand']);

        // Search query
        if ($search = trim($request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('compatibility', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($cat = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($cat) {
                if (is_array($cat)) {
                    $q->whereIn('slug', $cat);
                } else {
                    $q->where('slug', $cat);
                }
            });
        }

        // Filter by Brand
        if ($brand = $request->input('brand')) {
            $brandInput = (array) $brand;
            $resolvedBrands = Brand::whereIn('name', $brandInput)
                                   ->orWhereIn('slug', $brandInput)
                                   ->pluck('id');
                                   
            $query->where(function ($q) use ($resolvedBrands) {
                if ($resolvedBrands->isNotEmpty()) {
                    $q->whereIn('brand_id', $resolvedBrands);
                }
            });
        }

        // Filter by Capacity (Ah)
        if ($minAh = $request->input('min_ah')) {
            $query->where('capacity_ah', '>=', (int) $minAh);
        }
        if ($maxAh = $request->input('max_ah')) {
            $query->where('capacity_ah', '<=', (int) $maxAh);
        }

        // Sorting
        $sort = $request->input('sort', 'popular');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'capacity_desc' => $query->orderBy('capacity_ah', 'desc'),
            'newest' => $query->latest('id'),
            default => $query->latest('id'),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::withCount(['products' => fn($q) => $q->active()])->get();

        $brands = Brand::whereHas('products', fn($q) => $q->active())
            ->withCount(['products' => fn($q) => $q->active()])
            ->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'selectedCategory' => null,
            'metaTitle' => 'Katalog Lengkap Aki & Accu Mobil, Truk, Genset, Industri Banten | Lynvo Energi',
            'metaDescription' => 'Daftar harga & spesifikasi lengkap aki GS Astra, Yuasa, Incoe, Amaron, Varta, Bosch. Melayani eceran retail antar-pasang & suplai B2B korporat se-Banten.',
        ]);
    }

    /**
     * Display products filtered by specific category slug.
     */
    public function category(string $categorySlug, Request $request)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $query = Product::where('category_id', $category->id)->active()->with(['category', 'brand']);

        // Search within category
        if ($search = trim($request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('compatibility', 'like', "%{$search}%");
            });
        }

        // Filter by Brand
        if ($brand = $request->input('brand')) {
            $brandInput = (array) $brand;
            $resolvedBrands = Brand::whereIn('name', $brandInput)
                                   ->orWhereIn('slug', $brandInput)
                                   ->pluck('id');
                                   
            $query->where(function ($q) use ($resolvedBrands) {
                if ($resolvedBrands->isNotEmpty()) {
                    $q->whereIn('brand_id', $resolvedBrands);
                }
            });
        }

        // Sorting
        $sort = $request->input('sort', 'popular');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'capacity_desc' => $query->orderBy('capacity_ah', 'desc'),
            'newest' => $query->latest('id'),
            default => $query->latest('id'),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::withCount(['products' => fn($q) => $q->active()])->get();

        $brands = Brand::whereHas('products', fn($q) => $q->where('category_id', $category->id)->active())
            ->withCount(['products' => fn($q) => $q->where('category_id', $category->id)->active()])
            ->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'selectedCategory' => $category,
            'metaTitle' => "Jual {$category->name} Terlengkap & Bergaransi Resmi di Banten | Lynvo Energi",
            'metaDescription' => "Pilihan {$category->name} original berkualitas. Layanan antar pasang darurat cepat & pengadaan B2B.",
        ]);
    }

    /**
     * Display technical product detail page with related products and schema.
     */
    public function show(string $categorySlug, string $productSlug)
    {
        $product = Product::where('slug', $productSlug)
            ->active()
            ->with(['category', 'brand'])
            ->firstOrFail();

        // 4 Related Products
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id);
                if ($product->brand_id) {
                    $q->orWhere('brand_id', $product->brand_id);
                }
            })
            ->with(['category', 'brand'])
            ->take(4)
            ->get();
            
        $resolvedBrandName = $product->getRelationValue('brand')?->name;

        // JSON-LD Product Schema
        $schemaProduct = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => $product->image ? asset('storage/' . $product->image) : '',
            'description' => "Aki {$product->name} kapasitas {$product->capacity_ah} Ah {$product->voltage} bergaransi resmi.",
            'sku' => $product->slug,
            'mpn' => $product->slug,
            'brand' => [
                '@type' => 'Brand',
                'name' => $resolvedBrandName,
            ],
            'category' => $product->category?->name,
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => 'IDR',
                'price' => $product->price ?: '0',
                'priceValidUntil' => date('Y-12-31'),
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => 'https://schema.org/InStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'PT Lynvo Energi Prima',
                ],
            ],
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'Voltage', 'value' => $product->voltage],
                ['@type' => 'PropertyValue', 'name' => 'Capacity', 'value' => "{$product->capacity_ah} Ah"],
                ['@type' => 'PropertyValue', 'name' => 'Cold Cranking Amps (CCA)', 'value' => (string) ($product->cca ?? '-')],
            ],
        ];

        return view('pages.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'schemaProduct' => $schemaProduct,
            'metaTitle' => "Aki {$product->name} ({$product->capacity_ah} Ah) — Spesifikasi, Harga & Pasang di Tempat | Lynvo Energi",
            'metaDescription' => "Jual aki {$product->name} original {$product->voltage} {$product->capacity_ah}Ah CCA {$product->cca}. Siap antar & pasang se-Banten.",
        ]);
    }
}
