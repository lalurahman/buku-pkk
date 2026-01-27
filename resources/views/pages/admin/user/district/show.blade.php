@extends('layouts.admin')

@section('title', 'Detail Akun Kecamatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Detail Akun Kecamatan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.districts.index') }}">Akun Kecamatan</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a
                    href="{{ route('admin.user.districts.edit', $user->id) }}"
                    class="btn btn-warning"
                >
                    <i class='bx bx-edit'></i> Edit
                </a>
                <a
                    href="{{ route('admin.user.districts.index') }}"
                    class="btn btn-secondary"
                >
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
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

        {{-- Main Content --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Akun</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama</label>
                            <p class="fw-semibold">{{ $user->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="fw-semibold">
                                <i class='bx bx-envelope'></i> {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Kecamatan</label>
                            @if ($user->userHasDistricts->isNotEmpty())
                                @foreach ($user->userHasDistricts as $userDistrict)
                                    <p class="mb-1">
                                        <span class="badge bg-primary">
                                            <i class='bx bx-map'></i> {{ $userDistrict->district->name ?? '-' }}
                                        </span>
                                    </p>
                                @endforeach
                            @else
                                <p>-</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Dibuat Pada</label>
                            <p class="fw-semibold">
                                <i class='bx bx-time'></i>
                                {{ $user->created_at->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
