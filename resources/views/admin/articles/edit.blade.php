@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Edit Artikel & Edukasi</h6>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-light mb-0">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="title">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="category_name">Label Kategori</label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name', $article->category_name) }}">
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
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
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
                                <input type="text" class="form-control @error('action_label') is-invalid @enderror" id="action_label" name="action_label" value="{{ old('action_label', $article->action_label) }}">
                                @error('action_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="action_url">URL Tautan (Action URL)</label>
                                <input type="text" class="form-control @error('action_url') is-invalid @enderror" id="action_url" name="action_url" value="{{ old('action_url', $article->action_url) }}">
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
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6">{{ old('content', $article->content) }}</textarea>
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
                                @if($article->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($article->image) }}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                    <small class="text-muted d-block mb-2">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch ps-0 mt-4">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $article->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="is_active">Status Aktif (Tampil di Publik)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-light m-0 me-2">Batal</a>
                        <button type="submit" class="btn btn-primary m-0">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
