@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="card bg-primary text-white"
                    style="background: linear-gradient(135deg, #0286c6 0%, #0286c6 100%);"
                >
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-white mb-2">👋 Selamat Datang, {{ auth()->user()->name }}!</h4>
                                <p
                                    class="text-white mb-0"
                                    style="opacity: 0.9;"
                                >
                                    Sistem Informasi Manajemen Buku Wajib PKK - Dashboard Administrasi
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div
                                    class="text-white mb-2"
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
            <!-- Total Members -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1">Total Anggota</span>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">{{ number_format($stats['total_members']) }}</h3>
                                </div>
                                <small class="text-success">
                                    <i class='bx bx-user-check'></i>
                                    {{ number_format($stats['active_members']) }} Aktif
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

            <!-- Total Activities -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1">Total Kegiatan</span>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">{{ number_format($stats['total_activities']) }}</h3>
                                </div>
                                <small class="text-muted">Program & Aktivitas</small>
                            </div>
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-calendar-event bx-md'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Inventories -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1">Total Inventaris</span>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">{{ number_format($stats['total_inventories']) }}</h3>
                                </div>
                                <small class="text-muted">Barang & Aset</small>
                            </div>
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class='bx bx-box bx-md'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Meetings -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-muted d-block mb-1">Rapat & Pertemuan</span>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">{{ number_format($stats['total_meetings']) }}</h3>
                                </div>
                                <small class="text-muted">Notulen Rapat</small>
                            </div>
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-notepad bx-md'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash Flow and Letters -->
        <div class="row mb-4">
            <!-- Cash Flow Summary -->
            <div class="col-xl-8 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Ringkasan Keuangan</h5>
                        <span class="badge bg-label-primary">6 Bulan Terakhir</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="text-center p-3 border rounded">
                                    <i class='bx bx-trending-up bx-lg text-success mb-2'></i>
                                    <p class="text-muted mb-1 small">Total Pemasukan</p>
                                    <h5 class="mb-0 text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="text-center p-3 border rounded">
                                    <i class='bx bx-trending-down bx-lg text-danger mb-2'></i>
                                    <p class="text-muted mb-1 small">Total Pengeluaran</p>
                                    <h5 class="mb-0 text-danger">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="text-center p-3 border rounded"
                                    style="background: linear-gradient(135deg, #0286c6 0%, #0286c6 100%);"
                                >
                                    <i class='bx bx-wallet bx-lg text-white mb-2'></i>
                                    <p
                                        class="text-white mb-1 small"
                                        style="opacity: 0.9;"
                                    >Saldo</p>
                                    <h5 class="mb-0 text-white">Rp {{ number_format($balance, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Chart Placeholder -->
                        <div class="mt-4">
                            <canvas
                                id="cashFlowChart"
                                height="80"
                            ></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Letters Statistics -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Statistik Surat</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class='bx bx-mail-send'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">Surat Masuk</p>
                                    <h4 class="mb-0">{{ number_format($stats['total_incoming_letters']) }}</h4>
                                </div>
                            </div>
                            <div
                                class="progress"
                                style="height: 8px;"
                            >
                                <div
                                    class="progress-bar bg-primary"
                                    role="progressbar"
                                    style="width: 100%"
                                    aria-valuenow="100"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class='bx bx-send'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">Surat Keluar</p>
                                    <h4 class="mb-0">{{ number_format($stats['total_outgoing_letters']) }}</h4>
                                </div>
                            </div>
                            <div
                                class="progress"
                                style="height: 8px;"
                            >
                                <div
                                    class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: {{ $stats['total_outgoing_letters'] > 0 ? ($stats['total_outgoing_letters'] / $stats['total_incoming_letters']) * 100 : 0 }}%"
                                    aria-valuenow="{{ $stats['total_outgoing_letters'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class='bx bx-user-voice'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">Buku Tamu</p>
                                    <h4 class="mb-0">{{ number_format($stats['total_guest_books']) }}</h4>
                                </div>
                            </div>
                            <div
                                class="progress"
                                style="height: 8px;"
                            >
                                <div
                                    class="progress-bar bg-info"
                                    role="progressbar"
                                    style="width: {{ $stats['total_guest_books'] > 0 ? ($stats['total_guest_books'] / ($stats['total_incoming_letters'] + $stats['total_outgoing_letters'])) * 100 : 0 }}%"
                                    aria-valuenow="{{ $stats['total_guest_books'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data -->
        <div class="row">
            <!-- Recent Activities -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Kegiatan Terbaru</h5>
                        <a
                            href="{{ route('admin.activities.index') }}"
                            class="btn btn-sm btn-outline-primary"
                        >Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentActivities as $activity)
                            <div class="d-flex align-items-start mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class='bx bx-calendar-event'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $activity->title }}</h6>
                                    <p class="mb-1 small text-muted">
                                        <i class='bx bx-map'></i> {{ $activity->location }}
                                    </p>
                                    <small class="text-muted">
                                        <i class='bx bx-time'></i>
                                        {{ \Carbon\Carbon::parse($activity->date)->isoFormat('D MMMM YYYY') }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class='bx bx-info-circle bx-lg text-muted mb-2'></i>
                                <p class="text-muted">Belum ada kegiatan terbaru</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Guest Books -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Tamu Terbaru</h5>
                        <a
                            href="{{ route('admin.guest-books.index') }}"
                            class="btn btn-sm btn-outline-primary"
                        >Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentGuests as $guest)
                            <div class="d-flex align-items-start mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class='bx bx-user'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $guest->visitor_name }}</h6>
                                    <p class="mb-1 small text-muted">
                                        <i class='bx bx-building'></i> {{ $guest->institution }}
                                    </p>
                                    <small class="text-muted">
                                        <i class='bx bx-time'></i>
                                        {{ \Carbon\Carbon::parse($guest->visit_date)->isoFormat('D MMMM YYYY') }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-label-info">{{ $guest->purpose }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class='bx bx-info-circle bx-lg text-muted mb-2'></i>
                                <p class="text-muted">Belum ada data tamu</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Meetings -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Rapat & Pertemuan Terbaru</h5>
                        <a
                            href="{{ route('admin.meeting-minutes.index') }}"
                            class="btn btn-sm btn-outline-primary"
                        >Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Rapat</th>
                                        <th>Lokasi</th>
                                        <th>Pimpinan</th>
                                        <th>Peserta</th>
                                        <th>Agenda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentMeetings as $meeting)
                                        <tr>
                                            <td>
                                                <span
                                                    class="fw-semibold">{{ \Carbon\Carbon::parse($meeting->meeting_date)->isoFormat('D MMM YYYY') }}</span><br>
                                                <small class="text-muted">{{ $meeting->start_time }} -
                                                    {{ $meeting->end_time }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-primary">{{ $meeting->meeting_type }}</span>
                                            </td>
                                            <td>{{ $meeting->location }}</td>
                                            <td>{{ $meeting->leader }}</td>
                                            <td>
                                                <span class="badge bg-label-success">
                                                    {{ $meeting->attended_count }}/{{ $meeting->invited_count }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($meeting->agenda, 50) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="text-center py-4"
                                            >
                                                <i class='bx bx-info-circle bx-lg text-muted mb-2'></i>
                                                <p class="text-muted mb-0">Belum ada data rapat</p>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Cash Flow Chart
        const ctx = document.getElementById('cashFlowChart');

        const chartData = @json($monthlyCashFlow);

        const labels = chartData.map(item => {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return months[item.month - 1] + ' ' + item.year;
        }).reverse();

        const incomeData = chartData.map(item => item.income).reverse();
        const expenseData = chartData.map(item => item.expense).reverse();

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pemasukan',
                    data: incomeData,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pengeluaran',
                    data: expenseData,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
