@extends('layouts.admin')

@section('title', 'Edit Data Keuangan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.cash-flows.show', $cashFlow->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Data Keuangan</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi data keuangan {{ $cashFlow->receipt_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.cash-flows.show', $cashFlow->id) }}"
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
                            Form Edit Data Keuangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.cash-flows.update', $cashFlow->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Type --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="type"
                                        class="form-label"
                                    >
                                        Tipe <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required
                                    >
                                        <option value="">Pilih Tipe</option>
                                        <option
                                            value="income"
                                            {{ old('type', $cashFlow->type) == 'income' ? 'selected' : '' }}
                                        >Pemasukan</option>
                                        <option
                                            value="expense"
                                            {{ old('type', $cashFlow->type) == 'expense' ? 'selected' : '' }}
                                        >Pengeluaran</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Source Fund --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="source_fund_id"
                                        class="form-label"
                                    >
                                        Sumber Dana <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select @error('source_fund_id') is-invalid @enderror"
                                        id="source_fund_id"
                                        name="source_fund_id"
                                        required
                                    >
                                        <option value="">Pilih Sumber Dana</option>
                                        @foreach ($sourceFunds as $fund)
                                            <option
                                                value="{{ $fund->id }}"
                                                {{ old('source_fund_id', $cashFlow->source_fund_id) == $fund->id ? 'selected' : '' }}
                                            >
                                                {{ $fund->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('source_fund_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="date"
                                        class="form-label"
                                    >
                                        Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        id="date"
                                        name="date"
                                        value="{{ old('date', $cashFlow->date) }}"
                                        required
                                    >
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="amount"
                                        class="form-label"
                                    >
                                        Jumlah (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        id="amount"
                                        name="amount"
                                        placeholder="0"
                                        step="0.01"
                                        min="0"
                                        value="{{ old('amount', $cashFlow->amount) }}"
                                        required
                                    >
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="description"
                                        class="form-label"
                                    >
                                        Keterangan
                                    </label>
                                    <textarea
                                        class="form-control @error('description') is-invalid @enderror"
                                        id="description"
                                        name="description"
                                        rows="3"
                                        placeholder="Keterangan tambahan (opsional)"
                                    >{{ old('description', $cashFlow->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a
                                    href="{{ route('admin.cash-flows.show', $cashFlow->id) }}"
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
