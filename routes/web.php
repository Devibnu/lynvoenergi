<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalSeoController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitemapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Lynvo Energi
|--------------------------------------------------------------------------
*/

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [App\Http\Controllers\SeoController::class, 'robots'])->name('robots');

// Homepage & Service Hub
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan/antar-pasang-aki', [LocalSeoController::class, 'serviceHub'])->name('services.battery_delivery');

// Katalog & Detail Produk
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{category:slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/produk/{category:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Sektor Aplikasi Industri B2B
Route::get('/aplikasi', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/aplikasi/{application:slug}', [ApplicationController::class, 'show'])->name('applications.show');

// Merek / Brands
Route::get('/merek', [BrandController::class, 'index'])->name('brands.index');
Route::get('/merek/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

// Portofolio Proyek
Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/project/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

// Halaman Profil, Kontak & RFQ B2B
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/minta-penawaran', [PageController::class, 'quotation'])->name('quotation');
Route::post('/inquiry', [PageController::class, 'storeInquiry'])
    ->middleware('throttle:inquiry')
    ->name('inquiry.store');

// Artikel / Blog
Route::get('/artikel', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

// Local Landing SEO Route
Route::get('/{coverageArea:slug}', [LocalSeoController::class, 'showLocalLanding'])
    ->where('coverageArea', 'toko-aki-[a-z0-9\-]+')
    ->name('local.landing');


Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('applications', \App\Http\Controllers\Admin\ApplicationController::class);
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('company-locations', \App\Http\Controllers\Admin\CompanyLocationController::class);
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class)->only(['index', 'show', 'destroy']);
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/upload', [\App\Http\Controllers\Admin\SettingController::class, 'upload'])->name('settings.upload');
});