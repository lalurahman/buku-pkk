@php
    $role = $user->getRoleNames()->first();
    if ($role == 'Admin') {
        $layout = 'layouts.admin';
        $dashboardRoute = route('admin.dashboard');
    } elseif ($role == 'District') {
        $layout = 'layouts.district';
        $dashboardRoute = route('district.dashboard');
    } elseif ($role == 'Village') {
        $layout = 'layouts.village';
        $dashboardRoute = route('village.dashboard');
    }
@endphp

@extends($layout)

@section('title', 'Profile')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
            <div>
                <h4 class="mb-1">Profile Saya</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ $dashboardRoute }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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

        <div class="row">
            {{-- Profile Information Card --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i
                                        class='bx bx-user'
                                        style="font-size: 3rem;"
                                    ></i>
                                </span>
                            </div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">
                                <i class='bx bx-envelope'></i> {{ $user->email }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-around border-top pt-3 mt-3">
                            <div>
                                <small class="text-muted d-block">Bergabung Sejak</small>
                                <strong>{{ $user->created_at->translatedFormat('d M Y') }}</strong>
                            </div>
                        </div>

                        @if ($user->userHasDistricts->isNotEmpty())
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">Kecamatan</small>
                                @foreach ($user->userHasDistricts as $userDistrict)
                                    <span class="badge bg-primary mb-1">
                                        <i class='bx bx-map'></i> {{ $userDistrict->district->name ?? '-' }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if ($user->userHasVillages->isNotEmpty())
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">Desa</small>
                                @foreach ($user->userHasVillages as $userVillage)
                                    <span class="badge bg-success mb-1">
                                        <i class='bx bx-map'></i> {{ $userVillage->village->name ?? '-' }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Edit Profile Form --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Edit Profile</h5>

                        <form
                            action="{{ route('profile.update', $user->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-12 mb-3">
                                    <label
                                        for="name"
                                        class="form-label"
                                    >
                                        Nama Lengkap <span class="text-danger">*</span>
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
                                <div class="col-md-12 mb-3">
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

                                <div class="col-12">
                                    <hr class="my-4">
                                    <h6 class="text-muted mb-3">Ubah Password</h6>
                                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="password"
                                        class="form-label"
                                    >
                                        Password Baru
                                    </label>
                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Password baru"
                                        autocomplete="new-password"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Minimal 8 karakter</small>
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
                                        autocomplete="new-password"
                                    >
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
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
        </div>
    </div>
@endsection
