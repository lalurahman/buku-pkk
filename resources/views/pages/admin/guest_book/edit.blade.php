@extends('layouts.admin')

@section('title', 'Edit Buku Tamu')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.guest-books.show', $guestBook->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Buku Tamu</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi kunjungan {{ $guestBook->visitor_name }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.guest-books.show', $guestBook->id) }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-x me-1'></i>
                    Batal
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-edit me-2'></i>
                            Form Edit Buku Tamu
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.guest-books.update', $guestBook->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Visitor Name --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="visitor_name"
                                        class="form-label"
                                    >
                                        Nama Pengunjung <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('visitor_name') is-invalid @enderror"
                                        id="visitor_name"
                                        name="visitor_name"
                                        placeholder="Nama lengkap pengunjung"
                                        value="{{ old('visitor_name', $guestBook->visitor_name) }}"
                                        required
                                    >
                                    @error('visitor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Visit Date --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="visit_date"
                                        class="form-label"
                                    >
                                        Tanggal Kunjungan <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('visit_date') is-invalid @enderror"
                                        id="visit_date"
                                        name="visit_date"
                                        value="{{ old('visit_date', $guestBook->visit_date) }}"
                                        required
                                    >
                                    @error('visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Institution --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="institution"
                                        class="form-label"
                                    >
                                        Instansi <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('institution') is-invalid @enderror"
                                        id="institution"
                                        name="institution"
                                        placeholder="Nama instansi/organisasi"
                                        value="{{ old('institution', $guestBook->institution) }}"
                                        required
                                    >
                                    @error('institution')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Purpose --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="purpose"
                                        class="form-label"
                                    >
                                        Keperluan <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('purpose') is-invalid @enderror"
                                        id="purpose"
                                        name="purpose"
                                        placeholder="Tujuan kunjungan"
                                        value="{{ old('purpose', $guestBook->purpose) }}"
                                        required
                                    >
                                    @error('purpose')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Impressions --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="impressions"
                                        class="form-label"
                                    >
                                        Kesan dan Pesan
                                    </label>
                                    <textarea
                                        class="form-control @error('impressions') is-invalid @enderror"
                                        id="impressions"
                                        name="impressions"
                                        rows="3"
                                        placeholder="Kesan dan pesan dari kunjungan (opsional)"
                                    >{{ old('impressions', $guestBook->impressions) }}</textarea>
                                    @error('impressions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a
                                    href="{{ route('admin.guest-books.show', $guestBook->id) }}"
                                    class="btn btn-label-secondary"
                                >
                                    <i class='bx bx-x me-1'></i>
                                    Batal
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class='bx bx-save me-1'></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Mohon lengkapi semua field yang wajib diisi.',
                            confirmButtonColor: '#6c757d'
                        });
                    }
                });
            }
        });
    </script>
@endpush
