@extends('layouts.admin.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6>Data Proyek</h6>
        <a href="{{ route('admin.projects.create') }}" class="btn bg-gradient-dark btn-sm mb-0">Tambah Proyek</a>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proyek</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Klien & Lokasi</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($projects as $project)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://placehold.co/100x100/f8fafc/334155?text=No+Image' }}" class="avatar avatar-sm me-3" alt="{{ $project->title }}">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $project->title }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $project->client_name ?? '-' }}</p>
                  <p class="text-xs text-secondary mb-0">{{ $project->location ?? '-' }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($project->is_published)
                    <span class="badge badge-sm bg-gradient-success">Published</span>
                  @else
                    <span class="badge badge-sm bg-gradient-secondary">Draft</span>
                  @endif
                </td>
                <td class="align-middle text-center">
                  <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit project">
                    Edit
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-sm text-secondary">Belum ada data proyek.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer pb-0">
          {{ $projects->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</div>
@endsection
