@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.outgoing-letters.show', $outgoingLetter->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Surat Keluar</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi surat {{ $outgoingLetter->letter_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.outgoing-letters.show', $outgoingLetter->id) }}"
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
                            Form Edit Surat Keluar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.outgoing-letters.update', $outgoingLetter->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Nomor Surat --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="letter_number"
                                        class="form-label"
                                    >
                                        Nomor Surat <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('letter_number') is-invalid @enderror"
                                        id="letter_number"
                                        name="letter_number"
                                        placeholder="Contoh: 001/SK/I/2026"
                                        value="{{ old('letter_number', $outgoingLetter->letter_number) }}"
                                        required
                                    >
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Surat --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="letter_date"
                                        class="form-label"
                                    >
                                        Tanggal Surat <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('letter_date') is-invalid @enderror"
                                        id="letter_date"
                                        name="letter_date"
                                        value="{{ old('letter_date', $outgoingLetter->letter_date) }}"
                                        required
                                    >
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Penerima --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="recipient"
                                        class="form-label"
                                    >
                                        Penerima <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('recipient') is-invalid @enderror"
                                        id="recipient"
                                        name="recipient"
                                        placeholder="Nama penerima surat"
                                        value="{{ old('recipient', $outgoingLetter->recipient) }}"
                                        required
                                    >
                                    @error('recipient')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Perihal --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="subject"
                                        class="form-label"
                                    >
                                        Perihal <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        class="form-control @error('subject') is-invalid @enderror"
                                        id="subject"
                                        name="subject"
                                        rows="3"
                                        placeholder="Perihal surat"
                                        required
                                    >{{ old('subject', $outgoingLetter->subject) }}</textarea>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- File Lampiran Saat Ini --}}
                                @if ($outgoingLetter->file)
                                    <div class="col-12 mb-3">
                                        <label class="form-label">File Lampiran Saat Ini</label>
                                        <div class="alert alert-success d-flex align-items-center">
                                            <i class='bx bx-file me-2'></i>
                                            <div class="flex-grow-1">
                                                <strong>{{ basename($outgoingLetter->file) }}</strong>
                                                <small class="d-block text-muted">
                                                    {{ strtoupper(pathinfo($outgoingLetter->file, PATHINFO_EXTENSION)) }}
                                                </small>
                                            </div>
                                            <a
                                                href="{{ Storage::url($outgoingLetter->file) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-success ms-2"
                                            >
                                                <i class='bx bx-show'></i> Lihat File
                                            </a>
                                        </div>
                                        <small class="text-muted">Upload file baru jika ingin mengganti file yang
                                            ada</small>
                                    </div>
                                @endif

                                {{-- Upload File Baru --}}
                                <div class="col-12 mb-3">
                                    <label
                                        for="file"
                                        class="form-label"
                                    >
                                        {{ $outgoingLetter->file ? 'Upload File Baru (Opsional)' : 'File Lampiran' }}
                                    </label>
                                    <input
                                        type="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        id="file"
                                        name="file"
                                        accept=".pdf"
                                    >
                                    <small class="text-muted">Format: PDF. Max: 5MB</small>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tembusan (CC) --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Tembusan (CC)
                                    </label>
                                    <div id="cc-recipients-container">
                                        @if ($outgoingLetter->outgoingLetterCcs && $outgoingLetter->outgoingLetterCcs->count() > 0)
                                            @foreach ($outgoingLetter->outgoingLetterCcs as $index => $cc)
                                                <div class="input-group mb-2">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="cc_recipients[]"
                                                        placeholder="Nama penerima tembusan"
                                                        value="{{ old('cc_recipients.' . $index, $cc->cc_recipient) }}"
                                                    >
                                                    @if ($index == 0)
                                                        <button
                                                            type="button"
                                                            class="btn btn-success"
                                                            onclick="addCcRecipient()"
                                                        >
                                                            <i class='bx bx-plus'></i>
                                                        </button>
                                                    @else
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger"
                                                            onclick="removeCcRecipient(this)"
                                                        >
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="cc_recipients[]"
                                                    placeholder="Nama penerima tembusan"
                                                    value="{{ old('cc_recipients.0') }}"
                                                >
                                                <button
                                                    type="button"
                                                    class="btn btn-success"
                                                    onclick="addCcRecipient()"
                                                >
                                                    <i class='bx bx-plus'></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <small class="text-muted">Klik tombol + untuk menambah penerima tembusan</small>
                                </div>

                                {{-- Has Attachment --}}
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="has_attachment"
                                            name="has_attachment"
                                            value="1"
                                            {{ old('has_attachment', $outgoingLetter->has_attachment) ? 'checked' : '' }}
                                        >
                                        <label
                                            class="form-check-label"
                                            for="has_attachment"
                                        >
                                            Surat memiliki lampiran ?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a
                                    href="{{ route('admin.outgoing-letters.show', $outgoingLetter->id) }}"
                                    class="btn btn-label-secondary"
                                >
                                    <i class='bx bx-x me-1'></i>
                                    Batal
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-success"
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
        // Add CC Recipient function
        function addCcRecipient() {
            const container = document.getElementById('cc-recipients-container');
            const newInput = document.createElement('div');
            newInput.className = 'input-group mb-2';
            newInput.innerHTML = `
                <input
                    type="text"
                    class="form-control"
                    name="cc_recipients[]"
                    placeholder="Nama penerima tembusan"
                >
                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="removeCcRecipient(this)"
                >
                    <i class='bx bx-trash'></i>
                </button>
            `;
            container.appendChild(newInput);
        }

        function removeCcRecipient(button) {
            button.closest('.input-group').remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Show file name when file is selected
            const fileInput = document.getElementById('file');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name;
                    if (fileName) {
                        const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
                        console.log(`Selected file: ${fileName} (${fileSize} MB)`);

                        // Validate file size
                        if (fileSize > 5) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 5MB. File yang dipilih: ' + fileSize +
                                    ' MB',
                                confirmButtonColor: '#d33'
                            });
                            e.target.value = '';
                        }
                    }
                });
            }

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
