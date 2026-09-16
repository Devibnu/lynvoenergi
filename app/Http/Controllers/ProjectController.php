<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display listing of published project case studies.
     */
    public function index(Request $request): View
    {
        $projects = Project::where('is_published', true)->latest()->paginate(9);

        return view('pages.projects.index', [
            'projects' => $projects,
            'metaTitle' => 'Portofolio Proyek Pengadaan & Instalasi Baterai Industri | Lynvo Energi',
            'metaDescription' => 'Studi kasus pengadaan aki armada logistik, instalasi genset industri, penggantian baterai UPS data center, dan baterai alat berat oleh Lynvo Energi.',
        ]);
    }

    /**
     * Display detailed project case study.
     */
    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedProjects = Project::where('is_published', true)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('pages.projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'metaTitle' => "Studi Kasus: {$project->title} | Lynvo Energi",
            'metaDescription' => "Studi kasus proyek {$project->title} di {$project->location}.",
        ]);
    }
}
