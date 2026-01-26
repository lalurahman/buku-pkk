@extends('layouts.admin')

@section('title', 'Detail Data Keuangan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.cash-flows.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Data Keuangan</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap data keuangan {{ $cashFlow->receipt_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.cash-flows.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <a
                    href="{{ route('admin.cash-flows.edit', $cashFlow->id) }}"
                    class="btn btn-label-primary"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </a>
                <form
                    action="{{ route('admin.cash-flows.destroy', $cashFlow->id) }}"
                    method="POST"
                    class="d-inline delete-cashflow-form"
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
            <!-- Cash Flow Information Card -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span
                                        class="avatar-initial rounded-circle {{ $cashFlow->type == 'income' ? 'bg-label-success' : 'bg-label-danger' }}"
                                    >
                                        <i
                                            class='bx {{ $cashFlow->type == 'income' ? 'bx-trending-up' : 'bx-trending-down' }} bx-lg'></i>
                                    </span>
                                </div>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $cashFlow->receipt_number }}</h5>
                                    <span
                                        class="badge {{ $cashFlow->type == 'income' ? 'bg-label-success' : 'bg-label-danger' }}"
                                    >
                                        {{ $cashFlow->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="info-container mt-4">
                            <h5 class="pb-3 border-bottom mb-3">
                                <i class='bx bx-info-circle me-2'></i>
                                Informasi Keuangan
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">No. Bukti:</span>
                                    <span>{{ $cashFlow->receipt_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal:</span>
                                    <span>{{ \Carbon\Carbon::parse($cashFlow->date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Sumber Dana:</span>
                                    <span>{{ $cashFlow->sourceFund->name }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Jumlah:</span>
                                    <span
                                        class="fw-bold {{ $cashFlow->type == 'income' ? 'text-success' : 'text-danger' }}"
                                    >
                                        Rp {{ number_format($cashFlow->amount, 0, ',', '.') }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Description -->
                @if ($cashFlow->description)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-file-blank me-2'></i>
                                Keterangan
                            </h5>
                            <p class="mb-0">{{ $cashFlow->description }}</p>
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
                                <span>{{ $cashFlow->created_at->format('d F Y, H:i') }} WIB</span>
                            </li>
                            <li class="mb-0">
                                <span class="fw-medium text-heading me-2">Terakhir diubah:</span>
                                <span>{{ $cashFlow->updated_at->format('d F Y, H:i') }} WIB</span>
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
            const deleteForm = document.querySelector('.delete-cashflow-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Data Keuangan?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus data keuangan:</p>
                                <ul class="mb-0">
                                    <li><strong>No. Bukti:</strong> {{ $cashFlow->receipt_number }}</li>
                                    <li><strong>Tipe:</strong> {{ $cashFlow->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</li>
                                    <li><strong>Jumlah:</strong> Rp {{ number_format($cashFlow->amount, 0, ',', '.') }}</li>
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
