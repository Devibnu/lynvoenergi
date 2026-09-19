@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Lokasi Perusahaan</h6>
                <a href="{{ route('admin.company-locations.create') }}" class="btn bg-gradient-info btn-sm mb-0">Tambah Lokasi</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Lokasi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipe</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kota</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Primary</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $location->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0 text-capitalize">{{ $location->type }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $location->city }}</p>
                                </td>
                                <td>
                                    @if($location->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($location->is_primary)
                                        <span class="badge badge-sm bg-gradient-primary">Primary</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <a href="{{ route('admin.company-locations.edit', $location->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" data-original-title="Edit location">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.company-locations.destroy', $location->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger font-weight-bold text-xs bg-transparent border-0 p-0" data-toggle="tooltip" data-original-title="Delete location">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-sm text-secondary">
                                    Belum ada data lokasi perusahaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
