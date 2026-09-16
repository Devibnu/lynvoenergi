@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Proyek Baru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Foto Proyek</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Judul Proyek <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="Contoh: Instalasi Solar Panel">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Nama Klien</label>
                                <input type="text" name="client_name" class="form-control" placeholder="Contoh: PT. ABC">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Lokasi</label>
                                <input type="text" name="location" class="form-control" placeholder="Contoh: Jakarta">
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                                <label class="form-check-label" for="is_published">Tampilkan di Website (Published)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Deskripsi Proyek</label>
                                <textarea name="description" id="editor" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm mb-0">Batal</a>
                            <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 ms-2">Simpan Proyek</button>
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
