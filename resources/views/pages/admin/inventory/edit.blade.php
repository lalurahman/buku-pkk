@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Edit Inventaris</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventories.index') }}">Inventaris</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.inventories.show', $inventory->id) }}">Detail</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <i class='bx bx-check-circle'></i> {{ session('success') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class='bx bx-error-circle'></i> {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Form Edit Inventaris</h5>

                <form
                    action="{{ route('admin.inventories.update', $inventory->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

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
                                value="{{ old('name', $inventory->name) }}"
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
                                value="{{ old('source', $inventory->source) }}"
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
                                value="{{ old('received_date', $inventory->received_date) }}"
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
                                value="{{ old('purchase_date', $inventory->purchase_date) }}"
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
                                value="{{ old('quantity', $inventory->quantity) }}"
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
                                value="{{ old('storage_location', $inventory->storage_location) }}"
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
                                    {{ old('condition', $inventory->condition) == 'Baik' ? 'selected' : '' }}
                                >Baik</option>
                                <option
                                    value="Rusak Ringan"
                                    {{ old('condition', $inventory->condition) == 'Rusak Ringan' ? 'selected' : '' }}
                                >Rusak Ringan</option>
                                <option
                                    value="Rusak Berat"
                                    {{ old('condition', $inventory->condition) == 'Rusak Berat' ? 'selected' : '' }}
                                >Rusak Berat</option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a
                            href="{{ route('admin.inventories.show', $inventory->id) }}"
                            class="btn btn-secondary"
                        >
                            <i class='bx bx-x'></i> Batal
                        </a>
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class='bx bx-save'></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
