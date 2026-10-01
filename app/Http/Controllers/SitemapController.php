<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CoverageArea;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap conforming to sitemaps.org standard.
     */
    public function index(): Response
    {
        $coverageAreas = CoverageArea::active()
            ->orderBy('sort_order')
            ->cursor();

        $categories = Category::active()
            ->orderBy('sort_order')
            ->cursor();

        $products = Product::active()
            ->with('category')
            ->whereHas('category', function ($q) {
                $q->active();
            })
            ->latest('updated_at')
            ->cursor();

        $applications = Application::active()
            ->cursor();

        $brands = Brand::cursor();

        $projects = Project::where('is_published', true)
            ->latest('updated_at')
            ->cursor();

        $articles = Article::active()
            ->latest('updated_at')
            ->cursor();

        return response()
            ->view('sitemap', compact(
                'coverageAreas',
                'categories',
                'products',
                'applications',
                'brands',
                'projects',
                'articles'
            ))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
