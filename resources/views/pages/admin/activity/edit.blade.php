@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

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
                    <h4 class="mb-0">Edit Kegiatan</h4>
                </div>
                <p class="text-muted mb-0">Perbarui informasi kegiatan</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('admin.activities.update', $activity->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label
                                    for="title"
                                    class="form-label fw-semibold"
                                >
                                    Judul Kegiatan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $activity->title) }}"
                                    placeholder="Masukkan judul kegiatan"
                                    required
                                >
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Contoh: Gerakan Menanam Pohon</small>
                            </div>

                            <div class="mb-4">
                                <label
                                    for="description"
                                    class="form-label fw-semibold"
                                >
                                    Deskripsi
                                </label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Masukkan deskripsi kegiatan (opsional)"
                                >{{ old('description', $activity->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Jelaskan secara singkat tentang kegiatan ini</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label
                                        for="start_date"
                                        class="form-label fw-semibold"
                                    >
                                        Tanggal Mulai
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date"
                                        name="start_date"
                                        value="{{ old('start_date', $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('Y-m-d') : '') }}"
                                    >
                                    @error('start_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label
                                        for="end_date"
                                        class="form-label fw-semibold"
                                    >
                                        Tanggal Selesai
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date"
                                        name="end_date"
                                        value="{{ old('end_date', $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('Y-m-d') : '') }}"
                                    >
                                    @error('end_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted">Tanggal selesai harus sama atau setelah tanggal mulai</small>
                                </div>
                            </div>

                            <div class="alert alert-info d-flex align-items-start">
                                <i class="bx bx-info-circle me-2 fs-5"></i>
                                <div>
                                    <strong>Catatan:</strong> Perubahan pada kegiatan ini akan mempengaruhi semua desa yang
                                    terkait dengan kegiatan ini.
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

        <!-- Informasi Tambahan -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bx bx-info-circle text-primary me-2"></i>
                            Informasi Kegiatan
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-list-ul text-primary me-2 fs-5"></i>
                                        <small class="text-muted">Sub Kegiatan</small>
                                    </div>
                                    <h4 class="mb-0">{{ $activity->subActivities->count() }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-target-lock text-success me-2 fs-5"></i>
                                        <small class="text-muted">Target Kegiatan</small>
                                    </div>
                                    <h4 class="mb-0">{{ $activity->targetActivities->count() }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-bulb text-warning me-2 fs-5"></i>
                                        <small class="text-muted">Inovasi Kegiatan</small>
                                    </div>
                                    <h4 class="mb-0">{{ $activity->innovationActivities->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-light mb-0">
                            <small>
                                <i class="bx bx-time-five me-1"></i>
                                Dibuat: {{ \Carbon\Carbon::parse($activity->created_at)->format('d F Y H:i') }}
                                @if ($activity->updated_at != $activity->created_at)
                                    | Terakhir diubah:
                                    {{ \Carbon\Carbon::parse($activity->updated_at)->format('d F Y H:i') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Validasi tanggal
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('end_date');

            if (startDate) {
                endDateInput.min = startDate;

                // Jika end_date sudah diisi tapi lebih kecil dari start_date, reset
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = startDate;
                }
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            const endDate = this.value;
            const startDateInput = document.getElementById('start_date');

            if (endDate) {
                startDateInput.max = endDate;

                // Jika start_date sudah diisi tapi lebih besar dari end_date, reset
                if (startDateInput.value && startDateInput.value > endDate) {
                    startDateInput.value = endDate;
                }
            }
        });

        // Trigger validasi saat halaman load jika sudah ada nilai
        window.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date').value;
            if (startDate) {
                document.getElementById('end_date').min = startDate;
            }
        });
    </script>
@endpush
