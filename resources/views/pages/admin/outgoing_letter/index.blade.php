@extends('layouts.admin')

@section('title', 'Data Surat Keluar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Surat Keluar</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addOutgoingLetterModal"
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
        id="addOutgoingLetterModal"
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
                        id="addOutgoingLetterModalLabel1"
                    >Tambah Data Surat Keluar</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.outgoing-letters.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            {{-- Nomor Surat --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="letter_number"
                                    class="form-label"
                                >
                                    Nomor Surat <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('letter_number') is-invalid @enderror"
                                    id="letter_number"
                                    name="letter_number"
                                    placeholder="Contoh: 001/SK/I/2026"
                                    value="{{ old('letter_number') }}"
                                    required
                                >
                                @error('letter_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Surat --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="letter_date"
                                    class="form-label"
                                >
                                    Tanggal Surat <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('letter_date') is-invalid @enderror"
                                    id="letter_date"
                                    name="letter_date"
                                    value="{{ old('letter_date') }}"
                                    required
                                >
                                @error('letter_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penerima --}}
                            <div class="col-12 mb-3">
                                <label
                                    for="recipient"
                                    class="form-label"
                                >
                                    Penerima <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('recipient') is-invalid @enderror"
                                    id="recipient"
                                    name="recipient"
                                    placeholder="Nama penerima surat"
                                    value="{{ old('recipient') }}"
                                    required
                                >
                                @error('recipient')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Perihal --}}
                            <div class="col-12 mb-3">
                                <label
                                    for="subject"
                                    class="form-label"
                                >
                                    Perihal <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    class="form-control @error('subject') is-invalid @enderror"
                                    id="subject"
                                    name="subject"
                                    rows="3"
                                    placeholder="Perihal surat"
                                    required
                                >{{ old('subject') }}</textarea>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- File Lampiran --}}
                            <div class="col-12 mb-3">
                                <label
                                    for="file"
                                    class="form-label"
                                >
                                    File Lampiran
                                </label>
                                <input
                                    type="file"
                                    class="form-control @error('file') is-invalid @enderror"
                                    id="file"
                                    name="file"
                                    accept=".pdf"
                                >
                                <small class="text-muted">Format: PDF, Max: 5MB</small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tembusan (CC) --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Tembusan (CC)
                                </label>
                                <div id="cc-recipients-container">
                                    <div class="input-group mb-2">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="cc_recipients[]"
                                            placeholder="Nama penerima tembusan"
                                        >
                                        <button
                                            type="button"
                                            class="btn btn-success"
                                            onclick="addCcRecipient()"
                                        >
                                            <i class='bx bx-plus'></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Klik tombol + untuk menambah penerima tembusan</small>
                            </div>

                            {{-- Has Attachment --}}
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="has_attachment"
                                        name="has_attachment"
                                        value="1"
                                        {{ old('has_attachment') ? 'checked' : '' }}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="has_attachment"
                                    >
                                        Surat memiliki lampiran ?
                                    </label>
                                </div>
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
    <script>
        function addCcRecipient() {
            const container = document.getElementById('cc-recipients-container');
            const newInput = document.createElement('div');
            newInput.className = 'input-group mb-2';
            newInput.innerHTML = `
                <input
                    type="text"
                    class="form-control"
                    name="cc_recipients[]"
                    placeholder="Nama penerima tembusan"
                >
                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="removeCcRecipient(this)"
                >
                    <i class='bx bx-trash'></i>
                </button>
            `;
            container.appendChild(newInput);
        }

        function removeCcRecipient(button) {
            button.closest('.input-group').remove();
        }
    </script>
@endpush
