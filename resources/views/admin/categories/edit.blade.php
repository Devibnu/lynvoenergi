@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Kategori Produk</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label class="form-control-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Aki Mobil" value="{{ old('name', $category->name) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-control-label">Foto / Ikon Kategori (Opsional)</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp,image/jpg">
                        <small class="text-muted text-xs">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-control-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat mengenai kategori produk ini">{{ old('description', $category->description) }}</textarea>
                    </div>
                    
                    <div class="text-end mt-4">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                        <button type="submit" class="btn bg-gradient-info btn-sm mb-0 ms-2">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
