@extends('layouts.admin')

@section('title', 'Detail Kegiatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.activities.index') }}"
                        class="text-muted me-2"
                    >
                        <i class="bx bx-arrow-back"></i>
                    </a>
                    <h4 class="mb-0">Detail Kegiatan</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap tentang kegiatan</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.activities.progress', $activity->id) }}"
                    class="btn btn-success"
                >
                    <i class="bx bx-chart me-1"></i> Lihat Progress
                </a>
                <a
                    href="{{ route('admin.activities.edit', $activity->id) }}"
                    class="btn btn-primary"
                >
                    <i class="bx bx-edit me-1"></i> Edit Kegiatan
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-3 mb-4">Informasi Kegiatan</h5>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Judul Kegiatan</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">{{ $activity->title }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Deskripsi</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">{{ $activity->description ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Tanggal Mulai</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">
                                    @if ($activity->start_date)
                                        {{ \Carbon\Carbon::parse($activity->start_date)->format('d F Y') }}
                                    @else
                                        <span class="text-muted">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Tanggal Selesai</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">
                                    @if ($activity->end_date)
                                        {{ \Carbon\Carbon::parse($activity->end_date)->format('d F Y') }}
                                    @else
                                        <span class="text-muted">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Durasi</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">
                                    @if ($activity->start_date && $activity->end_date)
                                        {{ \Carbon\Carbon::parse($activity->start_date)->diffInDays(\Carbon\Carbon::parse($activity->end_date)) + 1 }}
                                        hari
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Status</label>
                            </div>
                            <div class="col-md-9">
                                @if ($activity->start_date && $activity->end_date)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $start = \Carbon\Carbon::parse($activity->start_date);
                                        $end = \Carbon\Carbon::parse($activity->end_date);
                                    @endphp

                                    @if ($now->lt($start))
                                        <span class="badge bg-label-info">Akan Datang</span>
                                    @elseif($now->between($start, $end))
                                        <span class="badge bg-label-success">Sedang Berlangsung</span>
                                    @else
                                        <span class="badge bg-label-secondary">Selesai</span>
                                    @endif
                                @else
                                    <span class="badge bg-label-warning">Tanggal Belum Diatur</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="fw-semibold text-muted">Dibuat Pada</label>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0">{{ $activity->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Activities -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Sub Kegiatan</h5>
                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#subActivityModal"
                        >
                            <i class="bx bx-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($activity->subActivities->count() > 0)
                            <div class="list-group">
                                @foreach ($activity->subActivities as $index => $subActivity)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-label-primary me-2">{{ $index + 1 }}</span>
                                            {{ $subActivity->title }}
                                        </div>
                                        <form
                                            action="{{ route('admin.activities.sub-activities.destroy', [$activity->id, $subActivity->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus sub kegiatan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada sub kegiatan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Target Activities -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Target Kegiatan</h5>
                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#targetActivityModal"
                        >
                            <i class="bx bx-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($activity->targetActivities->count() > 0)
                            <div class="list-group">
                                @foreach ($activity->targetActivities as $index => $targetActivity)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-label-success me-2">{{ $index + 1 }}</span>
                                            {{ $targetActivity->title }}
                                        </div>
                                        <form
                                            action="{{ route('admin.activities.target-activities.destroy', [$activity->id, $targetActivity->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus target kegiatan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada target kegiatan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Innovation Activities -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Inovasi Kegiatan</h5>
                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#innovationActivityModal"
                        >
                            <i class="bx bx-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($activity->innovationActivities->count() > 0)
                            <div class="list-group">
                                @foreach ($activity->innovationActivities as $index => $innovationActivity)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-label-info me-2">{{ $index + 1 }}</span>
                                            {{ $innovationActivity->title }}
                                        </div>
                                        <form
                                            action="{{ route('admin.activities.innovation-activities.destroy', [$activity->id, $innovationActivity->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus inovasi kegiatan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada inovasi kegiatan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Impact Activities -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Dampak Kegiatan</h5>
                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#impactActivityModal"
                        >
                            <i class="bx bx-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($activity->impactActivities->count() > 0)
                            <div class="list-group">
                                @foreach ($activity->impactActivities as $index => $impactActivity)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-label-warning me-2">{{ $index + 1 }}</span>
                                            {{ $impactActivity->title }}
                                        </div>
                                        <form
                                            action="{{ route('admin.activities.impact-activities.destroy', [$activity->id, $impactActivity->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus dampak kegiatan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada dampak kegiatan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @push('modal')
        <!-- Sub Activity Modal -->
        <div
            class="modal fade"
            id="subActivityModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div
                class="modal-dialog"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Sub Kegiatan</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        action="{{ route('admin.activities.sub-activities.store', $activity->id) }}"
                        method="POST"
                    >
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label
                                    for="sub-activity-title"
                                    class="form-label"
                                >Judul Sub Kegiatan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="sub-activity-title"
                                    name="title"
                                    placeholder="Masukkan judul sub kegiatan"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-label-secondary"
                                data-bs-dismiss="modal"
                            >Batal</button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Target Activity Modal -->
        <div
            class="modal fade"
            id="targetActivityModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div
                class="modal-dialog"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Target Kegiatan</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        action="{{ route('admin.activities.target-activities.store', $activity->id) }}"
                        method="POST"
                    >
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label
                                    for="target-activity-title"
                                    class="form-label"
                                >Judul Target Kegiatan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="target-activity-title"
                                    name="title"
                                    placeholder="Masukkan judul target kegiatan"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-label-secondary"
                                data-bs-dismiss="modal"
                            >Batal</button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Innovation Activity Modal -->
        <div
            class="modal fade"
            id="innovationActivityModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div
                class="modal-dialog"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Inovasi Kegiatan</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        action="{{ route('admin.activities.innovation-activities.store', $activity->id) }}"
                        method="POST"
                    >
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label
                                    for="innovation-activity-title"
                                    class="form-label"
                                >Judul Inovasi Kegiatan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="innovation-activity-title"
                                    name="title"
                                    placeholder="Masukkan judul inovasi kegiatan"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-label-secondary"
                                data-bs-dismiss="modal"
                            >Batal</button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Impact Activity Modal -->
        <div
            class="modal fade"
            id="impactActivityModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div
                class="modal-dialog"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Dampak Kegiatan</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        action="{{ route('admin.activities.impact-activities.store', $activity->id) }}"
                        method="POST"
                    >
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label
                                    for="impact-activity-title"
                                    class="form-label"
                                >Judul Dampak Kegiatan <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="impact-activity-title"
                                    name="title"
                                    placeholder="Masukkan judul dampak kegiatan"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-label-secondary"
                                data-bs-dismiss="modal"
                            >Batal</button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush
@endsection
