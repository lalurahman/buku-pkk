@extends('layouts.admin')

@section('title', 'Data Buku Tamu')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Buku Tamu</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addGuestBook"
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
        id="addGuestBook"
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
                        id="addGuestBookLabel"
                    >Tambah Data Buku Tamu</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.guest-books.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            {{-- Visitor Name --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="visitor_name"
                                    class="form-label"
                                >
                                    Nama Pengunjung <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('visitor_name') is-invalid @enderror"
                                    id="visitor_name"
                                    name="visitor_name"
                                    placeholder="Nama lengkap pengunjung"
                                    value="{{ old('visitor_name') }}"
                                    required
                                >
                                @error('visitor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visit Date --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="visit_date"
                                    class="form-label"
                                >
                                    Tanggal Kunjungan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('visit_date') is-invalid @enderror"
                                    id="visit_date"
                                    name="visit_date"
                                    value="{{ old('visit_date') }}"
                                    required
                                >
                                @error('visit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Institution --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="institution"
                                    class="form-label"
                                >
                                    Instansi <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('institution') is-invalid @enderror"
                                    id="institution"
                                    name="institution"
                                    placeholder="Nama instansi/organisasi"
                                    value="{{ old('institution') }}"
                                    required
                                >
                                @error('institution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Purpose --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="purpose"
                                    class="form-label"
                                >
                                    Keperluan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('purpose') is-invalid @enderror"
                                    id="purpose"
                                    name="purpose"
                                    placeholder="Tujuan kunjungan"
                                    value="{{ old('purpose') }}"
                                    required
                                >
                                @error('purpose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Impressions --}}
                            <div class="col-12 mb-3">
                                <label
                                    for="impressions"
                                    class="form-label"
                                >
                                    Kesan dan Pesan
                                </label>
                                <textarea
                                    class="form-control @error('impressions') is-invalid @enderror"
                                    id="impressions"
                                    name="impressions"
                                    rows="3"
                                    placeholder="Kesan dan pesan dari kunjungan (opsional)"
                                >{{ old('impressions') }}</textarea>
                                @error('impressions')
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
