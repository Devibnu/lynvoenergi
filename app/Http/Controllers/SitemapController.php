<?php

namespace App\Http\Controllers;

use App\Models\Application;
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
        $coverageAreas = CoverageArea::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $products = Product::where('is_active', true)
            ->with('category')
            ->whereHas('category', function ($q) {
                $q->where('is_active', true);
            })
            ->latest('updated_at')
            ->get();

        $applications = Application::where('is_active', true)
            ->get();

        $brands = Brand::all();

        $projects = Project::where('is_published', true)
            ->latest('updated_at')
            ->get();

        return response()
            ->view('sitemap', compact(
                'coverageAreas',
                'categories',
                'products',
                'applications',
                'brands',
                'projects'
            ))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
