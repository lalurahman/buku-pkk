@extends('layouts.admin')

@section('title', 'Detail Progress Kegiatan')

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

        <!-- Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-map-pin text-primary me-2 fs-4"></i>
                            <h4 class="mb-0">Desa : {{ $village->name }}</h4>
                        </div>
                        <p class="text-muted mb-2">Kecamatan : {{ $village->district->name ?? '-' }}</p>
                        <h5 class="text-muted mb-3">Kegiatan : {{ $activity->title }}</h5>

                        @if ($activity->description)
                            <p class="text-muted mb-3">{{ $activity->description }}</p>
                        @endif

                        @php
                            $totalActivities = $villageActivities->count();
                            $completedActivities = $villageActivities->where('status', 'completed')->count();
                            $percentage =
                                $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100, 1) : 0;
                        @endphp

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
                                <small class="text-muted">{{ $totalActivities }} Sub Kegiatan</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small class="text-muted">{{ $completedActivities }} Selesai</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock text-warning me-2"></i>
                                <small class="text-muted">{{ $totalActivities - $completedActivities }} Pending</small>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress Keseluruhan</small>
                                <small class="fw-semibold">{{ $percentage }}%</small>
                            </div>
                            <div
                                class="progress"
                                style="height: 10px;"
                            >
                                <div
                                    class="progress-bar {{ $percentage == 100 ? 'bg-success' : 'bg-primary' }}"
                                    role="progressbar"
                                    style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <a
                        href="{{ route('admin.activities.progress', $activity->id) }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Sub Activities grouped by Activity -->
        @php
            // Group village activities by their parent activity (sub_activity's activity)
            $groupedActivities = $villageActivities->groupBy(function ($villageActivity) {
                return $villageActivity->subActivity->activity_id;
            });
        @endphp

        @foreach ($groupedActivities as $activityId => $activities)
            @php
                $firstActivity = $activities->first();
                $parentActivity = $firstActivity->subActivity->activity;
                $totalInGroup = $activities->count();
                $completedInGroup = $activities->where('status', 'completed')->count();
                $percentageInGroup = $totalInGroup > 0 ? round(($completedInGroup / $totalInGroup) * 100, 1) : 0;
            @endphp

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ $parentActivity->title }}</h5>
                            @if ($parentActivity->description)
                                <small class="text-muted">{{ $parentActivity->description }}</small>
                            @endif
                        </div>
                        <div class="text-end">
                            <span
                                class="badge {{ $percentageInGroup == 100 ? 'bg-success' : ($percentageInGroup >= 50 ? 'bg-primary' : 'bg-warning') }} fs-6"
                            >
                                {{ $completedInGroup }}/{{ $totalInGroup }} Selesai ({{ $percentageInGroup }}%)
                            </span>
                        </div>
                    </div>

                    <!-- Progress Bar for this group -->
                    <div class="mt-3">
                        <div
                            class="progress"
                            style="height: 6px;"
                        >
                            <div
                                class="progress-bar {{ $percentageInGroup == 100 ? 'bg-success' : 'bg-primary' }}"
                                role="progressbar"
                                style="width: {{ $percentageInGroup }}%"
                                aria-valuenow="{{ $percentageInGroup }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th
                                        class="text-center"
                                        style="width: 50px;"
                                    >#</th>
                                    <th>Sub Kegiatan</th>
                                    <th
                                        class="text-center"
                                        style="width: 150px;"
                                    >Status</th>
                                    <th
                                        class="text-center"
                                        style="width: 180px;"
                                    >Tanggal Selesai</th>
                                    <th
                                        class="text-center"
                                        style="width: 100px;"
                                    >Galeri</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $index => $villageActivity)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-task me-2 text-muted"></i>
                                                {{ $villageActivity->subActivity->title }}
                                            </div>
                                        </td>
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
                                                <span class="text-dark">
                                                    <i class="bx bx-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($villageActivity->finish_date)->format('d M Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($villageActivity->galleries && $villageActivity->galleries->count() > 0)
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#galleryModal{{ $villageActivity->id }}"
                                                >
                                                    <i class="bx bx-image-alt me-1"></i>
                                                    {{ $villageActivity->galleries->count() }}
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td
                                        colspan="2"
                                        class="text-end fw-semibold"
                                    >Total:</td>
                                    <td class="text-center fw-semibold">
                                        <span class="badge bg-success">{{ $completedInGroup }}</span> /
                                        <span class="badge bg-secondary">{{ $totalInGroup }}</span>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Gallery Modals for this group -->
            @foreach ($activities as $villageActivity)
                @if ($villageActivity->galleries && $villageActivity->galleries->count() > 0)
                    <div
                        class="modal fade"
                        id="galleryModal{{ $villageActivity->id }}"
                        tabindex="-1"
                        aria-labelledby="galleryModalLabel{{ $villageActivity->id }}"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="galleryModalLabel{{ $villageActivity->id }}"
                                    >
                                        Galeri - {{ $villageActivity->subActivity->title }}
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
                                        @foreach ($villageActivity->galleries as $gallery)
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <img
                                                        src="{{ asset('storage/' . $gallery->image) }}"
                                                        class="card-img-top"
                                                        alt="Gallery Image"
                                                        style="height: 300px; object-fit: cover;"
                                                    >
                                                    <div class="card-body">
                                                        <small class="text-muted">
                                                            <i class="bx bx-calendar me-1"></i>
                                                            {{ \Carbon\Carbon::parse($gallery->created_at)->format('d M Y H:i') }}
                                                        </small>
                                                    </div>
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
        @endforeach

        @if ($villageActivities->count() === 0)
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bx bx-info-circle display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada sub kegiatan</h5>
                    <p class="text-muted mb-0">Desa ini belum memiliki sub kegiatan untuk kegiatan ini</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    >
@endpush
