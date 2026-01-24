@extends('layouts.admin')

@section('title', 'Edit Inovasi Kegiatan')

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
                    <h4 class="mb-0">Edit Inovasi Kegiatan</h4>
                </div>
                <p class="text-muted mb-0">Perbarui informasi inovasi kegiatan</p>
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
                            action="{{ route('admin.activities.innovation-activities.update', [$activity->id, $innovationActivity->id]) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label
                                    for="title"
                                    class="form-label fw-semibold"
                                >
                                    Judul Inovasi Kegiatan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $innovationActivity->title) }}"
                                    placeholder="Masukkan judul inovasi kegiatan"
                                    required
                                    autofocus
                                >
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Contoh: Aplikasi mobile untuk monitoring kegiatan
                                    real-time</small>
                            </div>

                            <div class="alert alert-info d-flex align-items-start">
                                <i class="bx bx-info-circle me-2 fs-5"></i>
                                <div>
                                    <strong>Informasi:</strong>
                                    Inovasi kegiatan adalah hal-hal baru atau cara kreatif yang diterapkan dalam pelaksanaan
                                    kegiatan.
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
                        <div class="alert alert-light mb-0">
                            <small>
                                <i class="bx bx-time-five me-1"></i>
                                Dibuat: {{ \Carbon\Carbon::parse($innovationActivity->created_at)->format('d F Y H:i') }}
                                @if ($innovationActivity->updated_at != $innovationActivity->created_at)
                                    | Terakhir diubah:
                                    {{ \Carbon\Carbon::parse($innovationActivity->updated_at)->format('d F Y H:i') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
