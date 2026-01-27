@extends('layouts.admin')

@section('title', 'Edit Notulensi Rapat')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.meeting-minutes.show', $meetingMinute->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Notulensi Rapat</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi notulensi rapat
                    {{ \Carbon\Carbon::parse($meetingMinute->meeting_date)->format('d F Y') }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.meeting-minutes.show', $meetingMinute->id) }}"
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
                            Form Edit Notulensi Rapat
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.meeting-minutes.update', $meetingMinute->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Meeting Date --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="meeting_date"
                                        class="form-label"
                                    >
                                        Tanggal Rapat <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('meeting_date') is-invalid @enderror"
                                        id="meeting_date"
                                        name="meeting_date"
                                        value="{{ old('meeting_date', $meetingMinute->meeting_date) }}"
                                        required
                                    >
                                    @error('meeting_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Location --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="location"
                                        class="form-label"
                                    >
                                        Lokasi <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('location') is-invalid @enderror"
                                        id="location"
                                        name="location"
                                        placeholder="Contoh: Aula TP PKK"
                                        value="{{ old('location', $meetingMinute->location) }}"
                                        required
                                    >
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Start Time --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="start_time"
                                        class="form-label"
                                    >
                                        Waktu Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="time"
                                        class="form-control @error('start_time') is-invalid @enderror"
                                        id="start_time"
                                        name="start_time"
                                        value="{{ old('start_time', $meetingMinute->start_time) }}"
                                        required
                                    >
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- End Time --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="end_time"
                                        class="form-label"
                                    >
                                        Waktu Selesai
                                    </label>
                                    <input
                                        type="time"
                                        class="form-control @error('end_time') is-invalid @enderror"
                                        id="end_time"
                                        name="end_time"
                                        value="{{ old('end_time', $meetingMinute->end_time) }}"
                                    >
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Meeting Type --}}
                                <div class="col-md-4 mb-3">
                                    <label
                                        for="meeting_type"
                                        class="form-label"
                                    >
                                        Jenis Rapat
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('meeting_type') is-invalid @enderror"
                                        id="meeting_type"
                                        name="meeting_type"
                                        placeholder="Contoh: Rapat Koordinasi"
                                        value="{{ old('meeting_type', $meetingMinute->meeting_type) }}"
                                    >
                                    @error('meeting_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Leader --}}
                                <div class="col-md-4 mb-3">
                                    <label
                                        for="leader"
                                        class="form-label"
                                    >
                                        Pimpinan Rapat
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('leader') is-invalid @enderror"
                                        id="leader"
                                        name="leader"
                                        placeholder="Nama pimpinan rapat"
                                        value="{{ old('leader', $meetingMinute->leader) }}"
                                    >
                                    @error('leader')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Invited Count --}}
                                <div class="col-md-4 mb-3">
                                    <label
                                        for="invited_count"
                                        class="form-label"
                                    >
                                        Jumlah Undangan
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control @error('invited_count') is-invalid @enderror"
                                        id="invited_count"
                                        name="invited_count"
                                        placeholder="0"
                                        min="0"
                                        value="{{ old('invited_count', $meetingMinute->invited_count) }}"
                                    >
                                    @error('invited_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Attended Count --}}
                                <div class="col-md-12 mb-3">
                                    <label
                                        for="attended_count"
                                        class="form-label"
                                    >
                                        Jumlah Kehadiran
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control @error('attended_count') is-invalid @enderror"
                                        id="attended_count"
                                        name="attended_count"
                                        placeholder="0"
                                        min="0"
                                        value="{{ old('attended_count', $meetingMinute->attended_count) }}"
                                    >
                                    @error('attended_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Agenda --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="agenda"
                                        class="form-label"
                                    >
                                        Agenda Rapat
                                    </label>
                                    <textarea
                                        class="form-control @error('agenda') is-invalid @enderror"
                                        id="agenda"
                                        name="agenda"
                                        rows="3"
                                        placeholder="Agenda atau topik yang dibahas"
                                    >{{ old('agenda', $meetingMinute->agenda) }}</textarea>
                                    @error('agenda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Discussion --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="discussion"
                                        class="form-label"
                                    >
                                        Pembahasan
                                    </label>
                                    <textarea
                                        class="form-control @error('discussion') is-invalid @enderror"
                                        id="discussion"
                                        name="discussion"
                                        rows="3"
                                        placeholder="Pembahasan dalam rapat"
                                    >{{ old('discussion', $meetingMinute->discussion) }}</textarea>
                                    @error('discussion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Conclusion --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="conclusion"
                                        class="form-label"
                                    >
                                        Kesimpulan
                                    </label>
                                    <textarea
                                        class="form-control @error('conclusion') is-invalid @enderror"
                                        id="conclusion"
                                        name="conclusion"
                                        rows="3"
                                        placeholder="Kesimpulan rapat"
                                    >{{ old('conclusion', $meetingMinute->conclusion) }}</textarea>
                                    @error('conclusion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Follow Up --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="follow_up"
                                        class="form-label"
                                    >
                                        Tindak Lanjut
                                    </label>
                                    <textarea
                                        class="form-control @error('follow_up') is-invalid @enderror"
                                        id="follow_up"
                                        name="follow_up"
                                        rows="3"
                                        placeholder="Tindak lanjut yang perlu dilakukan"
                                    >{{ old('follow_up', $meetingMinute->follow_up) }}</textarea>
                                    @error('follow_up')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a
                                    href="{{ route('admin.meeting-minutes.show', $meetingMinute->id) }}"
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
