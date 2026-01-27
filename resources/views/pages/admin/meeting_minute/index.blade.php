@extends('layouts.admin')

@section('title', 'Data Notulensi Rapat')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Notulensi Rapat</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addMeetingMinutes"
                >
                    <i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
        <!-- end table -->
    </div>
@endsection

@push('modal')
    <div
        class="modal fade"
        id="addMeetingMinutes"
        tabindex="-1"
        style="display: none;"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="addMeetingMinutesLabel"
                    >Tambah Data Notulensi Rapat</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.meeting-minutes.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
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
                                    value="{{ old('meeting_date') }}"
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
                                    value="{{ old('location') }}"
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
                                    value="{{ old('start_time') }}"
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
                                    value="{{ old('end_time') }}"
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
                                    value="{{ old('meeting_type') }}"
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
                                    value="{{ old('leader') }}"
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
                                    value="{{ old('invited_count') }}"
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
                                    value="{{ old('attended_count') }}"
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
                                >{{ old('agenda') }}</textarea>
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
                                >{{ old('discussion') }}</textarea>
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
                                >{{ old('conclusion') }}</textarea>
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
                                >{{ old('follow_up') }}</textarea>
                                @error('follow_up')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                        >Close</button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('admin/datatables/datatables-bootstrap5.js') }}"></script>
@endpush
