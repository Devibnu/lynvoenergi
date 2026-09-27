<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');
        
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }
        
        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');
        
        if ($request->hasFile('logo')) {
            if ($brand->logo && !Str::startsWith($brand->logo, 'assets/')) {
                Storage::disk('public')->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }
        
        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')->withErrors(['error' => 'Merek tidak dapat dihapus karena masih digunakan oleh produk.']);
        }

        if ($brand->logo && !Str::startsWith($brand->logo, 'assets/')) {
            Storage::disk('public')->delete($brand->logo);
        }
        $brand->delete();
        
        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil dihapus!');
    }
}
