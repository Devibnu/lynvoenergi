<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hero_headline' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('applications', 'public');
        }
        
        Application::create($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Sektor Aplikasi berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $application = Application::findOrFail($id);
        return view('admin.applications.edit', compact('application'));
    }

    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hero_headline' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            if ($application->image) {
                Storage::disk('public')->delete($application->image);
            }
            $validated['image'] = $request->file('image')->store('applications', 'public');
        }
        
        $application->update($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Sektor Aplikasi berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        
        if ($application->image) {
            Storage::disk('public')->delete($application->image);
        }
        $application->delete();
        
        return redirect()->route('admin.applications.index')->with('success', 'Sektor Aplikasi berhasil dihapus!');
    }
}
