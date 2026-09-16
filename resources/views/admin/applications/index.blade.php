@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Manajemen Sektor Aplikasi</h6>
                <a href="{{ route('admin.applications.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                    <i class="fas fa-plus me-2"></i> Tambah Aplikasi
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 text-white" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>Berhasil!</strong> {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                
                <div class="table-responsive p-0 mt-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sektor Aplikasi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Headline</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($app->image)
                                                <img src="{{ asset('storage/' . $app->image) }}" class="avatar avatar-sm me-3 bg-gray-100" alt="{{ $app->name }}">
                                            @else
                                                <div class="avatar avatar-sm me-3 bg-gradient-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-{{ $app->icon ?: 'industry' }} text-white text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $app->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">/aplikasi/{{ $app->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $app->hero_headline }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($app->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end pe-4">
                                    <a href="{{ route('admin.applications.edit', $app->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit application">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" class="d-inline ms-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent text-danger font-weight-bold text-xs p-0" onclick="return confirm('Apakah Anda yakin ingin menghapus sektor aplikasi ini?');">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-sm text-secondary">
                                    Belum ada data sektor aplikasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 pt-4">
                    {{ $applications->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
