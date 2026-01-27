@extends('layouts.admin')

@section('title', 'Detail Notulensi Rapat')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header with Action Buttons -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.meeting-minutes.index') }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Detail Notulensi Rapat</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap notulensi rapat
                    {{ \Carbon\Carbon::parse($meetingMinute->meeting_date)->format('d F Y') }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.meeting-minutes.index') }}"
                    class="btn btn-label-secondary"
                >
                    <i class='bx bx-arrow-back me-1'></i>
                    Kembali
                </a>
                <a
                    href="{{ route('admin.meeting-minutes.edit', $meetingMinute->id) }}"
                    class="btn btn-label-primary"
                >
                    <i class='bx bx-edit me-1'></i>
                    Edit
                </a>
                <form
                    action="{{ route('admin.meeting-minutes.destroy', $meetingMinute->id) }}"
                    method="POST"
                    class="d-inline delete-meeting-form"
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
            <!-- Meeting Information Card -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        <i class='bx bx-file-blank bx-lg'></i>
                                    </span>
                                </div>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">
                                        {{ \Carbon\Carbon::parse($meetingMinute->meeting_date)->format('d F Y') }}</h5>
                                    <span class="badge bg-label-info">Notulensi Rapat</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-container mt-4">
                            <h5 class="pb-3 border-bottom mb-3">
                                <i class='bx bx-info-circle me-2'></i>
                                Informasi Rapat
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Tanggal:</span>
                                    <span>{{ \Carbon\Carbon::parse($meetingMinute->meeting_date)->format('d F Y') }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Lokasi:</span>
                                    <span>{{ $meetingMinute->location }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium text-heading me-2">Waktu:</span>
                                    <span>{{ \Carbon\Carbon::parse($meetingMinute->start_time)->format('H:i') }}
                                        @if ($meetingMinute->end_time)
                                            - {{ \Carbon\Carbon::parse($meetingMinute->end_time)->format('H:i') }}
                                        @endif
                                    </span>
                                </li>
                                @if ($meetingMinute->meeting_type)
                                    <li class="mb-3">
                                        <span class="fw-medium text-heading me-2">Jenis Rapat:</span>
                                        <span>{{ $meetingMinute->meeting_type }}</span>
                                    </li>
                                @endif
                                @if ($meetingMinute->leader)
                                    <li class="mb-3">
                                        <span class="fw-medium text-heading me-2">Pimpinan:</span>
                                        <span>{{ $meetingMinute->leader }}</span>
                                    </li>
                                @endif
                                @if ($meetingMinute->invited_count)
                                    <li class="mb-3">
                                        <span class="fw-medium text-heading me-2">Undangan:</span>
                                        <span>{{ $meetingMinute->invited_count }} orang</span>
                                    </li>
                                @endif
                                @if ($meetingMinute->attended_count)
                                    <li class="mb-3">
                                        <span class="fw-medium text-heading me-2">Kehadiran:</span>
                                        <span>{{ $meetingMinute->attended_count }} orang</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Agenda -->
                @if ($meetingMinute->agenda)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-list-ul me-2'></i>
                                Agenda Rapat
                            </h5>
                            <p class="mb-0">{{ $meetingMinute->agenda }}</p>
                        </div>
                    </div>
                @endif

                <!-- Discussion -->
                @if ($meetingMinute->discussion)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-conversation me-2'></i>
                                Pembahasan
                            </h5>
                            <p class="mb-0">{{ $meetingMinute->discussion }}</p>
                        </div>
                    </div>
                @endif

                <!-- Conclusion -->
                @if ($meetingMinute->conclusion)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-check-circle me-2'></i>
                                Kesimpulan
                            </h5>
                            <p class="mb-0">{{ $meetingMinute->conclusion }}</p>
                        </div>
                    </div>
                @endif

                <!-- Follow Up -->
                @if ($meetingMinute->follow_up)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class='bx bx-right-arrow-circle me-2'></i>
                                Tindak Lanjut
                            </h5>
                            <p class="mb-0">{{ $meetingMinute->follow_up }}</p>
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
                                <span>{{ $meetingMinute->created_at->format('d F Y, H:i') }} WIB</span>
                            </li>
                            <li class="mb-0">
                                <span class="fw-medium text-heading me-2">Terakhir diubah:</span>
                                <span>{{ $meetingMinute->updated_at->format('d F Y, H:i') }} WIB</span>
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
            const deleteForm = document.querySelector('.delete-meeting-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Notulensi Rapat?',
                        html: `
                            <div class="text-start">
                                <p class="mb-2">Anda akan menghapus notulensi rapat:</p>
                                <ul class="mb-0">
                                    <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($meetingMinute->meeting_date)->format('d F Y') }}</li>
                                    <li><strong>Lokasi:</strong> {{ $meetingMinute->location }}</li>
                                    @if ($meetingMinute->meeting_type)
                                        <li><strong>Jenis:</strong> {{ $meetingMinute->meeting_type }}</li>
                                    @endif
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
