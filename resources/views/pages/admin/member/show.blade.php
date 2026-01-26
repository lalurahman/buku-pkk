@extends('layouts.admin')

@section('title', 'Detail Kader')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.members.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Kader</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap kader {{ $member->name }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.members.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <button
                    type="button"
                    class="btn btn-label-primary"
                    onclick="window.location.href='{{ route('admin.members.edit', $member->id) }}'"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </button>
                <form
                    action="{{ route('admin.members.destroy', $member->id) }}"
                    method="POST"
                    class="d-inline delete-member-form"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-label-danger"
                    >
                        <i class='bx bx-trash me-1'></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Member Information Card -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        <i class='bx bx-user bx-lg'></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="info-container mt-4">
                            <h5 class="pb-3 border-bottom mb-3">
                                <i class='bx bx-info-circle me-2'></i>
                                Informasi Dasar
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">No. Registrasi:</span>
                                    <span>{{ $member->registration_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Peran:</span>
                                    <span>{{ $member->memberRole->name ?? '-' }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Jabatan Fungsional:</span>
                                    <span>{{ $member->functionalPosition->name ?? '-' }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">No. Telepon:</span>
                                    <span>{{ $member->phone_number ?? '-' }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Status Pernikahan:</span>
                                    <span>{{ $member->marital_status ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Personal Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class='bx bx-user-circle me-2'></i>
                            Informasi Pribadi
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Tanggal Lahir</small>
                                <p class="mb-0">
                                    {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('d F Y') : '-' }}
                                </p>
                                @if ($member->date_of_birth)
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($member->date_of_birth)->age }} tahun)
                                    </small>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Pendidikan</small>
                                <p class="mb-0">{{ $member->education ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Pekerjaan</small>
                                <p class="mb-0">{{ $member->job ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Status</small>
                                <p class="mb-0">
                                    <span
                                        class="badge bg-label-{{ $member->status === 'active' ? 'success' : 'secondary' }}"
                                    >
                                        {{ ucfirst($member->status ?? 'active') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class='bx bx-map me-2'></i>
                            Alamat
                        </h5>
                        <p class="mb-0">{{ $member->address ?? 'Alamat belum diisi' }}</p>
                    </div>
                </div>

                <!-- Activity Timeline (Optional - if you have activity logs) -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class='bx bx-time me-2'></i>
                            Informasi Sistem
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Dibuat Pada</small>
                                <p class="mb-0">{{ $member->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Terakhir Diupdate</small>
                                <p class="mb-0">{{ $member->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete confirmation with SweetAlert2
            const deleteForm = document.querySelector('.delete-member-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Kader?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus kader:</p>
                                <div class="alert alert-warning mb-0">
                                    <strong><i class='bx bx-user'></i> {{ $member->name }}</strong><br>
                                    <small>No. Registrasi: {{ $member->registration_number }}</small>
                                </div>
                                <p class="text-danger mt-3 mb-0">
                                    <i class='bx bx-info-circle'></i> 
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bx bx-trash me-1"></i> Ya, Hapus!',
                        cancelButtonText: '<i class="bx bx-x me-1"></i> Batal',
                        reverseButtons: true,
                        width: '500px',
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Menghapus...',
                                html: 'Menghapus data kader...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
