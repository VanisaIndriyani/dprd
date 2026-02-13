@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: var(--primary-green)">Edit Surat Masuk</h2>
        <p class="text-muted">Perbarui data surat masuk</p>
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

        <form action="{{ route('surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="no_surat" class="form-label fw-bold">Nomor Surat</label>
                    <input type="text" class="form-control" id="no_surat" name="no_surat" value="{{ $surat->no_surat }}" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_terima" class="form-label fw-bold">Tanggal Terima</label>
                    <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" value="{{ $surat->tgl_terima }}" required>
                </div>
                <div class="col-md-6">
                    <label for="pengirim" class="form-label fw-bold">Pengirim</label>
                    <input type="text" class="form-control" id="pengirim" name="pengirim" value="{{ $surat->pengirim }}" required>
                </div>
                <div class="col-md-6">
                    <label for="file_path" class="form-label fw-bold">File Surat (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control" id="file_path" name="file_path">
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