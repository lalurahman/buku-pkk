@extends('layouts.admin')

@section('title', 'Progress Kegiatan')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav
            aria-label="breadcrumb"
            class="py-5"
        >
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">Kegiatan</a></li>
                <li class="breadcrumb-item text-capitalize"><a
                        href="{{ route('admin.activities.show', $activity->id) }}">{{ $activity->title }}</a></li>
                <li class="breadcrumb-item active">Progress</li>
            </ol>
        </nav>

        <!-- Header Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title mb-3">
                            Progress Kegiatan
                        </h4>
                        <h5 class="text-muted mb-3">{{ $activity->title }}</h5>

                        @if ($activity->description)
                            <p class="text-muted mb-3">{{ $activity->description }}</p>
                        @endif

                        <div class="d-flex gap-3 flex-wrap">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 text-muted me-2"></i>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                </small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-list-task text-muted me-2"></i>
                                <small class="text-muted">{{ $activity->subActivities->count() }} Sub Kegiatan</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt text-muted me-2"></i>
                                <small class="text-muted">{{ $villages->count() }} Desa/Kelurahan</small>
                            </div>
                        </div>
                    </div>
                    <a
                        href="{{ route('admin.activities.show', $activity->id) }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <!-- Table Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0">Daftar Desa/Kelurahan</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <select
                                    id="districtFilter"
                                    class="form-select"
                                >
                                    <option value="">Semua Kecamatan</option>
                                    @foreach ($districts as $district)
                                        <option
                                            value="{{ $district->id }}"
                                            {{ request('district_id') == $district->id ? 'selected' : '' }}
                                        >
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    id="resetFilter"
                                >
                                    <i class="bi bi-x-circle me-1"></i> Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('admin/datatables/datatables-bootstrap5.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Filter by district
            $('#districtFilter').on('change', function() {
                const districtId = $(this).val();
                const table = window.LaravelDataTables["progress-table"];

                // Add district_id parameter to ajax URL
                table.ajax.url("{{ route('admin.activities.progress', $activity->id) }}?district_id=" +
                    districtId).load();
            });

            // Reset filter
            $('#resetFilter').on('click', function() {
                $('#districtFilter').val('');
                const table = window.LaravelDataTables["progress-table"];
                table.ajax.url("{{ route('admin.activities.progress', $activity->id) }}").load();
            });
        });
    </script>
@endpush
