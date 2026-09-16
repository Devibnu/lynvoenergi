@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Kategori Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="form-control-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Aki Mobil" value="{{ old('name') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-control-label">Foto / Ikon Kategori (Opsional)</label>
                        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp,image/jpg">
                        <small class="text-muted text-xs">Format: JPG, PNG, WEBP. Maks: 2MB. Rekomendasi rasio 4:3.</small>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-control-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat mengenai kategori produk ini">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="text-end mt-4">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                        <button type="submit" class="btn bg-gradient-info btn-sm mb-0 ms-2">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
