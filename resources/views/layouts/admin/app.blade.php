<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lynvo Energi Admin - Soft UI</title>
  @php $__favicon = \App\Models\Setting::getValue('site_favicon'); @endphp
  <link rel="icon" type="image/png" href="{{ $__favicon ? asset('storage/' . $__favicon) : 'https://demos.creative-tim.com/soft-ui-dashboard/assets/img/favicon.png' }}">
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <!-- Nucleo Icons & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
  <!-- Soft UI CSS -->
  <link id="pagestyle" href="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/css/soft-ui-dashboard.min.css" rel="stylesheet" />
  @stack('css')
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ url('/admin') }}">
        <span class="ms-1 font-weight-bold">Lynvo Energi Admin</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ url('/admin') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-chart-pie text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Data</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-box text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Produk</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-tags text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Kategori Produk</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}" href="{{ route('admin.applications.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-industry text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Sektor Aplikasi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-folder text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Proyek</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-newspaper text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Artikel & Edukasi</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Layanan Pelanggan</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-envelope text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Pesan Masuk</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pengaturan</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-cogs text-dark" style="font-size: 0.875rem;"></i>
            </div>
            <span class="nav-link-text ms-1">Pengaturan Website</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">

            <li class="nav-item d-flex align-items-center">
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="nav-link text-body font-weight-bold px-0 border-0 bg-transparent cursor-pointer">
                  <i class="fa fa-sign-out-alt me-sm-1"></i>
                  <span class="d-sm-inline d-none">Sign Out</span>
                </button>
              </form>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
                @if(isset($latestInquiries) && $latestInquiries->count() > 0)
                  <span class="position-absolute top-5 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                  </span>
                @endif
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                @if(isset($latestInquiries) && $latestInquiries->count() > 0)
                  @foreach($latestInquiries as $inq)
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" href="{{ route('admin.inquiries.show', $inq->id) }}">
                        <div class="d-flex py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              <span class="font-weight-bold">{{ Str::limit($inq->name, 15) }}</span>
                            </h6>
                            <p class="text-xs text-secondary mb-0">
                              <i class="fa fa-clock me-1"></i>
                              {{ $inq->created_at->diffForHumans() }}
                            </p>
                          </div>
                        </div>
                      </a>
                    </li>
                  @endforeach
                  <li>
                    <a class="dropdown-item border-radius-md text-center text-sm font-weight-bold" href="{{ route('admin.inquiries.index') }}">
                      Lihat Semua Pesan
                    </a>
                  </li>
                @else
                  <li class="mb-2">
                    <span class="dropdown-item border-radius-md text-center text-sm text-secondary">
                      Tidak ada pesan baru
                    </span>
                  </li>
                @endif
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      
      @yield('content')

      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://jasaibnu.com" class="font-weight-bold" target="_blank">jasa ibnu</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/js/core/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/js/core/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="https://cdn.jsdelivr.net/gh/creativetimofficial/soft-ui-dashboard@master/assets/js/soft-ui-dashboard.min.js"></script>
  @stack('js')
</body>
</html>
