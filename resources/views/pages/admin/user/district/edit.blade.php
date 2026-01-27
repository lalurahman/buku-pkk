@extends('layouts.admin')

@section('title', 'Edit Akun Kecamatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Edit Akun Kecamatan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.districts.index') }}">Akun Kecamatan</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.districts.show', $user->id) }}">Detail</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Alert Messages --}}
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
                <h5 class="card-title mb-4">Form Edit Akun</h5>

                <form
                    action="{{ route('admin.user.districts.update', $user->id) }}"
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
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                placeholder="Nama lengkap"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label
                                for="email"
                                class="form-label"
                            >
                                Email <span class="text-danger">*</span>
                            </label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="email@example.com"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6 mb-3">
                            <label
                                for="password"
                                class="form-label"
                            >
                                Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Password baru"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="col-md-6 mb-3">
                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Konfirmasi Password Baru
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Konfirmasi password baru"
                            >
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a
                            href="{{ route('admin.user.districts.show', $user->id) }}"
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
