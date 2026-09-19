<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyLocation;
use Illuminate\Http\Request;

class CompanyLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = CompanyLocation::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.company_locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.company_locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'business_hours' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_primary'] = $request->has('is_primary');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        CompanyLocation::create($validated);

        return redirect()->route('admin.company-locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = CompanyLocation::findOrFail($id);
        return view('admin.company_locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = CompanyLocation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'business_hours' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_primary'] = $request->has('is_primary');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        $location->update($validated);

        return redirect()->route('admin.company-locations.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = CompanyLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.company-locations.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
