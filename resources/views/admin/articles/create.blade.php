@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Artikel & Edukasi Baru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="title">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="category_name">Label Kategori</label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name') }}" placeholder="Contoh: Tips Otomotif">
                                @error('category_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="excerpt">Ringkasan Singkat (Excerpt)</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="action_label">Label Tombol Tautan (Action Label)</label>
                                <input type="text" class="form-control @error('action_label') is-invalid @enderror" id="action_label" name="action_label" value="{{ old('action_label') }}" placeholder="Contoh: Konsultasi Pemilihan Aki">
                                @error('action_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="action_url">URL Tautan (Action URL)</label>
                                <input type="text" class="form-control @error('action_url') is-invalid @enderror" id="action_url" name="action_url" value="{{ old('action_url') }}" placeholder="Contoh: /layanan/antar-pasang-aki atau https://...">
                                @error('action_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="content">Isi Artikel Lengkap (Opsional)</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="image">Gambar / Thumbnail</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch ps-0 mt-4">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="is_active">Status Aktif (Tampil di Publik)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-light m-0 me-2">Batal</a>
                        <button type="submit" class="btn btn-primary m-0">Simpan Artikel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
