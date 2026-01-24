@extends('layouts.district')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Desa /</span> Detail Desa
            </h4>

            <!-- Village Info Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Desa</h5>
                    @if (request()->has('activity_id'))
                        <a
                            href="{{ route('district.activities.show', request('activity_id')) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="bx bx-arrow-back"></i> Kembali ke Kegiatan
                        </a>
                    @else
                        <a
                            href="{{ route('district.villages.index') }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="180"><strong>Nama Desa/Kelurahan</strong></td>
                                        <td>: {{ $village->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kecamatan</strong></td>
                                        <td>: {{ $village->district->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kabupaten</strong></td>
                                        <td>: {{ $village->district->regency->name ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @php
                                $totalActivities = $village->villageActivities->count();
                                $completedActivities = $village->villageActivities
                                    ->where('status', 'completed')
                                    ->count();
                                $pendingActivities = $village->villageActivities->where('status', 'pending')->count();
                                $progressPercentage =
                                    $totalActivities > 0
                                        ? round(($completedActivities / $totalActivities) * 100, 1)
                                        : 0;
                            @endphp
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="180"><strong>Total Kegiatan</strong></td>
                                        <td>: <span class="badge bg-label-primary">{{ $totalActivities }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kegiatan Selesai</strong></td>
                                        <td>: <span class="badge bg-success">{{ $completedActivities }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kegiatan Pending</strong></td>
                                        <td>: <span class="badge bg-warning">{{ $pendingActivities }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Progress Keseluruhan</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="progress flex-grow-1 me-2"
                                                    style="height: 20px;"
                                                >
                                                    <div
                                                        class="progress-bar {{ $progressPercentage == 100 ? 'bg-success' : ($progressPercentage >= 50 ? 'bg-primary' : 'bg-warning') }}"
                                                        role="progressbar"
                                                        style="width: {{ $progressPercentage }}%;"
                                                        aria-valuenow="{{ $progressPercentage }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                    >
                                                        {{ $progressPercentage }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities by Type -->
            @forelse($groupedActivities as $activityName => $activities)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $activityName }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th
                                            width="50"
                                            class="text-center"
                                        >#</th>
                                        <th>Sub Kegiatan</th>
                                        <th
                                            width="150"
                                            class="text-center"
                                        >Status</th>
                                        <th
                                            width="120"
                                            class="text-center"
                                        >Galeri</th>
                                        <th
                                            width="180"
                                            class="text-center"
                                        >Tanggal Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $index => $villageActivity)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $villageActivity->subActivity->title ?? '-' }}</td>
                                            <td class="text-center">
                                                @if ($villageActivity->status === 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($villageActivity->status === 'in_progress')
                                                    <span class="badge bg-primary">Progress</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($villageActivity->galleryVillageActivities->count() > 0)
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#galleryModal{{ $villageActivity->id }}"
                                                    >
                                                        <i class="bx bx-images"></i>
                                                        {{ $villageActivity->galleryVillageActivities->count() }} Foto
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">
                                                    {{ $villageActivity->updated_at->format('d M Y H:i') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Gallery Modals -->
                @foreach ($activities as $villageActivity)
                    @if ($villageActivity->galleryVillageActivities->count() > 0)
                        <div
                            class="modal fade"
                            id="galleryModal{{ $villageActivity->id }}"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Galeri: {{ $villageActivity->subActivity->title ?? 'Sub Kegiatan' }}
                                        </h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            @foreach ($villageActivity->galleryVillageActivities as $gallery)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img
                                                            src="{{ asset('storage/' . $gallery->image) }}"
                                                            class="card-img-top"
                                                            alt="Gallery Image"
                                                            style="height: 200px; object-fit: cover;"
                                                        >
                                                        @if ($gallery->description)
                                                            <div class="card-body">
                                                                <p class="card-text small">{{ $gallery->description }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @empty
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i
                            class="bx bx-folder-open"
                            style="font-size: 48px; color: #ddd;"
                        ></i>
                        <p class="text-muted mt-3">Belum ada kegiatan yang dilakukan oleh desa ini</p>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
@endsection
