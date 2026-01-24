@extends('layouts.admin')

@section('title', 'Edit Sub Kegiatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible"
                role="alert"
            >
                {{ session('success') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible"
                role="alert"
            >
                {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.activities.show', $activity->id) }}"
                        class="text-muted me-2"
                    >
                        <i class="bx bx-arrow-back"></i>
                    </a>
                    <h4 class="mb-0">Edit Sub Kegiatan</h4>
                </div>
                <p class="text-muted mb-0">Perbarui informasi sub kegiatan</p>
            </div>
        </div>

        <!-- Breadcrumb Info -->
        <div class="card mb-4">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <i class="bx bx-folder text-muted me-1"></i>
                            <span class="text-muted">Kegiatan:</span>
                        </li>
                        <li class="breadcrumb-item active">{{ $activity->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('admin.activities.sub-activities.update', [$activity->id, $subActivity->id]) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label
                                    for="title"
                                    class="form-label fw-semibold"
                                >
                                    Judul Sub Kegiatan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $subActivity->title) }}"
                                    placeholder="Masukkan judul sub kegiatan"
                                    required
                                    autofocus
                                >
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Contoh: Pelatihan Pengolahan Sampah Organik</small>
                            </div>

                            <div class="alert alert-info d-flex align-items-start">
                                <i class="bx bx-info-circle me-2 fs-5"></i>
                                <div>
                                    <strong>Catatan:</strong>
                                    Perubahan pada sub kegiatan ini akan mempengaruhi semua desa yang memiliki sub kegiatan
                                    ini.
                                    Total <span
                                        class="badge bg-primary">{{ $subActivity->villageActivities->count() }}</span> desa
                                    terkait dengan sub kegiatan ini.
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <a
                                    href="{{ route('admin.activities.show', $activity->id) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    <i class="bx bx-x me-1"></i> Batal
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Desa Terkait -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bx bx-map text-primary me-2"></i>
                            Desa yang Memiliki Sub Kegiatan Ini
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($subActivity->villageActivities->count() > 0)
                            <div class="row">
                                @php
                                    $completedCount = $subActivity->villageActivities
                                        ->where('status', 'completed')
                                        ->count();
                                    $pendingCount = $subActivity->villageActivities
                                        ->where('status', 'pending')
                                        ->count();
                                @endphp

                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-map-pin text-primary me-2 fs-5"></i>
                                            <small class="text-muted">Total Desa</small>
                                        </div>
                                        <h4 class="mb-0">{{ $subActivity->villageActivities->count() }}</h4>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-check-circle text-success me-2 fs-5"></i>
                                            <small class="text-muted">Selesai</small>
                                        </div>
                                        <h4 class="mb-0 text-success">{{ $completedCount }}</h4>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-time text-warning me-2 fs-5"></i>
                                            <small class="text-muted">Pending</small>
                                        </div>
                                        <h4 class="mb-0 text-warning">{{ $pendingCount }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th
                                                class="text-center"
                                                style="width: 50px;"
                                            >#</th>
                                            <th>Nama Desa</th>
                                            <th>Kecamatan</th>
                                            <th
                                                class="text-center"
                                                style="width: 150px;"
                                            >Status</th>
                                            <th
                                                class="text-center"
                                                style="width: 180px;"
                                            >Tanggal Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subActivity->villageActivities as $index => $villageActivity)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <i class="bx bx-map-pin text-muted me-1"></i>
                                                    {{ $villageActivity->village->name }}
                                                </td>
                                                <td>{{ $villageActivity->village->district->name ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($villageActivity->status === 'completed')
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check-circle me-1"></i>Selesai
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="bx bx-time me-1"></i>Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($villageActivity->finish_date)
                                                        <small>
                                                            <i class="bx bx-calendar me-1"></i>
                                                            {{ \Carbon\Carbon::parse($villageActivity->finish_date)->format('d M Y') }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-info-circle display-4 text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada desa yang memiliki sub kegiatan ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-light mb-0">
                            <small>
                                <i class="bx bx-time-five me-1"></i>
                                Dibuat: {{ \Carbon\Carbon::parse($subActivity->created_at)->format('d F Y H:i') }}
                                @if ($subActivity->updated_at != $subActivity->created_at)
                                    | Terakhir diubah:
                                    {{ \Carbon\Carbon::parse($subActivity->updated_at)->format('d F Y H:i') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
