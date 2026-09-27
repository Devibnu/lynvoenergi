@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Merek Baru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label">Nama Merek <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-control-label">Logo Merek</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-control-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Jadikan Merek Unggulan</label>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                        <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 ms-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
