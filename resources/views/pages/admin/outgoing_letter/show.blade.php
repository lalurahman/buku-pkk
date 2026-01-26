@extends('layouts.admin')

@section('title', 'Detail Surat Keluar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.outgoing-letters.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Surat Keluar</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap surat keluar {{ $outgoingLetter->letter_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.outgoing-letters.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <a
                    href="{{ route('admin.outgoing-letters.edit', $outgoingLetter->id) }}"
                    class="btn btn-label-primary"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </a>
                <form
                    action="{{ route('admin.outgoing-letters.destroy', $outgoingLetter->id) }}"
                    method="POST"
                    class="d-inline delete-letter-form"
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
            <!-- Letter Information Card -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class='bx bx-send bx-lg'></i>
                                    </span>
                                </div>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $outgoingLetter->letter_number }}</h5>
                                    <span class="badge bg-label-success">Surat Keluar</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-container mt-4">
                            <h5 class="pb-3 border-bottom mb-3">
                                <i class='bx bx-info-circle me-2'></i>
                                Informasi Surat
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">No. Surat:</span>
                                    <span>{{ $outgoingLetter->letter_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal Surat:</span>
                                    <span>{{ \Carbon\Carbon::parse($outgoingLetter->letter_date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Penerima:</span>
                                    <span>{{ $outgoingLetter->recipient }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Lampiran:</span>
                                    @if ($outgoingLetter->has_attachment)
                                        <span class="badge bg-label-success">
                                            <i class='bx bx-check'></i> Ada
                                        </span>
                                    @else
                                        <span class="badge bg-label-secondary">
                                            <i class='bx bx-x'></i> Tidak Ada
                                        </span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Subject -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class='bx bx-file-blank me-2'></i>
                            Perihal
                        </h5>
                        <p class="mb-0">{{ $outgoingLetter->subject }}</p>
                    </div>
                </div>

                <!-- File Attachment -->
                @if ($outgoingLetter->file)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-paperclip me-2'></i>
                                File Lampiran
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class='bx bx-file bx-sm'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ basename($outgoingLetter->file) }}</h6>
                                    <small class="text-muted">
                                        {{ strtoupper(pathinfo($outgoingLetter->file, PATHINFO_EXTENSION)) }}
                                    </small>
                                </div>
                                <a
                                    href="{{ Storage::url($outgoingLetter->file) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-success"
                                >
                                    <i class='bx bx-show me-1'></i>
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- CC Recipients -->
                @if ($outgoingLetter->outgoingLetterCcs && $outgoingLetter->outgoingLetterCcs->count() > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-copy me-2'></i>
                                Tembusan
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outgoingLetter->outgoingLetterCcs as $index => $cc)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $cc->cc_recipient ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Dibuat Pada</small>
                                <p class="mb-0">{{ $outgoingLetter->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Terakhir Diupdate</small>
                                <p class="mb-0">{{ $outgoingLetter->updated_at->format('d F Y, H:i') }}</p>
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
            const deleteForm = document.querySelector('.delete-letter-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Surat Keluar?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus surat keluar:</p>
                                <div class="alert alert-warning mb-0">
                                    <strong><i class='bx bx-send'></i> {{ $outgoingLetter->letter_number }}</strong><br>
                                    <small>Penerima: {{ $outgoingLetter->recipient }}</small><br>
                                    <small>Perihal: {{ Str::limit($outgoingLetter->subject, 50) }}</small>
                                </div>
                                <p class="text-danger mt-3 mb-0">
                                    <i class='bx bx-info-circle'></i> 
                                    Tindakan ini tidak dapat dibatalkan dan file lampiran akan terhapus.
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
                                html: 'Menghapus surat keluar dan file lampiran...',
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
