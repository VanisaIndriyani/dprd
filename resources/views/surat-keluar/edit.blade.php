@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: var(--primary-green)">Edit Surat Keluar</h2>
        <p class="text-muted">Perbarui data surat keluar</p>
    </div>
    <a href="{{ route('surat-keluar') }}" class="btn btn-outline-secondary">
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

        <form action="{{ route('surat-keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="no_surat" class="form-label fw-bold">Nomor Surat</label>
                    <input type="text" class="form-control" id="no_surat" name="no_surat" value="{{ $surat->no_surat }}" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_keluar" class="form-label fw-bold">Tanggal Keluar</label>
                    <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" value="{{ $surat->tgl_keluar }}" required>
                </div>
                <div class="col-md-6">
                    <label for="tujuan" class="form-label fw-bold">Tujuan</label>
                    <input type="text" class="form-control" id="tujuan" name="tujuan" value="{{ $surat->tujuan }}" required>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Draft" {{ $surat->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Dikirim" {{ $surat->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Arsip" {{ $surat->status == 'Arsip' ? 'selected' : '' }}>Arsip</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="file_path" class="form-label fw-bold">File Surat (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control" id="file_path" name="file_path">
                    @if($surat->file_path)
                        <div class="form-text text-success"><i class="bi bi-check-circle"></i> File saat ini: {{ basename($surat->file_path) }}</div>
                    @endif
                </div>
                <div class="col-12">
                    <label for="perihal" class="form-label fw-bold">Perihal</label>
                    <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ $surat->perihal }}</textarea>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-gold px-4">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
