@extends('layouts.admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Detail Pesan / Pertanyaan</h6>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-secondary mb-0">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Tipe / Kategori</label>
                        <p class="text-sm text-dark font-weight-bold mb-0">
                            @if($inquiry->type == 'general_contact')
                                Kontak Umum
                            @else
                                {{ ucwords(str_replace('_', ' ', $inquiry->type)) }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Tanggal Masuk</label>
                        <p class="text-sm text-dark font-weight-bold mb-0">{{ $inquiry->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                <hr class="horizontal dark mt-0 mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Nama Lengkap</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $inquiry->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Nama Perusahaan / Instansi</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $inquiry->company_name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">No. WhatsApp / Telepon</label>
                        <p class="text-sm font-weight-bold mb-0">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="text-info">
                                {{ $inquiry->phone }} <i class="fab fa-whatsapp ms-1"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Alamat Email</label>
                        <p class="text-sm font-weight-bold mb-0">
                            @if($inquiry->email)
                                <a href="mailto:{{ $inquiry->email }}" class="text-info">{{ $inquiry->email }}</a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Lokasi Proyek / Wilayah Operasi</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $inquiry->target_location ?? '-' }}</p>
                    </div>

                    @if($inquiry->category_id)
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Kategori Baterai</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $inquiry->category->name ?? '-' }}</p>
                    </div>
                    @endif

                    @if($inquiry->quantity)
                    <div class="col-md-6 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">Estimasi Jumlah</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $inquiry->quantity }}</p>
                    </div>
                    @endif

                    <div class="col-12 mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-secondary mb-0">URL Sumber Referensi</label>
                        <p class="text-sm font-weight-bold mb-0">
                            @if($inquiry->source_url)
                                <a href="{{ $inquiry->source_url }}" target="_blank" class="text-info">{{ $inquiry->source_url }} <i class="fas fa-external-link-alt ms-1 text-xs"></i></a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-gray-100 border-radius-md">
                    <label class="text-xs font-weight-bold text-uppercase text-secondary mb-2">Detail Pertanyaan / Kebutuhan</label>
                    <p class="text-sm mb-0 text-dark">
                        {!! nl2br(e($inquiry->message)) !!}
                    </p>
                </div>

                <div class="mt-4 text-end">
                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mb-0">Hapus Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
