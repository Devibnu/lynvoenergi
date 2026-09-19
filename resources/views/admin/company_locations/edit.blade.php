@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Lokasi Perusahaan: {{ $location->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.company-locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama Lokasi <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-control-label">Tipe Lokasi <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
                                    <option value="headquarters" {{ old('type', $location->type) == 'headquarters' ? 'selected' : '' }}>Kantor Pusat</option>
                                    <option value="branch" {{ old('type', $location->type) == 'branch' ? 'selected' : '' }}>Cabang</option>
                                    <option value="warehouse" {{ old('type', $location->type) == 'warehouse' ? 'selected' : '' }}>Gudang</option>
                                    <option value="workshop" {{ old('type', $location->type) == 'workshop' ? 'selected' : '' }}>Workshop / Bengkel</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-control-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3" required>{{ old('address', $location->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city" class="form-control-label">Kota <span class="text-danger">*</span></label>
                                <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" id="city" value="{{ old('city', $location->city) }}" required>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="province" class="form-control-label">Provinsi</label>
                                <input class="form-control @error('province') is-invalid @enderror" type="text" name="province" id="province" value="{{ old('province', $location->province) }}">
                                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="postal_code" class="form-control-label">Kode Pos</label>
                                <input class="form-control @error('postal_code') is-invalid @enderror" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $location->postal_code) }}">
                                @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-control-label">Nomor Telepon (Opsional)</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{ old('phone', $location->phone) }}" placeholder="Kosongkan untuk pakai nomor utama">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="whatsapp" class="form-control-label">Nomor WhatsApp (Opsional)</label>
                                <input class="form-control @error('whatsapp') is-invalid @enderror" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $location->whatsapp) }}" placeholder="Kosongkan untuk pakai WA utama">
                                @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="google_maps_url" class="form-control-label">URL Google Maps (Embed atau Link)</label>
                        <input class="form-control @error('google_maps_url') is-invalid @enderror" type="url" name="google_maps_url" id="google_maps_url" value="{{ old('google_maps_url', $location->google_maps_url) }}">
                        @error('google_maps_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="business_hours" class="form-control-label">Jam Operasional (Opsional)</label>
                        <input class="form-control @error('business_hours') is-invalid @enderror" type="text" name="business_hours" id="business_hours" value="{{ old('business_hours', $location->business_hours) }}" placeholder="Senin - Jumat, 08:00 - 17:00">
                        @error('business_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif (Tampilkan di website)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1" {{ old('is_primary', $location->is_primary) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_primary">Jadikan Primary (Muncul di Footer)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort_order" class="form-control-label">Urutan (Sort Order)</label>
                                <input class="form-control @error('sort_order') is-invalid @enderror" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $location->sort_order) }}">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.company-locations.index') }}" class="btn btn-light m-0 me-2">Batal</a>
                        <button type="submit" class="btn bg-gradient-primary m-0">Update Lokasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
