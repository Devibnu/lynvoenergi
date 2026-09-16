@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Proyek: {{ $project->title }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Foto Proyek (Abaikan jika tidak mengubah)</label>
                                @if($project->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Judul Proyek <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required placeholder="Contoh: Instalasi Solar Panel">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Nama Klien</label>
                                <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}" placeholder="Contoh: PT. ABC">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Lokasi</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $project->location) }}" placeholder="Contoh: Jakarta">
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $project->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Tampilkan di Website (Published)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Deskripsi Proyek</label>
                                <textarea name="description" id="editor" class="form-control">{{ old('description', $project->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                            <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 ms-2">Update Proyek</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });
</script>
@endpush
