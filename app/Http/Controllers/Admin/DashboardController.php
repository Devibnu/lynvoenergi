<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = \App\Models\Product::count();
        $activeProducts = \App\Models\Product::active()->count();
        $totalProjects = \App\Models\Project::count();
        $publishedProjects = \App\Models\Project::where('is_published', true)->count();

        $totalInquiries = \App\Models\Inquiry::count();
        $unreadInquiries = \App\Models\Inquiry::where('is_read', false)->count();
        $totalArticles = \App\Models\Article::count();
        $totalCategories = \App\Models\Category::count();

        $totalCustomers = \App\Models\Inquiry::distinct('phone')->count('phone');
        $totalBrands = \App\Models\Brand::count();
        $totalApplications = \App\Models\Application::count();
        $totalCoverage = \App\Models\CoverageArea::count();

        return view('admin.dashboard', compact(
            'totalProducts', 'activeProducts', 'totalProjects', 'publishedProjects',
            'totalInquiries', 'unreadInquiries', 'totalArticles', 'totalCategories',
            'totalCustomers', 'totalBrands', 'totalApplications', 'totalCoverage'
        ));
    }
}
