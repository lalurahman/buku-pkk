@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Detail Inventaris</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventories.index') }}">Inventaris</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a
                    href="{{ route('admin.inventories.edit', $inventory->id) }}"
                    class="btn btn-warning"
                >
                    <i class='bx bx-edit'></i> Edit
                </a>
                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="deleteInventory('{{ $inventory->id }}')"
                >
                    <i class='bx bx-trash'></i> Hapus
                </button>
                <a
                    href="{{ route('admin.inventories.index') }}"
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
                <h5 class="card-title mb-4">Informasi Inventaris</h5>

                <div class="row">
                    {{-- Column 1 --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Barang</label>
                            <p class="fw-semibold">{{ $inventory->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Sumber</label>
                            <p class="fw-semibold">{{ $inventory->source }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Tanggal Diterima</label>
                            <p class="fw-semibold">
                                <i class='bx bx-calendar'></i>
                                {{ \Carbon\Carbon::parse($inventory->received_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Tanggal Pembelian</label>
                            <p class="fw-semibold">
                                <i class='bx bx-calendar'></i>
                                {{ \Carbon\Carbon::parse($inventory->purchase_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Jumlah</label>
                            <p class="fw-semibold">{{ number_format($inventory->quantity, 0, ',', '.') }} Unit</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Lokasi Penyimpanan</label>
                            <p class="fw-semibold">
                                <i class='bx bx-map'></i>
                                {{ $inventory->storage_location }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Kondisi</label>
                            <p>
                                @if ($inventory->condition == 'Baik')
                                    <span class="badge bg-success">
                                        <i class='bx bx-check-circle'></i> {{ $inventory->condition }}
                                    </span>
                                @elseif($inventory->condition == 'Rusak Ringan')
                                    <span class="badge bg-warning">
                                        <i class='bx bx-error-circle'></i> {{ $inventory->condition }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class='bx bx-x-circle'></i> {{ $inventory->condition }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Dibuat Pada</label>
                            <p class="fw-semibold">
                                <i class='bx bx-time'></i>
                                {{ $inventory->created_at->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Form --}}
        <form
            id="delete-form-{{ $inventory->id }}"
            action="{{ route('admin.inventories.destroy', $inventory->id) }}"
            method="POST"
            class="d-none"
        >
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteInventory(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data inventaris akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
