@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h6>Edit Sektor Aplikasi</h6>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="name" class="form-control-label">Nama Aplikasi <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $application->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="is_active" class="form-control-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active', $application->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $application->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="hero_headline" class="form-control-label">Headline (Hero) <span class="text-danger">*</span></label>
                        <input class="form-control @error('hero_headline') is-invalid @enderror" type="text" id="hero_headline" name="hero_headline" value="{{ old('hero_headline', $application->hero_headline) }}" required>
                        @error('hero_headline')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-control-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $application->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="icon" class="form-control-label">FontAwesome Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                    <input class="form-control @error('icon') is-invalid @enderror" type="text" id="icon" name="icon" value="{{ old('icon', $application->icon) }}">
                                </div>
                                <small class="form-text text-muted">Hanya nama icon tanpa awalan fa-, contoh: <code>industry</code>, <code>truck</code>.</small>
                                @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image" class="form-control-label">Upload Gambar / Banner (Opsional)</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            @if($application->image)
                                <div class="mt-2">
                                    <p class="text-xs mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $application->image) }}" class="img-thumbnail rounded" style="max-height: 120px;" alt="Banner">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn bg-gradient-primary m-0">
                            <i class="fas fa-save me-1"></i> Perbarui Aplikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
