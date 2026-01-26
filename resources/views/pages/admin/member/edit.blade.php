@extends('layouts.admin')

@section('title', 'Edit Kader')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.members.show', $member->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Kader</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi kader {{ $member->name }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.members.show', $member->id) }}"
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
                            Form Edit Kader
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.members.update', $member->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Nama Lengkap --}}
                                <div class="col-md-6 mb-3">
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
                                        placeholder="Masukkan nama lengkap"
                                        value="{{ old('name', $member->name) }}"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Registrasi --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="registration_number"
                                        class="form-label"
                                    >
                                        Nomor Registrasi
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="registration_number"
                                        name="registration_number"
                                        value="{{ old('registration_number', $member->registration_number) }}"
                                    >
                                </div>

                                {{-- Jabatan di PKK --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="member_role_id"
                                        class="form-label"
                                    >
                                        Jabatan di PKK <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select @error('member_role_id') is-invalid @enderror"
                                        id="member_role_id"
                                        name="member_role_id"
                                        required
                                    >
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($memberRoles as $role)
                                            <option
                                                value="{{ $role->id }}"
                                                {{ old('member_role_id', $member->member_role_id) == $role->id ? 'selected' : '' }}
                                            >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('member_role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jabatan Fungsional --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="functional_position_id"
                                        class="form-label"
                                    >
                                        Jabatan Fungsional <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select @error('functional_position_id') is-invalid @enderror"
                                        id="functional_position_id"
                                        name="functional_position_id"
                                        required
                                    >
                                        <option value="">Pilih Jabatan Fungsional</option>
                                        @foreach ($functionalPositions as $position)
                                            <option
                                                value="{{ $position->id }}"
                                                {{ old('functional_position_id', $member->functional_position_id) == $position->id ? 'selected' : '' }}
                                            >
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('functional_position_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="date_of_birth"
                                        class="form-label"
                                    >
                                        Tanggal Lahir
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth', $member->date_of_birth) }}"
                                    >
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Pernikahan --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="marital_status"
                                        class="form-label"
                                    >
                                        Status Pernikahan
                                    </label>
                                    <select
                                        class="form-select @error('marital_status') is-invalid @enderror"
                                        id="marital_status"
                                        name="marital_status"
                                    >
                                        <option value="">Pilih Status</option>
                                        <option
                                            value="Belum Menikah"
                                            {{ old('marital_status', $member->marital_status) == 'Belum Menikah' ? 'selected' : '' }}
                                        >
                                            Belum Menikah
                                        </option>
                                        <option
                                            value="Menikah"
                                            {{ old('marital_status', $member->marital_status) == 'Menikah' ? 'selected' : '' }}
                                        >
                                            Menikah
                                        </option>
                                        <option
                                            value="Cerai Hidup"
                                            {{ old('marital_status', $member->marital_status) == 'Cerai Hidup' ? 'selected' : '' }}
                                        >
                                            Cerai Hidup
                                        </option>
                                        <option
                                            value="Cerai Mati"
                                            {{ old('marital_status', $member->marital_status) == 'Cerai Mati' ? 'selected' : '' }}
                                        >
                                            Cerai Mati
                                        </option>
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Telepon --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="phone_number"
                                        class="form-label"
                                    >
                                        Nomor Telepon
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        id="phone_number"
                                        name="phone_number"
                                        placeholder="08123456789"
                                        value="{{ old('phone_number', $member->phone_number) }}"
                                    >
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pendidikan --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="education"
                                        class="form-label"
                                    >
                                        Pendidikan
                                    </label>
                                    <select
                                        class="form-select @error('education') is-invalid @enderror"
                                        id="education"
                                        name="education"
                                    >
                                        <option value="">Pilih Pendidikan</option>
                                        <option
                                            value="SD"
                                            {{ old('education', $member->education) == 'SD' ? 'selected' : '' }}
                                        >SD</option>
                                        <option
                                            value="SMP"
                                            {{ old('education', $member->education) == 'SMP' ? 'selected' : '' }}
                                        >SMP</option>
                                        <option
                                            value="SMA"
                                            {{ old('education', $member->education) == 'SMA' ? 'selected' : '' }}
                                        >SMA</option>
                                        <option
                                            value="D3"
                                            {{ old('education', $member->education) == 'D3' ? 'selected' : '' }}
                                        >D3</option>
                                        <option
                                            value="S1"
                                            {{ old('education', $member->education) == 'S1' ? 'selected' : '' }}
                                        >S1</option>
                                        <option
                                            value="S2"
                                            {{ old('education', $member->education) == 'S2' ? 'selected' : '' }}
                                        >S2</option>
                                        <option
                                            value="S3"
                                            {{ old('education', $member->education) == 'S3' ? 'selected' : '' }}
                                        >S3</option>
                                    </select>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pekerjaan --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="job"
                                        class="form-label"
                                    >
                                        Pekerjaan
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('job') is-invalid @enderror"
                                        id="job"
                                        name="job"
                                        placeholder="Masukkan pekerjaan"
                                        value="{{ old('job', $member->job) }}"
                                    >
                                    @error('job')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="address"
                                        class="form-label"
                                    >
                                        Alamat
                                    </label>
                                    <textarea
                                        class="form-control @error('address') is-invalid @enderror"
                                        id="address"
                                        name="address"
                                        rows="3"
                                        placeholder="Masukkan alamat lengkap"
                                    >{{ old('address', $member->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a
                                    href="{{ route('admin.members.show', $member->id) }}"
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-format phone number
            const phoneInput = document.getElementById('phone_number');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                });
            }

            // Form validation feedback
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
                        alert('Mohon lengkapi semua field yang wajib diisi.');
                    }
                });
            }
        });
    </script>
@endpush
