@extends('layouts.admin.app')

@section('content')
<div class="row">
    <!-- Card 1: Total Produk -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Produk</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalProducts }}
                  <span class="text-success text-sm font-weight-bolder">Produk</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-box text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Card 2: Produk Aktif -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Produk Aktif</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $activeProducts }}
                  <span class="text-success text-sm font-weight-bolder">Aktif</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-check-circle text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Total Proyek -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Proyek</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalProjects }}
                  <span class="text-success text-sm font-weight-bolder">Proyek</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-camera text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Proyek Tayang -->
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Proyek Tayang</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $publishedProjects }}
                  <span class="text-success text-sm font-weight-bolder">Tayang</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-globe text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Card 5: Total Pesan -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pesan</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalInquiries }}
                  <span class="text-success text-sm font-weight-bolder">Pesan</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-secondary shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-envelope text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Card 6: Pesan Baru -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pesan Baru</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $unreadInquiries }}
                  <span class="text-danger text-sm font-weight-bolder">Belum dibaca</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-bell text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 7: Total Artikel -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Artikel</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalArticles }}
                  <span class="text-success text-sm font-weight-bolder">Artikel</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-file-alt text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 8: Total Kategori -->
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Kategori Produk</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalCategories }}
                  <span class="text-success text-sm font-weight-bolder">Kategori</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-tags text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Card 9: Total Pelanggan/Customer -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pelanggan</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalCustomers }}
                  <span class="text-success text-sm font-weight-bolder">Customer</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-users text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Card 10: Total Merk -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Merk / Brand</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalBrands }}
                  <span class="text-success text-sm font-weight-bolder">Merk</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-star text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 11: Sektor Aplikasi -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Sektor Aplikasi</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalApplications }}
                  <span class="text-success text-sm font-weight-bolder">Sektor</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-industry text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 12: Area Layanan -->
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Area Layanan</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalCoverage }}
                  <span class="text-success text-sm font-weight-bolder">Area</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md d-flex align-items-center justify-content-center">
                <i class="fas fa-map-marker-alt text-lg opacity-10 text-white" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
