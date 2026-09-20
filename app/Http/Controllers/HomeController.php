<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CoverageArea;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display corporate homepage with dual-engine B2B & Local Delivery.
     */
    public function index(): View
    {
        $categories = Category::withCount(['products' => fn($q) => $q->active()])
            ->active()
            ->orderBy('sort_order', 'asc')
            ->get();

        $applications = Application::active()
            ->take(6)
            ->get();

        $brands = Brand::orderBy('is_featured', 'desc')
            ->take(8)
            ->get();

        $popularProducts = Product::with('category')
            ->active()
            ->latest()
            ->take(6)
            ->get();

        $latestProjects = Project::where('is_published', true)
            ->latest('id')
            ->take(4)
            ->get();

        $coverageAreas = CoverageArea::active()
            ->orderBy('sort_order')
            ->get();

        $articles = Article::active()
            ->latest('published_at')
            ->take(3)
            ->get();

        $metaTitle = "Lynvo Energi — Distributor Aki B2B Nasional & Layanan Antar Pasang Cepat Banten";
        $metaDescription = "Pusat distribusi aki & baterai resmi GS Astra, Yuasa, Incoe, Amaron, Varta. Melayani pengadaan korporat B2B seluruh Indonesia dan layanan ganti aki darurat 24 jam se-Banten.";

        return view('pages.home', [
            'categories' => $categories,
            'applications' => $applications,
            'brands' => $brands,
            'popularProducts' => $popularProducts,
            'latestProjects' => $latestProjects,
            'coverageAreas' => $coverageAreas,
            'articles' => $articles,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
        ]);
    }

    /**
     * Redirect authenticated dashboard home.
     */
    public function home()
    {
        return redirect('dashboard');
    }
}
