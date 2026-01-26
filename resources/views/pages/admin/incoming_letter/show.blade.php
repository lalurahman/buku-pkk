@extends('layouts.admin')

@section('title', 'Detail Surat Masuk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.incoming-letters.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Surat Masuk</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap surat masuk {{ $incomingLetter->letter_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.incoming-letters.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <a
                    href="{{ route('admin.incoming-letters.edit', $incomingLetter->id) }}"
                    class="btn btn-label-primary"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </a>
                <form
                    action="{{ route('admin.incoming-letters.destroy', $incomingLetter->id) }}"
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
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class='bx bx-envelope bx-lg'></i>
                                    </span>
                                </div>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{ $incomingLetter->letter_number }}</h5>
                                    <span class="badge bg-label-success">Surat Masuk</span>
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
                                    <span>{{ $incomingLetter->letter_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal Diterima:</span>
                                    <span>{{ \Carbon\Carbon::parse($incomingLetter->received_date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal Surat:</span>
                                    <span>{{ \Carbon\Carbon::parse($incomingLetter->letter_date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Pengirim:</span>
                                    <span>{{ $incomingLetter->sender }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Lampiran :</span>
                                    @if ($incomingLetter->has_attachment)
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
                        <p class="mb-0">{{ $incomingLetter->subject }}</p>
                    </div>
                </div>

                <!-- File Attachment -->
                @if ($incomingLetter->file)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-paperclip me-2'></i>
                                File Lampiran
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class='bx bx-file bx-sm'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ basename($incomingLetter->file) }}</h6>
                                    <small class="text-muted">
                                        {{ strtoupper(pathinfo($incomingLetter->file, PATHINFO_EXTENSION)) }}
                                    </small>
                                </div>
                                <a
                                    href="{{ Storage::url($incomingLetter->file) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class='bx bx-show me-1'></i>
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Dispositions -->
                @if ($incomingLetter->letterDispositions && $incomingLetter->letterDispositions->count() > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-list-ul me-2'></i>
                                Disposisi Surat
                            </h5>
                            <div
                                class="accordion"
                                id="dispositionsAccordion"
                            >
                                @foreach ($incomingLetter->letterDispositions as $index => $disposition)
                                    <div class="accordion-item">
                                        <h2
                                            class="accordion-header"
                                            id="heading{{ $index }}"
                                        >
                                            <button
                                                class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $index }}"
                                            >
                                                <div class="d-flex align-items-center w-100">
                                                    <div class="flex-grow-1">
                                                        <strong>{{ $disposition->disposition_to }}</strong>
                                                        @if ($disposition->priority)
                                                            @if ($disposition->priority == 'urgent')
                                                                <span class="badge bg-danger ms-2">Segera</span>
                                                            @elseif ($disposition->priority == 'important')
                                                                <span class="badge bg-warning ms-2">Penting</span>
                                                            @else
                                                                <span class="badge bg-info ms-2">Normal</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if ($disposition->disposition_date)
                                                        <small class="text-muted me-3">
                                                            {{ \Carbon\Carbon::parse($disposition->disposition_date)->format('d/m/Y') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </button>
                                        </h2>
                                        <div
                                            id="collapse{{ $index }}"
                                            class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                            aria-labelledby="heading{{ $index }}"
                                            data-bs-parent="#dispositionsAccordion"
                                        >
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <small class="text-muted d-block mb-1">Tujuan Disposisi</small>
                                                        <strong>{{ $disposition->disposition_to }}</strong>
                                                    </div>
                                                    @if ($disposition->from)
                                                        <div class="col-md-6 mb-3">
                                                            <small class="text-muted d-block mb-1">Dari</small>
                                                            <strong>{{ $disposition->from }}</strong>
                                                        </div>
                                                    @endif
                                                    @if ($disposition->disposition_date)
                                                        <div class="col-md-6 mb-3">
                                                            <small class="text-muted d-block mb-1">Tanggal
                                                                Disposisi</small>
                                                            <strong>{{ \Carbon\Carbon::parse($disposition->disposition_date)->format('d F Y') }}</strong>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-6 mb-3">
                                                        <small class="text-muted d-block mb-1">Prioritas</small>
                                                        @if ($disposition->priority == 'urgent')
                                                            <span class="badge bg-danger">Segera</span>
                                                        @elseif ($disposition->priority == 'important')
                                                            <span class="badge bg-warning">Penting</span>
                                                        @else
                                                            <span class="badge bg-info">Normal</span>
                                                        @endif
                                                    </div>
                                                    @if ($disposition->instructions)
                                                        <div class="col-12">
                                                            <small class="text-muted d-block mb-1">Instruksi</small>
                                                            <p class="mb-0">{{ $disposition->instructions }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                                <p class="mb-0">{{ $incomingLetter->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted text-uppercase">Terakhir Diupdate</small>
                                <p class="mb-0">{{ $incomingLetter->updated_at->format('d F Y, H:i') }}</p>
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
                        title: 'Hapus Surat Masuk?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus surat masuk:</p>
                                <div class="alert alert-warning mb-0">
                                    <strong><i class='bx bx-envelope'></i> {{ $incomingLetter->letter_number }}</strong><br>
                                    <small>Pengirim: {{ $incomingLetter->sender }}</small><br>
                                    <small>Perihal: {{ Str::limit($incomingLetter->subject, 50) }}</small>
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
                                html: 'Menghapus surat masuk dan file lampiran...',
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
