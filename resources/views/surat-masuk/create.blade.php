@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: var(--primary-green)">Input Surat Masuk</h2>
        <p class="text-muted">Tambahkan data surat masuk baru ke sistem</p>
    </div>
    <a href="{{ route('surat-masuk') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="no_agenda" class="form-label fw-bold">No Agenda</label>
                    <input type="text" class="form-control" id="no_agenda" name="no_agenda" placeholder="Contoh: 12345" required>
                </div>
                <div class="col-md-6">
                    <label for="no_surat" class="form-label fw-bold">Nomor Surat</label>
                    <input type="text" class="form-control" id="no_surat" name="no_surat" placeholder="Contoh: 001/DINAS/2026" required>
                </div>
                <div class="col-md-6">
                    <label for="pengirim" class="form-label fw-bold">Surat Dari</label>
                    <input type="text" class="form-control" id="pengirim" name="pengirim" placeholder="Nama Instansi / Pengirim" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_surat" class="form-label fw-bold">Tanggal Surat</label>
                    <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_terima" class="form-label fw-bold">Tanggal Terima</label>
                    <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="file_path" class="form-label fw-bold">File Surat (Opsional)</label>
                    <input type="file" class="form-control" id="file_path" name="file_path">
                    <div class="form-text">Format: PDF, JPG, PNG (Max 2MB)</div>
                </div>
                <div class="col-12">
                    <label for="perihal" class="form-label fw-bold">Perihal</label>
                    <textarea class="form-control" id="perihal" name="perihal" rows="3" placeholder="Ringkasan isi surat..." required></textarea>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-gold px-4">
                        <i class="bi bi-save me-2"></i> Simpan Surat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection