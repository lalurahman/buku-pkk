@extends('layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Inventaris</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addInventoryModal"
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
        id="addInventoryModal"
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
                        id="addInventoryModalLabel"
                    >Tambah Data Inventaris</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.inventories.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="name"
                                    class="form-label"
                                >
                                    Nama Barang <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Nama barang inventaris"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Source --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="source"
                                    class="form-label"
                                >
                                    Sumber <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('source') is-invalid @enderror"
                                    id="source"
                                    name="source"
                                    placeholder="Sumber perolehan barang"
                                    value="{{ old('source') }}"
                                    required
                                >
                                @error('source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Received Date --}}
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

                            {{-- Purchase Date --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="purchase_date"
                                    class="form-label"
                                >
                                    Tanggal Pembelian <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('purchase_date') is-invalid @enderror"
                                    id="purchase_date"
                                    name="purchase_date"
                                    value="{{ old('purchase_date') }}"
                                    required
                                >
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-4 mb-3">
                                <label
                                    for="quantity"
                                    class="form-label"
                                >
                                    Jumlah <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity"
                                    name="quantity"
                                    placeholder="0"
                                    min="1"
                                    value="{{ old('quantity') }}"
                                    required
                                >
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Storage Location --}}
                            <div class="col-md-4 mb-3">
                                <label
                                    for="storage_location"
                                    class="form-label"
                                >
                                    Lokasi Penyimpanan <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('storage_location') is-invalid @enderror"
                                    id="storage_location"
                                    name="storage_location"
                                    placeholder="Lokasi barang disimpan"
                                    value="{{ old('storage_location') }}"
                                    required
                                >
                                @error('storage_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Condition --}}
                            <div class="col-md-4 mb-3">
                                <label
                                    for="condition"
                                    class="form-label"
                                >
                                    Kondisi <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-select @error('condition') is-invalid @enderror"
                                    id="condition"
                                    name="condition"
                                    required
                                >
                                    <option value="">Pilih Kondisi</option>
                                    <option
                                        value="Baik"
                                        {{ old('condition') == 'Baik' ? 'selected' : '' }}
                                    >Baik</option>
                                    <option
                                        value="Rusak Ringan"
                                        {{ old('condition') == 'Rusak Ringan' ? 'selected' : '' }}
                                    >Rusak Ringan</option>
                                    <option
                                        value="Rusak Berat"
                                        {{ old('condition') == 'Rusak Berat' ? 'selected' : '' }}
                                    >Rusak Berat</option>
                                </select>
                                @error('condition')
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
