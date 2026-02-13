@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold" style="color: var(--primary-green)">Dashboard</h2>
        <p class="text-muted">Selamat datang di Sistem Informasi Persuratan DPRD Provinsi Sumatera Selatan</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card card-custom h-100 border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Surat Masuk</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $countSuratMasuk }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-inbox-fill text-success fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="bi bi-arrow-up-short text-success"></i> +12% dari bulan lalu
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom h-100 border-start border-4 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Menunggu Disposisi</h6>
                        <h2 class="fw-bold mb-0 text-warning">{{ $countMenungguDisposisi }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-hourglass-split text-warning fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    Perlu tindak lanjut segera
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom h-100 border-start border-4 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Surat Keluar</h6>
                        <h2 class="fw-bold mb-0 text-info">{{ $countSuratKeluar }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-send-fill text-info fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="bi bi-arrow-up-short text-success"></i> +5% dari bulan lalu
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom h-100 border-start border-4 border-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Arsip Digital</h6>
                        <h2 class="fw-bold mb-0 text-secondary">{{ $countArsip }}</h2>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-archive-fill text-secondary fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    Total dokumen tersimpan
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Recent Activity -->
<div class="row g-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="card card-custom h-100">
            <div class="card-header card-header-custom py-3">
                <h5 class="card-title mb-0">Statistik Surat Bulanan (2026)</h5>
            </div>
            <div class="card-body">
                <canvas id="suratChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 text-dark">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-4 py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-primary">Disposisi Baru</h6>
                            <small class="text-muted">10 min ago</small>
                        </div>
                        <p class="mb-1 small">Surat dari Kemendagri telah didisposisikan oleh Sekwan.</p>
                    </div>
                    <div class="list-group-item px-4 py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-success">Surat Masuk</h6>
                            <small class="text-muted">1 jam ago</small>
                        </div>
                        <p class="mb-1 small">Surat undangan dari Gubernur Sumsel diterima.</p>
                    </div>
                    <div class="list-group-item px-4 py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-info">Surat Keluar</h6>
                            <small class="text-muted">3 jam ago</small>
                        </div>
                        <p class="mb-1 small">Balasan untuk Dinas PU telah dikirim.</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-center border-0 py-3">
                <a href="#" class="text-decoration-none text-custom-gold fw-bold">Lihat Semua Aktivitas</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('suratChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Surat Masuk',
                data: {!! json_encode($chartDataMasuk) !!},
                borderColor: '#1B5E20',
                backgroundColor: 'rgba(27, 94, 32, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Surat Keluar',
                data: {!! json_encode($chartDataKeluar) !!},
                borderColor: '#C9A227',
                backgroundColor: 'rgba(201, 162, 39, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
