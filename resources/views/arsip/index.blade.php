@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h2 class="fw-bold text-success mb-1">
                <i class="bi bi-archive-fill me-2"></i>Arsip Digital
            </h2>
            <p class="text-muted mb-0">Pencarian dan penyimpanan dokumen surat yang telah selesai diproses.</p>
        </div>
        <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
            <!-- Optional: Action button like 'Export' could go here -->
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-light">
            <form action="{{ route('arsip') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Kata Kunci</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari No Surat / Perihal... (Tekan Enter)" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="kategori" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ request('kategori') == '' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="1" {{ request('kategori') == '1' ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="2" {{ request('kategori') == '2' ? 'selected' : '' }}>Surat Keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <!-- Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold text-secondary">Daftar Arsip</h5>
                </div>
                <div class="col-auto">
                    <span class="badge bg-light text-secondary border">Total: {{ $arsip->count() }} Dokumen</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th scope="col" class="ps-4 py-3" width="5%">No</th>
                            <th scope="col" class="py-3" width="15%">Jenis Surat</th>
                            <th scope="col" class="py-3" width="20%">No. Surat</th>
                            <th scope="col" class="py-3" width="25%">Perihal</th>
                            <th scope="col" class="py-3" width="15%">Tgl Surat</th>
                            <th scope="col" class="py-3" width="10%">Status</th>
                            <th scope="col" class="text-end pe-4 py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arsip as $index => $item)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                @if($item->jenis == 'Surat Masuk')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">
                                        <i class="bi bi-inbox-fill me-1"></i> Surat Masuk
                                    </span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">
                                        <i class="bi bi-send-fill me-1"></i> Surat Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ $item->no_surat }}</td>
                            <td class="text-dark">{{ $item->perihal }}</td>
                            <td class="text-secondary small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-75 rounded-pill px-3">{{ $item->status }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <!-- View File -->
                                    @if($item->file_path)
                                        @if($item->jenis == 'Surat Masuk')
                                        <a href="{{ route('surat-masuk.file', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Lihat File">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        @else
                                        <a href="{{ route('surat-keluar.file', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Lihat File">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        @endif
                                    @endif

                                    <!-- Detail/Disposisi -->
                                    @if($item->jenis == 'Surat Masuk')
                                        <a href="{{ route('disposisi', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Detail & Disposisi">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('disposisi-keluar', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Detail & Disposisi">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-archive fs-1 d-block mb-3 opacity-50"></i>
                                    <p class="mb-0">Data arsip tidak ditemukan.</p>
                                    <small>Coba ubah filter pencarian Anda.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <!-- Pagination could go here if needed in the future -->
        </div>
    </div>
</div>
@endsection