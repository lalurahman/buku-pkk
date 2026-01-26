@extends('layouts.admin')

@section('title', 'Data Kader')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Data Kader</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addMemberModal"
                >
                    <i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Members -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1">Total Kader</span>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">{{ number_format($totalMembers) }}</h3>
                                </div>
                                <small class="text-success">
                                    <i class='bx bx-user-check'></i>
                                    {{ number_format($activeMembers) }} Aktif
                                </small>
                            </div>
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-group bx-md'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Functional Position Stats -->
            @foreach ($memberStats as $stat)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-muted d-block mb-1">{{ $stat->name }}</span>
                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 me-2">{{ number_format($stat->members_count) }}</h3>
                                    </div>
                                    <small class="text-muted">Kader</small>
                                </div>
                                <div class="avatar flex-shrink-0">
                                    <span
                                        class="avatar-initial rounded 
                                        @if ($loop->index == 0) bg-label-success
                                        @elseif($loop->index == 1) bg-label-warning
                                        @else bg-label-info @endif"
                                    >
                                        <i class='bx bx-badge-check bx-md'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- table -->
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Filter Jabatan Fungsional</label>
                        <select
                            id="functional_position_filter"
                            class="form-select"
                        >
                            <option value="all">Semua Jabatan</option>
                            @foreach ($functionalPositions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
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
        id="addMemberModal"
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
                        id="addMemberModalLabel1"
                    >Tambah Data Kader</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('admin.members.store') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label
                                    for="name"
                                    class="form-label"
                                >Nama Lengkap <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label
                                    for="registration_number"
                                    class="form-label"
                                >Nomor Registrasi <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('registration_number') is-invalid @enderror"
                                    id="registration_number"
                                    name="registration_number"
                                    placeholder="PKK-0001-2026"
                                    value="{{ old('registration_number') }}"
                                    required
                                >
                                @error('registration_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jabatan/Role --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="member_role_id"
                                    class="form-label"
                                >Jabatan di PKK<span class="text-danger">*</span></label>
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
                                            {{ old('member_role_id') == $role->id ? 'selected' : '' }}
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
                                >Jabatan Fungsional <span class="text-danger">*</span></label>
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
                                            {{ old('functional_position_id') == $position->id ? 'selected' : '' }}
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
                                >Tanggal Lahir</label>
                                <input
                                    type="date"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    id="date_of_birth"
                                    name="date_of_birth"
                                    value="{{ old('date_of_birth') }}"
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
                                >Status Pernikahan</label>
                                <select
                                    class="form-select @error('marital_status') is-invalid @enderror"
                                    id="marital_status"
                                    name="marital_status"
                                >
                                    <option value="">Pilih Status</option>
                                    <option
                                        value="Belum Menikah"
                                        {{ old('marital_status') == 'Belum Menikah' ? 'selected' : '' }}
                                    >Belum Menikah</option>
                                    <option
                                        value="Menikah"
                                        {{ old('marital_status') == 'Menikah' ? 'selected' : '' }}
                                    >Menikah</option>
                                    <option
                                        value="Cerai Hidup"
                                        {{ old('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}
                                    >Cerai Hidup</option>
                                    <option
                                        value="Cerai Mati"
                                        {{ old('marital_status') == 'Cerai Mati' ? 'selected' : '' }}
                                    >Cerai Mati</option>
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
                                >Nomor Telepon</label>
                                <input
                                    type="text"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number"
                                    name="phone_number"
                                    placeholder="08123456789"
                                    value="{{ old('phone_number') }}"
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
                                >Pendidikan</label>
                                <select
                                    class="form-select @error('education') is-invalid @enderror"
                                    id="education"
                                    name="education"
                                >
                                    <option value="">Pilih Pendidikan</option>
                                    <option
                                        value="SMA"
                                        {{ old('education') == 'SMA' ? 'selected' : '' }}
                                    >SMA</option>
                                    <option
                                        value="D3"
                                        {{ old('education') == 'D3' ? 'selected' : '' }}
                                    >D3</option>
                                    <option
                                        value="S1"
                                        {{ old('education') == 'S1' ? 'selected' : '' }}
                                    >S1</option>
                                    <option
                                        value="S2"
                                        {{ old('education') == 'S2' ? 'selected' : '' }}
                                    >S2</option>
                                    <option
                                        value="S3"
                                        {{ old('education') == 'S3' ? 'selected' : '' }}
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
                                >Pekerjaan</label>
                                <input
                                    type="text"
                                    class="form-control @error('job') is-invalid @enderror"
                                    id="job"
                                    name="job"
                                    placeholder="Masukkan pekerjaan"
                                    value="{{ old('job') }}"
                                >
                                @error('job')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Posisi/Jabatan di Masyarakat --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    for="position"
                                    class="form-label"
                                >Jabatan</label>
                                <input
                                    type="text"
                                    class="form-control @error('position') is-invalid @enderror"
                                    id="position"
                                    name="position"
                                    placeholder="PNS, PPPK, dll."
                                    value="{{ old('position') }}"
                                >
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-12 mb-3">
                                <label
                                    for="address"
                                    class="form-label"
                                >Alamat</label>
                                <textarea
                                    class="form-control @error('address') is-invalid @enderror"
                                    id="address"
                                    name="address"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap"
                                >{{ old('address') }}</textarea>
                                @error('address')
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
            var table = $('#member-table').DataTable();

            // Filter berdasarkan functional position
            $('#functional_position_filter').on('change', function() {
                table.ajax.url('{{ route('admin.members.index') }}?functional_position_id=' + this.value)
                    .load();
            });
        });
    </script>
@endpush
