@extends('layouts.district')

@section('title', 'Daftar Desa/Kelurahan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible"
                role="alert"
            >
                {{ session('success') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible"
                role="alert"
            >
                {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Daftar Desa/Kelurahan</h4>
                <p class="text-muted mb-0">Daftar desa/kelurahan di kecamatan Anda</p>
            </div>
        </div>

        <!-- Village List Card -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    {{ $dataTable->table(['class' => 'table table-hover']) }}
                </div>
            </div>
        </div>
        <!--/ Village List Card -->
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
