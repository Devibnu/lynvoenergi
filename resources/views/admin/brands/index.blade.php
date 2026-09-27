@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger text-white">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Merek (Brand)</h6>
                <a href="{{ route('admin.brands.create') }}" class="btn bg-gradient-info btn-sm mb-0">Tambah Merek</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Merek</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Slug</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Produk</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        @if($brand->logo)
                                            <div>
                                                <img src="{{ Str::startsWith($brand->logo, 'assets/') ? asset($brand->logo) : asset('storage/' . $brand->logo) }}" class="avatar avatar-sm me-3" alt="{{ $brand->name }}">
                                            </div>
                                        @endif
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $brand->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $brand->slug }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $brand->products()->count() }} Produk</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" data-original-title="Edit merek">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus merek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger font-weight-bold text-xs bg-transparent border-0 p-0" data-toggle="tooltip" data-original-title="Delete merek">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-sm text-secondary">
                                    Belum ada data merek.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">
                {{ $brands->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
