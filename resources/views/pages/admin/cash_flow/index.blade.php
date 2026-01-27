@extends('layouts.admin')

@section('title', 'Data Keuangan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Keuangan</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addCashFlow"
                >
                    <i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-trending-up bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">Total Pemasukan</small>
                                <h5 class="card-title mb-0 text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class='bx bx-trending-down bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">Total Pengeluaran</small>
                                <h5 class="card-title mb-0 text-danger">Rp {{ number_format($totalExpense, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span
                                    class="avatar-initial rounded {{ $balance >= 0 ? 'bg-label-primary' : 'bg-label-warning' }}"
                                >
                                    <i class='bx bx-wallet bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">Sisa Saldo</small>
                                <h5 class="card-title mb-0 {{ $balance >= 0 ? 'text-primary' : 'text-warning' }}">Rp
                                    {{ number_format($balance, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label
                            for="type-filter"
                            class="form-label"
                        >Tipe Transaksi</label>
                        <select
                            id="type-filter"
                            class="form-select"
                        >
                            <option value="">Semua Transaksi</option>
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>
                </div>
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
        id="addCashFlow"
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
                        id="addCashFlowLabel"
                    >Tambah Data Keuangan</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.cash-flows.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
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
                                        {{ old('type') == 'income' ? 'selected' : '' }}
                                    >Pemasukan</option>
                                    <option
                                        value="expense"
                                        {{ old('type') == 'expense' ? 'selected' : '' }}
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
                                            {{ old('source_fund_id') == $fund->id ? 'selected' : '' }}
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
                            <div class="col-12 col-md-6 mb-3">
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
                                    value="{{ old('date') }}"
                                    required
                                >
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div class="col-12 col-md-6 mb-3">
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
                                    value="{{ old('amount') }}"
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
                                >{{ old('description') }}</textarea>
                                @error('description')
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
    <script>
        $(document).ready(function() {
            // Type filter
            $('#type-filter').on('change', function() {
                window.LaravelDataTables['cashflow-table'].ajax.reload();
            });

            // Override ajax data to include filter
            var table = window.LaravelDataTables['cashflow-table'];
            table.on('preXhr.dt', function(e, settings, data) {
                data.type = $('#type-filter').val();
            });
        });
    </script>
@endpush
