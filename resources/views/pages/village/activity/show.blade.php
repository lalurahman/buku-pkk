@extends('layouts.village')

@section('title', 'Detail Kegiatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6">
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-2">
                    <a
                        href="{{ route('village.activities.index') }}"
                        class="text-muted me-2"
                    >
                        <i class="bx bx-arrow-back"></i>
                    </a>
                    <h4 class="mb-0">Detail Kegiatan</h4>
                </div>
                <p class="text-muted mb-0">Informasi lengkap tentang kegiatan</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-3 mb-4">
                            <i class="bx bx-info-circle text-primary me-2"></i>Informasi Kegiatan
                        </h5>

                        <!-- Judul Kegiatan -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-bookmark"></i>
                                    </span>
                                </div>
                                <h6 class="mb-0">Judul Kegiatan</h6>
                            </div>
                            <div class="ps-5">
                                <p class="mb-0 fw-semibold text-dark">{{ $activity->title }}</p>
                            </div>
                        </div>

                        <!-- Target Kegiatan -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-bullseye"></i>
                                    </span>
                                </div>
                                <h6 class="mb-0">Target Kegiatan</h6>
                            </div>
                            <div class="ps-5">
                                @if ($activity->targetActivities->count() > 0)
                                    <div class="list-group">
                                        @foreach ($activity->targetActivities as $index => $targetActivity)
                                            <div class="list-group-item border-0 px-0 py-2">
                                                <div class="d-flex align-items-start">
                                                    <span
                                                        class="badge bg-success rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px;"
                                                    >
                                                        {{ $index + 1 }}
                                                    </span>
                                                    <span class="text-dark">{{ $targetActivity->title }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mb-0 text-muted">
                                        <i class="bx bx-info-circle me-1"></i>Belum ada target kegiatan
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Inovasi Kegiatan -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="bx bx-bulb"></i>
                                    </span>
                                </div>
                                <h6 class="mb-0">Inovasi Kegiatan</h6>
                            </div>
                            <div class="ps-5">
                                @if ($activity->innovationActivities->count() > 0)
                                    <div class="list-group">
                                        @foreach ($activity->innovationActivities as $index => $innovationActivity)
                                            <div class="list-group-item border-0 px-0 py-2">
                                                <div class="d-flex align-items-start">
                                                    <span
                                                        class="badge bg-info rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px;"
                                                    >
                                                        {{ $index + 1 }}
                                                    </span>
                                                    <span class="text-dark">{{ $innovationActivity->title }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mb-0 text-muted">
                                        <i class="bx bx-info-circle me-1"></i>Belum ada inovasi kegiatan
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Dampak Kegiatan -->
                        <div class="mb-0">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-line-chart"></i>
                                    </span>
                                </div>
                                <h6 class="mb-0">Dampak Kegiatan</h6>
                            </div>
                            <div class="ps-5">
                                @if ($activity->impactActivities->count() > 0)
                                    <div class="list-group">
                                        @foreach ($activity->impactActivities as $index => $impactActivity)
                                            <div class="list-group-item border-0 px-0 py-2">
                                                <div class="d-flex align-items-start">
                                                    <span
                                                        class="badge bg-warning rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px;"
                                                    >
                                                        {{ $index + 1 }}
                                                    </span>
                                                    <span class="text-dark">{{ $impactActivity->title }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mb-0 text-muted">
                                        <i class="bx bx-info-circle me-1"></i>Belum ada dampak kegiatan
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Kegiatan (Village Activities) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sub Kegiatan Desa</h5>
                            @if ($villageActivities->count() > 0)
                                @php
                                    $totalActivities = $villageActivities->count();
                                    $completedActivities = $villageActivities->where('status', 'completed')->count();
                                    $percentage =
                                        $totalActivities > 0
                                            ? round(($completedActivities / $totalActivities) * 100, 1)
                                            : 0;
                                @endphp
                                <div class="text-end">
                                    <span
                                        class="badge bg-label-primary fs-6">{{ $completedActivities }}/{{ $totalActivities }}
                                        Selesai</span>
                                </div>
                            @endif
                        </div>
                        @if ($villageActivities->count() > 0)
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Progress Kegiatan</small>
                                    <small class="fw-semibold">{{ $percentage }}%</small>
                                </div>
                                <div
                                    class="progress"
                                    style="height: 8px;"
                                >
                                    <div
                                        class="progress-bar {{ $percentage == 100 ? 'bg-success' : 'bg-primary' }}"
                                        role="progressbar"
                                        style="width: {{ $percentage }}%"
                                        aria-valuenow="{{ $percentage }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    ></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($villageActivities->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center"
                                                style="width: 50px;"
                                            >#</th>
                                            <th>Sub Kegiatan</th>
                                            <th
                                                class="text-center"
                                                style="width: 150px;"
                                            >Status</th>
                                            <th
                                                class="text-center"
                                                style="width: 150px;"
                                            >Tanggal Selesai</th>
                                            <th
                                                class="text-center"
                                                style="width: 200px;"
                                            >Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($villageActivities as $index => $villageActivity)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $villageActivity->subActivity->title }}</td>
                                                <td class="text-center">
                                                    @if ($villageActivity->status === 'completed')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($villageActivity->finish_date)
                                                        {{ \Carbon\Carbon::parse($villageActivity->finish_date)->format('d M Y') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($villageActivity->status === 'pending')
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateStatusModal{{ $villageActivity->id }}"
                                                        >
                                                            <i class="bx bx-check"></i> Tandai Selesai
                                                        </button>
                                                    @else
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-secondary"
                                                            disabled
                                                        >
                                                            <i class="bx bx-check-circle"></i> Sudah Selesai
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal Update Status -->
                                            <div
                                                class="modal fade"
                                                id="updateStatusModal{{ $villageActivity->id }}"
                                                tabindex="-1"
                                                aria-hidden="true"
                                            >
                                                <div
                                                    class="modal-dialog"
                                                    role="document"
                                                >
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tandai Kegiatan Selesai</h5>
                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"
                                                            ></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('village.activities.village-activities.update-status', [$activity->id, $villageActivity->id]) }}"
                                                            method="POST"
                                                            enctype="multipart/form-data"
                                                        >
                                                            @csrf
                                                            <div class="modal-body">
                                                                <p class="mb-3">
                                                                    Apakah Anda yakin ingin menandai kegiatan
                                                                    <strong>{{ $villageActivity->subActivity->title }}</strong>
                                                                    sebagai selesai?
                                                                </p>

                                                                <div class="alert alert-info mb-3">
                                                                    <i class="bx bx-info-circle me-1"></i>
                                                                    Tanggal selesai akan otomatis diisi dengan tanggal hari
                                                                    ini
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label
                                                                        for="images_{{ $villageActivity->id }}"
                                                                        class="form-label"
                                                                    >Upload Foto Dokumentasi (Opsional)</label>
                                                                    <input
                                                                        type="file"
                                                                        class="form-control"
                                                                        id="images_{{ $villageActivity->id }}"
                                                                        name="images[]"
                                                                        accept="image/*"
                                                                        multiple
                                                                        onchange="previewImages(event, 'preview_{{ $villageActivity->id }}')"
                                                                    />
                                                                    <small class="text-muted">Anda dapat memilih beberapa
                                                                        gambar sekaligus (Max: 2MB per gambar)</small>
                                                                </div>

                                                                <div
                                                                    id="preview_{{ $villageActivity->id }}"
                                                                    class="row g-2 mt-2"
                                                                ></div>

                                                                <input
                                                                    type="hidden"
                                                                    name="status"
                                                                    value="completed"
                                                                />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal"
                                                                >Batal</button>
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-success"
                                                                >Tandai Selesai</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada sub kegiatan untuk desa ini</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Store selected files for each modal
        const filesMap = new Map();

        function previewImages(event, previewId) {
            const previewContainer = document.getElementById(previewId);
            const files = event.target.files;
            const inputId = event.target.id;

            // Store files in map
            filesMap.set(inputId, Array.from(files));

            // Clear preview
            previewContainer.innerHTML = '';

            if (files.length === 0) {
                return;
            }

            // Show files count
            const countBadge = document.createElement('div');
            countBadge.className = 'col-12 mb-2';
            countBadge.innerHTML = `<span class="badge bg-primary">${files.length} gambar dipilih</span>`;
            previewContainer.appendChild(countBadge);

            Array.from(files).forEach((file, index) => {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    return;
                }

                // Validate file size (max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    const col = document.createElement('div');
                    col.className = 'col-12 mb-2';
                    col.innerHTML = `<div class="alert alert-danger alert-dismissible py-2 mb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        File <strong>${file.name}</strong> terlalu besar (${(file.size / 1024 / 1024).toFixed(2)}MB). Max: 2MB
                    </div>`;
                    previewContainer.appendChild(col);
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-6';
                    col.dataset.index = index;

                    const card = document.createElement('div');
                    card.className = 'card position-relative';

                    // Remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1';
                    removeBtn.style.zIndex = '10';
                    removeBtn.innerHTML = '<i class="bx bx-x"></i>';
                    removeBtn.onclick = function() {
                        removeImage(inputId, index, previewId);
                    };

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'card-img-top';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';

                    const cardBody = document.createElement('div');
                    cardBody.className = 'card-body p-2';

                    const fileName = document.createElement('small');
                    fileName.className = 'text-muted d-block text-truncate';
                    fileName.textContent = file.name;

                    const fileSize = document.createElement('small');
                    fileSize.className = 'text-muted d-block';
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';

                    cardBody.appendChild(fileName);
                    cardBody.appendChild(fileSize);
                    card.appendChild(removeBtn);
                    card.appendChild(img);
                    card.appendChild(cardBody);
                    col.appendChild(card);
                    previewContainer.appendChild(col);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(inputId, index, previewId) {
            const input = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewId);

            // Get stored files
            let files = filesMap.get(inputId) || [];

            // Remove file at index
            files.splice(index, 1);

            // Update stored files
            filesMap.set(inputId, files);

            // Create new FileList
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;

            // Refresh preview
            previewContainer.innerHTML = '';

            if (files.length === 0) {
                return;
            }

            // Show files count
            const countBadge = document.createElement('div');
            countBadge.className = 'col-12 mb-2';
            countBadge.innerHTML = `<span class="badge bg-primary">${files.length} gambar dipilih</span>`;
            previewContainer.appendChild(countBadge);

            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-6';
                    col.dataset.index = idx;

                    const card = document.createElement('div');
                    card.className = 'card position-relative';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1';
                    removeBtn.style.zIndex = '10';
                    removeBtn.innerHTML = '<i class="bx bx-x"></i>';
                    removeBtn.onclick = function() {
                        removeImage(inputId, idx, previewId);
                    };

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'card-img-top';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';

                    const cardBody = document.createElement('div');
                    cardBody.className = 'card-body p-2';

                    const fileName = document.createElement('small');
                    fileName.className = 'text-muted d-block text-truncate';
                    fileName.textContent = file.name;

                    const fileSize = document.createElement('small');
                    fileSize.className = 'text-muted d-block';
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';

                    cardBody.appendChild(fileName);
                    cardBody.appendChild(fileSize);
                    card.appendChild(removeBtn);
                    card.appendChild(img);
                    card.appendChild(cardBody);
                    col.appendChild(card);
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endpush
