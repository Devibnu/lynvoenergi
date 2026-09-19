<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = \App\Models\Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->title);

        if (\App\Models\Project::where('slug', $slug)->exists()) {
            return back()->withInput()->withErrors(['title' => 'Slug/judul proyek sudah digunakan. Silakan gunakan judul proyek yang berbeda.']);
        }

        $validated['slug'] = $slug;
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        try {
            \App\Models\Project::create($validated);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            if ($request->hasFile('image') && isset($validated['image'])) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($validated['image']);
            }
            return back()->withInput()->withErrors(['title' => 'Slug/judul proyek sudah digunakan. Silakan gunakan judul proyek yang berbeda.']);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $project = \App\Models\Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, string $id)
    {
        $project = \App\Models\Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->title);

        if (\App\Models\Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
            return back()->withInput()->withErrors(['title' => 'Slug/judul proyek sudah digunakan. Silakan gunakan judul proyek yang berbeda.']);
        }

        $validated['slug'] = $slug;
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($project->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        try {
            $project->update($validated);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['title' => 'Slug/judul proyek sudah digunakan. Silakan gunakan judul proyek yang berbeda.']);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $project = \App\Models\Project::findOrFail($id);
        if ($project->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image);
        }
        $project->delete();
        
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus!');
    }
}
