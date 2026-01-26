@extends('layouts.admin')

@section('title', 'Data Surat Masuk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Surat Masuk</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addLetterModal"
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
        id="addLetterModal"
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
                        id="addLetterModalLabel"
                    >Tambah Data Surat Masuk</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.incoming-letters.store') }}"
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
                                    placeholder="Contoh: 001/SM/I/2026"
                                    value="{{ old('letter_number') }}"
                                    required
                                >
                                @error('letter_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Diterima --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="received_date"
                                    class="form-label"
                                >
                                    Tanggal Diterima <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('received_date') is-invalid @enderror"
                                    id="received_date"
                                    name="received_date"
                                    value="{{ old('received_date') }}"
                                    required
                                >
                                @error('received_date')
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

                            {{-- Pengirim --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="sender"
                                    class="form-label"
                                >
                                    Pengirim <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('sender') is-invalid @enderror"
                                    id="sender"
                                    name="sender"
                                    placeholder="Nama pengirim surat"
                                    value="{{ old('sender') }}"
                                    required
                                >
                                @error('sender')
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
                                <small class="text-muted">Format: PDF</small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Disposisi Surat --}}
                            <div class="col-12 mb-3">
                                <hr class="my-4">
                                <h6 class="mb-3">
                                    <i class='bx bx-list-ul me-2'></i>
                                    Disposisi Surat
                                </h6>
                                <div id="dispositions-container">
                                    <div class="disposition-item border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tujuan Disposisi</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="dispositions[0][disposition_to]"
                                                    placeholder="Nama tujuan disposisi"
                                                >
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Tanggal Disposisi</label>
                                                <input
                                                    type="date"
                                                    class="form-control"
                                                    name="dispositions[0][disposition_date]"
                                                >
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Prioritas</label>
                                                <select
                                                    class="form-select"
                                                    name="dispositions[0][priority]"
                                                >
                                                    <option value="normal">Normal</option>
                                                    <option value="important">Penting</option>
                                                    <option value="urgent">Segera</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dari</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="dispositions[0][from]"
                                                    placeholder="Ketua TP PKK"
                                                >
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-end h-100">
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary w-100"
                                                        onclick="addDisposition()"
                                                    >
                                                        <i class='bx bx-plus'></i> Tambah Disposisi
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Instruksi</label>
                                                <textarea
                                                    class="form-control"
                                                    name="dispositions[0][instructions]"
                                                    rows="2"
                                                    placeholder="Instruksi disposisi"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        let dispositionIndex = 1;

        function addDisposition() {
            const container = document.getElementById('dispositions-container');
            const newDisposition = document.createElement('div');
            newDisposition.className = 'disposition-item border p-3 mb-3 rounded';
            newDisposition.innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tujuan Disposisi</label>
                        <input
                            type="text"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][disposition_to]"
                            placeholder="Nama tujuan disposisi"
                        >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Disposisi</label>
                        <input
                            type="date"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][disposition_date]"
                        >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prioritas</label>
                        <select class="form-select" name="dispositions[${dispositionIndex}][priority]">
                            <option value="normal">Normal</option>
                            <option value="important">Penting</option>
                            <option value="urgent">Segera</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dari</label>
                        <input
                            type="text"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][from]"
                            placeholder="Ketua TP PKK"
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-end h-100">
                            <button
                                type="button"
                                class="btn btn-danger w-100"
                                onclick="removeDisposition(this)"
                            >
                                <i class='bx bx-trash'></i> Hapus Disposisi
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Instruksi</label>
                        <textarea
                            class="form-control"
                            name="dispositions[${dispositionIndex}][instructions]"
                            rows="2"
                            placeholder="Instruksi disposisi"
                        ></textarea>
                    </div>
                </div>
            `;
            container.appendChild(newDisposition);
            dispositionIndex++;
        }

        function removeDisposition(button) {
            button.closest('.disposition-item').remove();
        }
    </script>
@endpush
