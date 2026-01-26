@extends('layouts.district')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="card bg-primary text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                >
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-white mb-2">👋 Selamat Datang, {{ auth()->user()->name }}!</h4>
                                <p
                                    class="mb-1 text-white"
                                    style="opacity: 0.9;"
                                >
                                    Kecamatan {{ $district->name ?? '-' }}, {{ $district->regency->name ?? '-' }}
                                </p>
                                <p
                                    class="mb-0 text-white"
                                    style="opacity: 0.9;"
                                >
                                    Berikut adalah ringkasan statistik sistem Anda hari ini
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div
                                    class="text-white"
                                    style="opacity: 0.9;"
                                >
                                    <i
                                        class="bx bx-calendar"
                                        style="font-size: 16px;"
                                    ></i>
                                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small mb-1">Total Desa/Kelurahan</div>
                                <div class="h4 mb-0 fw-bold">{{ $totalVillages }}</div>
                            </div>
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-home bx-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-info border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small mb-1">Total Kegiatan</div>
                                <div class="h4 mb-0 fw-bold">{{ $totalActivities }}</div>
                            </div>
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-briefcase bx-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small mb-1">Kegiatan Selesai</div>
                                <div class="h4 mb-0 fw-bold text-success">{{ $completedActivities }}</div>
                                <small class="text-muted">dari {{ $totalVillageActivities }} total</small>
                            </div>
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small mb-1">Progress Keseluruhan</div>
                                <div class="h4 mb-0 fw-bold text-primary">{{ $overallProgress }}%</div>
                                <div
                                    class="progress mt-2"
                                    style="height: 6px;"
                                >
                                    <div
                                        class="progress-bar {{ $overallProgress >= 75 ? 'bg-success' : ($overallProgress >= 50 ? 'bg-primary' : 'bg-warning') }}"
                                        role="progressbar"
                                        style="width: {{ $overallProgress }}%;"
                                        aria-valuenow="{{ $overallProgress }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    >
                                    </div>
                                </div>
                            </div>
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-trending-up bx-lg"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Activities Progress Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Progress Kegiatan Desa</h5>
                    </div>
                    <div class="card-body">
                        <canvas
                            id="activitiesChart"
                            height="300"
                        ></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Villages Chart -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Top 5 Desa</h5>
                        <small class="text-muted">Berdasarkan Kegiatan Selesai</small>
                    </div>
                    <div class="card-body">
                        @forelse($topVillages as $village)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-medium">{{ Str::limit($village['name'], 25) }}</span>
                                    <span class="badge bg-label-primary">{{ $village['progress'] }}%</span>
                                </div>
                                <div
                                    class="progress"
                                    style="height: 8px;"
                                >
                                    <div
                                        class="progress-bar {{ $village['progress'] >= 75 ? 'bg-success' : 'bg-primary' }}"
                                        role="progressbar"
                                        style="width: {{ $village['progress'] }}%;"
                                        aria-valuenow="{{ $village['progress'] }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    >
                                    </div>
                                </div>
                                <small class="text-muted">{{ $village['completed'] }}/{{ $village['total'] }}
                                    kegiatan</small>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i
                                    class="bx bx-info-circle text-muted"
                                    style="font-size: 48px;"
                                ></i>
                                <p class="text-muted mt-2">Belum ada data</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Statistik Kegiatan</h5>
                        <a
                            href="{{ route('district.activities.index') }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Lihat Semua <i class="bx bx-right-arrow-alt"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Selesai</th>
                                        <th class="text-center">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activitiesProgress as $activity)
                                        <tr>
                                            <td>{{ $activity['name'] }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-label-primary">{{ $activity['total'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $activity['completed'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div
                                                        class="progress flex-grow-1 me-2"
                                                        style="height: 8px; max-width: 150px;"
                                                    >
                                                        <div
                                                            class="progress-bar {{ $activity['progress'] >= 75 ? 'bg-success' : ($activity['progress'] >= 50 ? 'bg-primary' : 'bg-warning') }}"
                                                            role="progressbar"
                                                            style="width: {{ $activity['progress'] }}%;"
                                                        >
                                                        </div>
                                                    </div>
                                                    <span class="text-muted">{{ $activity['progress'] }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="4"
                                                class="text-center py-4"
                                            >
                                                <i
                                                    class="bx bx-info-circle text-muted"
                                                    style="font-size: 48px;"
                                                ></i>
                                                <p class="text-muted mt-2">Belum ada data kegiatan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Activities Progress Chart
        const activitiesData = @json($activitiesProgress);
        const activitiesLabels = activitiesData.map(item => item.name.length > 30 ? item.name.substring(0, 30) + '...' :
            item.name);
        const activitiesCompleted = activitiesData.map(item => item.completed);
        const activitiesPending = activitiesData.map(item => item.total - item.completed);

        const ctx = document.getElementById('activitiesChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: activitiesLabels,
                datasets: [{
                        label: 'Selesai',
                        data: activitiesCompleted,
                        backgroundColor: 'rgba(40, 199, 111, 0.8)',
                        borderColor: 'rgba(40, 199, 111, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Belum Selesai',
                        data: activitiesPending,
                        backgroundColor: 'rgba(255, 193, 7, 0.8)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' kegiatan';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
