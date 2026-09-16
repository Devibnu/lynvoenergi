@extends('layouts.admin.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6>Data Produk</h6>
        <a href="{{ route('admin.products.create') }}" class="btn bg-gradient-dark btn-sm mb-0">Tambah Produk</a>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($products as $product)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x100/f8fafc/334155?text=No+Image' }}" class="avatar avatar-sm me-3" alt="{{ $product->name }}">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $product->brand ?? 'Tanpa Merek' }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $product->category?->name ?? '-' }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($product->is_active)
                    <span class="badge badge-sm bg-gradient-success">Aktif</span>
                  @else
                    <span class="badge badge-sm bg-gradient-secondary">Tidak Aktif</span>
                  @endif
                </td>
                <td class="align-middle text-center">
                  <a href="{{ route('admin.products.edit', $product->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit product">
                    Edit
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-sm text-secondary">Belum ada data produk.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer pb-0">
          {{ $products->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</div>
@endsection
