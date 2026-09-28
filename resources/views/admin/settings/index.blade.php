@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-white">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger text-white">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Logo Upload Section --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Logo Website</h6>
                    <p class="text-sm text-secondary mb-0">Upload logo perusahaan yang akan ditampilkan di header website publik.</p>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            @php
                                $currentLogo = \App\Models\Setting::getValue('site_logo');
                            @endphp
                            @if($currentLogo)
                                <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo Website" class="img-thumbnail shadow-sm" style="max-width: 150px; max-height: 120px;">
                                <p class="text-xs text-secondary mt-2 mb-0">Logo saat ini</p>
                            @else
                                <div class="border border-2 border-dashed rounded-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 120px; margin: 0 auto;">
                                    <div class="text-center">
                                        <i class="fa fa-image text-secondary opacity-5" style="font-size: 2rem;"></i>
                                        <p class="text-xs text-secondary mt-1 mb-0">Belum ada logo</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <label class="form-label text-sm font-weight-bold">Pilih File Logo</label>
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            <p class="text-xs text-secondary mt-1 mb-0">Format: JPG, PNG, SVG, WebP. Maks: 2MB. Rekomendasi: 200x60 px.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Favicon Upload Section --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Favicon Website</h6>
                    <p class="text-sm text-secondary mb-0">Upload ikon kecil yang muncul di tab browser. Rekomendasi: 32x32 atau 64x64 px.</p>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            @php
                                $currentFavicon = \App\Models\Setting::getValue('site_favicon');
                            @endphp
                            @if($currentFavicon)
                                <img src="{{ asset('storage/' . $currentFavicon) }}" alt="Favicon" class="img-thumbnail shadow-sm" style="width: 64px; height: 64px; object-fit: contain;">
                                <p class="text-xs text-secondary mt-2 mb-0">Favicon saat ini</p>
                            @else
                                <div class="border border-2 border-dashed rounded-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; margin: 0 auto;">
                                    <i class="fa fa-globe text-secondary opacity-5" style="font-size: 1.5rem;"></i>
                                </div>
                                <p class="text-xs text-secondary mt-2 mb-0">Belum ada favicon</p>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <label class="form-label text-sm font-weight-bold">Pilih File Favicon</label>
                            <input type="file" name="site_favicon" class="form-control" accept=".ico,.png,.svg,.jpg,.jpeg,.webp">
                            <p class="text-xs text-secondary mt-1 mb-0">Format: ICO, PNG, SVG. Maks: 512KB.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO Settings Section --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>SEO Website</h6>
                    <p class="text-sm text-secondary mb-0">Kelola pengaturan meta tag SEO, Open Graph, dan Twitter Card.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">SEO Title</label>
                            <input type="text" name="seo_title" class="form-control" value="{{ \App\Models\Setting::getValue('seo_title') }}" maxlength="70">
                            <p class="text-xs text-secondary mt-1 mb-0">Maks. 70 karakter.</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">SEO Keywords</label>
                            <input type="text" name="seo_keywords" class="form-control" value="{{ \App\Models\Setting::getValue('seo_keywords') }}" maxlength="255">
                            <p class="text-xs text-secondary mt-1 mb-0">Maks. 255 karakter.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-sm font-weight-bold">SEO Description</label>
                            <textarea name="seo_description" class="form-control" rows="3" maxlength="160">{{ \App\Models\Setting::getValue('seo_description') }}</textarea>
                            <p class="text-xs text-secondary mt-1 mb-0">Maks. 160 karakter.</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-sm font-weight-bold">SEO Author</label>
                            <input type="text" name="seo_author" class="form-control" value="{{ \App\Models\Setting::getValue('seo_author') }}">
                        </div>

                        <div class="col-12"><hr class="horizontal dark mt-2 mb-4"></div>
                        <h6 class="mb-3 text-sm">Open Graph (Facebook/LinkedIn)</h6>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">OG Title</label>
                            <input type="text" name="seo_og_title" class="form-control" value="{{ \App\Models\Setting::getValue('seo_og_title') }}" maxlength="70">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">OG Image</label>
                            <input type="file" name="seo_og_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                            @if(\App\Models\Setting::getValue('seo_og_image'))
                                <a href="{{ asset('storage/' . \App\Models\Setting::getValue('seo_og_image')) }}" target="_blank" class="text-xs text-info d-block mt-1">Lihat OG Image Saat Ini</a>
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-sm font-weight-bold">OG Description</label>
                            <textarea name="seo_og_description" class="form-control" rows="2" maxlength="160">{{ \App\Models\Setting::getValue('seo_og_description') }}</textarea>
                        </div>

                        <div class="col-12"><hr class="horizontal dark mt-2 mb-4"></div>
                        <h6 class="mb-3 text-sm">Twitter Card</h6>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Twitter Title</label>
                            <input type="text" name="seo_twitter_title" class="form-control" value="{{ \App\Models\Setting::getValue('seo_twitter_title') }}" maxlength="70">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold">Twitter Image</label>
                            <input type="file" name="seo_twitter_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                            @if(\App\Models\Setting::getValue('seo_twitter_image'))
                                <a href="{{ asset('storage/' . \App\Models\Setting::getValue('seo_twitter_image')) }}" target="_blank" class="text-xs text-info d-block mt-1">Lihat Twitter Image Saat Ini</a>
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-sm font-weight-bold">Twitter Description</label>
                            <textarea name="seo_twitter_description" class="form-control" rows="2" maxlength="160">{{ \App\Models\Setting::getValue('seo_twitter_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text-based Settings Section --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Pengaturan Umum</h6>
                    <p class="text-sm text-secondary mb-0">Kelola informasi kontak dan teks promo website.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @foreach($settings as $setting)
                            @if(!in_array($setting->key, ['site_logo', 'site_favicon', 'seo_title', 'seo_description', 'seo_keywords', 'seo_author', 'seo_og_title', 'seo_og_description', 'seo_og_image', 'seo_twitter_title', 'seo_twitter_description', 'seo_twitter_image']))
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-sm font-weight-bold">{{ $setting->label }}</label>
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" class="btn bg-gradient-info btn-lg mb-0">
                            <i class="fa fa-save me-1"></i> Simpan Semua Pengaturan & Gambar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
