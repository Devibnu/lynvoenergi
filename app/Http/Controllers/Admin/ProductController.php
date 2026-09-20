<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = \App\Models\Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $applications = \App\Models\Application::active()->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'applications', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'voltage' => 'nullable|string|max:255',
            'capacity_ah' => 'nullable|integer',
            'cca' => 'nullable|integer',
            'compatibility' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'applications' => 'nullable|array',
            'applications.*' => 'exists:applications,id',
        ]);

        $brand = Brand::findOrFail($validated['brand_id']);
        $validated['brand'] = $brand->name;

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_price_visible'] = $request->has('is_price_visible');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_popular_retail'] = $request->has('is_popular_retail');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Extract applications array so it doesn't try to save it to products table
        $applications = $request->input('applications', []);
        unset($validated['applications']);

        $product = \App\Models\Product::create($validated);
        $product->applications()->sync($applications);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        $applications = \App\Models\Application::active()->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'applications', 'brands'));
    }

    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'voltage' => 'nullable|string|max:255',
            'capacity_ah' => 'nullable|integer',
            'cca' => 'nullable|integer',
            'compatibility' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'applications' => 'nullable|array',
            'applications.*' => 'exists:applications,id',
        ]);

        $brand = Brand::findOrFail($validated['brand_id']);
        $validated['brand'] = $brand->name;

        // Auto-slug update (or keep old if preferred, here we'll update it based on name)
        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_price_visible'] = $request->has('is_price_visible');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_popular_retail'] = $request->has('is_popular_retail');

        if ($request->hasFile('image')) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        $applications = $request->input('applications', []);
        unset($validated['applications']);

        $product->update($validated);
        $product->applications()->sync($applications);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
