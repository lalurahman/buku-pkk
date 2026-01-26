@extends('layouts.admin')

@section('title', 'Edit Surat Masuk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('admin.incoming-letters.show', $incomingLetter->id) }}"
                        class="text-muted me-2"
                    >
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h4 class="mb-0">Edit Surat Masuk</h4>
                </div>
                <p class="text-muted mb-0">Edit informasi surat {{ $incomingLetter->letter_number }}</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-2">
                <a
                    href="{{ route('admin.incoming-letters.show', $incomingLetter->id) }}"
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
                            Form Edit Surat Masuk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.incoming-letters.update', $incomingLetter->id) }}"
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
                                        placeholder="Contoh: 001/SM/I/2026"
                                        value="{{ old('letter_number', $incomingLetter->letter_number) }}"
                                        required
                                    >
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Diterima --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="received_date"
                                        class="form-label"
                                    >
                                        Tanggal Diterima <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('received_date') is-invalid @enderror"
                                        id="received_date"
                                        name="received_date"
                                        value="{{ old('received_date', $incomingLetter->received_date) }}"
                                        required
                                    >
                                    @error('received_date')
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
                                        value="{{ old('letter_date', $incomingLetter->letter_date) }}"
                                        required
                                    >
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pengirim --}}
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="sender"
                                        class="form-label"
                                    >
                                        Pengirim <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('sender') is-invalid @enderror"
                                        id="sender"
                                        name="sender"
                                        placeholder="Nama pengirim surat"
                                        value="{{ old('sender', $incomingLetter->sender) }}"
                                        required
                                    >
                                    @error('sender')
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
                                    >{{ old('subject', $incomingLetter->subject) }}</textarea>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- File Lampiran Saat Ini --}}
                                @if ($incomingLetter->file)
                                    <div class="col-12 mb-3">
                                        <label class="form-label">File Lampiran Saat Ini</label>
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class='bx bx-file me-2'></i>
                                            <div class="flex-grow-1">
                                                <strong>{{ basename($incomingLetter->file) }}</strong>
                                                <small class="d-block text-muted">
                                                    {{ strtoupper(pathinfo($incomingLetter->file, PATHINFO_EXTENSION)) }}
                                                </small>
                                            </div>
                                            <a
                                                href="{{ Storage::url($incomingLetter->file) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-primary ms-2"
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
                                        {{ $incomingLetter->file ? 'Upload File Baru (Opsional)' : 'File Lampiran' }}
                                    </label>
                                    <input
                                        type="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        id="file"
                                        name="file"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    >
                                    <small class="text-muted">Format: PDF, DOC, DOCX, JPG, JPEG, PNG. Max: 5MB</small>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Disposisi Surat --}}
                                <div class="col-12 mb-3">
                                    <hr class="my-4">
                                    <h6 class="mb-3">
                                        <i class='bx bx-list-ul me-2'></i>
                                        Disposisi Surat
                                    </h6>
                                    <div id="dispositions-container">
                                        @forelse(old('dispositions', $incomingLetter->letterDispositions) as $index => $disposition)
                                            <div class="disposition-item border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Tujuan Disposisi</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="dispositions[{{ $index }}][disposition_to]"
                                                            value="{{ is_array($disposition) ? $disposition['disposition_to'] ?? '' : $disposition->disposition_to ?? '' }}"
                                                            placeholder="Nama tujuan disposisi"
                                                        >
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Tanggal Disposisi</label>
                                                        <input
                                                            type="date"
                                                            class="form-control"
                                                            name="dispositions[{{ $index }}][disposition_date]"
                                                            value="{{ is_array($disposition) ? $disposition['disposition_date'] ?? '' : $disposition->disposition_date ?? '' }}"
                                                        >
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Prioritas</label>
                                                        <select
                                                            class="form-select"
                                                            name="dispositions[{{ $index }}][priority]"
                                                        >
                                                            @php
                                                                $priority = is_array($disposition)
                                                                    ? $disposition['priority'] ?? 'normal'
                                                                    : $disposition->priority ?? 'normal';
                                                            @endphp
                                                            <option
                                                                value="normal"
                                                                {{ $priority == 'normal' ? 'selected' : '' }}
                                                            >Normal</option>
                                                            <option
                                                                value="important"
                                                                {{ $priority == 'important' ? 'selected' : '' }}
                                                            >Penting</option>
                                                            <option
                                                                value="urgent"
                                                                {{ $priority == 'urgent' ? 'selected' : '' }}
                                                            >Segera</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Dari</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="dispositions[{{ $index }}][from]"
                                                            value="{{ is_array($disposition) ? $disposition['from'] ?? '' : $disposition->from ?? '' }}"
                                                            placeholder="Ketua TP PKK"
                                                        >
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-end h-100">
                                                            @if ($index == 0)
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-primary w-100"
                                                                    onclick="addDisposition()"
                                                                >
                                                                    <i class='bx bx-plus'></i> Tambah Disposisi
                                                                </button>
                                                            @else
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-danger w-100"
                                                                    onclick="removeDisposition(this)"
                                                                >
                                                                    <i class='bx bx-trash'></i> Hapus Disposisi
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Instruksi</label>
                                                        <textarea
                                                            class="form-control"
                                                            name="dispositions[{{ $index }}][instructions]"
                                                            rows="2"
                                                            placeholder="Instruksi disposisi"
                                                        >{{ is_array($disposition) ? $disposition['instructions'] ?? '' : $disposition->instructions ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="disposition-item border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Tujuan Disposisi</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="dispositions[0][disposition_to]"
                                                            placeholder="Nama tujuan disposisi"
                                                        >
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Tanggal Disposisi</label>
                                                        <input
                                                            type="date"
                                                            class="form-control"
                                                            name="dispositions[0][disposition_date]"
                                                        >
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Prioritas</label>
                                                        <select
                                                            class="form-select"
                                                            name="dispositions[0][priority]"
                                                        >
                                                            <option value="normal">Normal</option>
                                                            <option value="important">Penting</option>
                                                            <option value="urgent">Segera</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Dari</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="dispositions[0][from]"
                                                            placeholder="Ketua TP PKK"
                                                        >
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-end h-100">
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary w-100"
                                                                onclick="addDisposition()"
                                                            >
                                                                <i class='bx bx-plus'></i> Tambah Disposisi
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Instruksi</label>
                                                        <textarea
                                                            class="form-control"
                                                            name="dispositions[0][instructions]"
                                                            rows="2"
                                                            placeholder="Instruksi disposisi"
                                                        ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
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
                                            {{ old('has_attachment', $incomingLetter->has_attachment) ? 'checked' : '' }}
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
                                    href="{{ route('admin.incoming-letters.show', $incomingLetter->id) }}"
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
        let dispositionIndex = {{ count(old('dispositions', $incomingLetter->letterDispositions)) }};

        function addDisposition() {
            const container = document.getElementById('dispositions-container');
            const newDisposition = document.createElement('div');
            newDisposition.className = 'disposition-item border p-3 mb-3 rounded';
            newDisposition.innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tujuan Disposisi</label>
                        <input
                            type="text"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][disposition_to]"
                            placeholder="Nama tujuan disposisi"
                        >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Disposisi</label>
                        <input
                            type="date"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][disposition_date]"
                        >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prioritas</label>
                        <select class="form-select" name="dispositions[${dispositionIndex}][priority]">
                            <option value="normal">Normal</option>
                            <option value="important">Penting</option>
                            <option value="urgent">Segera</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dari</label>
                        <input
                            type="text"
                            class="form-control"
                            name="dispositions[${dispositionIndex}][from]"
                            placeholder="Ketua TP PKK"
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-end h-100">
                            <button
                                type="button"
                                class="btn btn-danger w-100"
                                onclick="removeDisposition(this)"
                            >
                                <i class='bx bx-trash'></i> Hapus Disposisi
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Instruksi</label>
                        <textarea
                            class="form-control"
                            name="dispositions[${dispositionIndex}][instructions]"
                            rows="2"
                            placeholder="Instruksi disposisi"
                        ></textarea>
                    </div>
                </div>
            `;
            container.appendChild(newDisposition);
            dispositionIndex++;
        }

        function removeDisposition(button) {
            button.closest('.disposition-item').remove();
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
