<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Display listing of all B2B industrial application sectors.
     */
    public function index(): View
    {
        $applications = Application::active()
            ->withCount(['products' => fn($q) => $q->active()])
            ->get();

        return view('pages.applications.index', [
            'applications' => $applications,
            'metaTitle' => 'Solusi Aki Sektor Industri, Alat Berat, Genset & Korporat B2B Banten | Lynvo Energi',
            'metaDescription' => 'Penyedia aki baterai terpercaya untuk sektor otomotif, armada logistik, alat berat pertambangan, genset pabrik, marine, dan data center di Banten.',
        ]);
    }

    /**
     * Display specific application sector landing page with related battery products.
     */
    public function show(string $slug): View
    {
        $application = Application::where('slug', $slug)
            ->active()
            ->with(['products' => function ($q) {
                $q->active()->with(['category']);
            }])
            ->firstOrFail();

        $otherApplications = Application::active()
            ->where('id', '!=', $application->id)
            ->get();

        return view('pages.applications.show', [
            'application' => $application,
            'otherApplications' => $otherApplications,
            'metaTitle' => "Aki & Baterai Sektor {$application->name} — Solusi Daya Heavy Duty B2B | Lynvo Energi",
            'metaDescription' => "{$application->hero_headline}. {$application->description} Suplai kontrak korporat dan teknisi siaga di Banten.",
        ]);
    }
}
