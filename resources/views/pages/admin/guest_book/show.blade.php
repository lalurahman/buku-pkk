@extends('layouts.admin')

@section('title', 'Detail Buku Tamu')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.guest-books.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Buku Tamu</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap kunjungan {{ $guestBook->visitor_name }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.guest-books.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <a
                    href="{{ route('admin.guest-books.edit', $guestBook->id) }}"
                    class="btn btn-label-primary"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </a>
                <form
                    action="{{ route('admin.guest-books.destroy', $guestBook->id) }}"
                    method="POST"
                    class="d-inline delete-guestbook-form"
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
            <!-- Guest Book Information Card -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class='bx bx-user bx-lg'></i>
                                    </span>
                                </div>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $guestBook->visitor_name }}</h5>
                                    <span class="badge bg-label-info">{{ $guestBook->institution }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-container mt-4">
                            <h5 class="pb-3 border-bottom mb-3">
                                <i class='bx bx-info-circle me-2'></i>
                                Informasi Kunjungan
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Nama Pengunjung:</span>
                                    <span>{{ $guestBook->visitor_name }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal Kunjungan:</span>
                                    <span>{{ \Carbon\Carbon::parse($guestBook->visit_date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Instansi:</span>
                                    <span>{{ $guestBook->institution }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Keperluan:</span>
                                    <span>{{ $guestBook->purpose }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Impressions -->
                @if ($guestBook->impressions)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-message-square-detail me-2'></i>
                                Kesan dan Pesan
                            </h5>
                            <p class="mb-0">{{ $guestBook->impressions }}</p>
                        </div>
                    </div>
                @endif

                <!-- System Information -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class='bx bx-time me-2'></i>
                            Informasi Sistem
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <span class="fw-medium text-heading me-2">Dibuat pada:</span>
                                <span>{{ $guestBook->created_at->format('d F Y, H:i') }} WIB</span>
                            </li>
                            <li class="mb-0">
                                <span class="fw-medium text-heading me-2">Terakhir diubah:</span>
                                <span>{{ $guestBook->updated_at->format('d F Y, H:i') }} WIB</span>
                            </li>
                        </ul>
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
            const deleteForm = document.querySelector('.delete-guestbook-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Data Buku Tamu?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus data buku tamu:</p>
                                <ul class="mb-0">
                                    <li><strong>Nama:</strong> {{ $guestBook->visitor_name }}</li>
                                    <li><strong>Instansi:</strong> {{ $guestBook->institution }}</li>
                                    <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($guestBook->visit_date)->format('d F Y') }}</li>
                                </ul>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            deleteForm.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
