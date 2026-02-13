@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h2 class="fw-bold text-success mb-1">
                <i class="bi bi-inbox-fill me-2"></i>Surat Masuk
            </h2>
            <p class="text-muted mb-0">Kelola dan pantau surat yang masuk dari instansi luar.</p>
        </div>
        <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
            @if(session('user_role') !== 'Sekwan')
            <a href="{{ route('surat-masuk.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Input Surat Masuk
            </a>
            @endif
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-0 fw-bold text-secondary">Daftar Surat Masuk</h5>
                </div>
                <div class="col-12 col-md-5 mb-3 mb-md-0">
                    <form action="{{ route('surat-masuk') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0 bg-light" placeholder="Cari Surat..." value="{{ request('search') }}">
                            <button class="btn btn-success text-white" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-auto">
                    <span class="badge bg-light text-secondary border">Total: {{ $suratMasuk->count() }} Surat</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th scope="col" class="ps-4 py-3" width="5%">No</th>
                            <th scope="col" class="py-3" width="25%">Info Surat</th>
                            <th scope="col" class="py-3" width="30%">Perihal</th>
                            <th scope="col" class="py-3" width="15%">Tgl Terima</th>
                            <th scope="col" class="py-3" width="15%">Status</th>
                            <th scope="col" class="text-end pe-4 py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratMasuk as $index => $surat)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-envelope text-success"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $surat->pengirim }}</div>
                                        <small class="text-muted d-block"><i class="bi bi-hash me-1"></i>{{ $surat->no_surat }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-dark">{{ $surat->perihal }}</span>
                            </td>
                            <td>
                                <div class="text-secondary small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($surat->tgl_terima)->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                @if($surat->status == 'Menunggu Disposisi')
                                    <span class="badge bg-warning text-dark bg-opacity-75 px-3 py-2 rounded-pill">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                    </span>
                                @elseif($surat->status == 'Disposisi')
                                    <span class="badge bg-primary bg-opacity-75 px-3 py-2 rounded-pill">
                                        <i class="bi bi-send me-1"></i> Disposisi
                                    </span>
                                @elseif($surat->status == 'Selesai')
                                    <span class="badge bg-success bg-opacity-75 px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $surat->status }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><h6 class="dropdown-header">Aksi</h6></li>
                                        
                                        <!-- View File -->
                                        <li>
                                            @if($surat->file_path)
                                            <a class="dropdown-item" href="{{ route('surat-masuk.file', $surat->id) }}" target="_blank">
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i> Lihat File
                                            </a>
                                            @else
                                            <span class="dropdown-item disabled text-muted">
                                                <i class="bi bi-file-earmark-x me-2"></i> Tidak ada file
                                            </span>
                                            @endif
                                        </li>

                                        <!-- Detail/Disposisi -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('disposisi', $surat->id) }}">
                                                <i class="bi bi-info-circle text-primary me-2"></i> Detail / Disposisi
                                            </a>
                                        </li>

                                        @if(session('user_role') !== 'Sekwan')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('surat-masuk.edit', $surat->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('surat-masuk.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data surat masuk.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <!-- Pagination could go here -->
        </div>
    </div>
</div>
@endsection