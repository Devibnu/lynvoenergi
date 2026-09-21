@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Produk: {{ $product->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Foto Produk (Abaikan jika tidak ingin mengubah)</label>
                                @if($product->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Merek (Brand) <span class="text-danger">*</span></label>

                                <select name="brand_id" class="form-control" required>
                                    <option value="">-- Pilih Merek --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required placeholder="Contoh: Aki Mobil NS40Z">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kompatibilitas</label>
                                <textarea name="compatibility" class="form-control" rows="3" placeholder="Contoh: Cocok untuk Avanza, Xenia...">{{ old('compatibility', $product->compatibility) }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Voltage (V)</label>
                                <input type="text" name="voltage" class="form-control" value="{{ old('voltage', $product->voltage) }}" placeholder="Contoh: 12V">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kapasitas (Ah)</label>
                                <input type="number" name="capacity_ah" class="form-control" value="{{ old('capacity_ah', $product->capacity_ah) }}" placeholder="Contoh: 35">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">CCA</label>
                                <input type="number" name="cca" class="form-control" value="{{ old('cca', $product->cca) }}" placeholder="Contoh: 320">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" placeholder="Contoh: 750000">
                            </div>

                            <div class="form-group mt-4">
                                <label class="form-control-label">Sektor Aplikasi (Opsional)</label>
                                <div class="row">
                                    @php
                                        $selectedApps = old('applications', $product->applications->pluck('id')->toArray());
                                    @endphp
                                    @foreach($applications as $app)
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="applications[]" value="{{ $app->id }}" id="app_{{ $app->id }}" {{ in_array($app->id, $selectedApps) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="app_{{ $app->id }}">
                                                    {{ $app->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_price_visible" id="is_price_visible" value="1" {{ old('is_price_visible', $product->is_price_visible) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_price_visible">Tampilkan Harga di Web</label>
                            </div>

                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="is_popular_retail" id="is_popular_retail" value="1" {{ old('is_popular_retail', $product->is_popular_retail) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_popular_retail">Produk Retail Populer</label>
                            </div>

                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Status Produk Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                            <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 ms-2">Update Produk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
