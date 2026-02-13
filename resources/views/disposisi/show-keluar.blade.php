@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <a href="{{ route('surat-keluar') }}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <div class="card border-0 shadow-sm bg-gold text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3 bg-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-send-fill fs-2 text-success"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">SIPERSURAT - DPRD PROV. SUMSEL</h3>
                            <p class="mb-0 opacity-75">Disposisi Surat Keluar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Timeline Column -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-success"><i class="bi bi-clock-history me-2"></i>Riwayat Disposisi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        <!-- Step 1: Surat Keluar -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success">
                                <i class="bi bi-check-lg text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-success">Surat Keluar Dibuat</h6>
                                <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y, H:i') }} WIB</p>
                                <div class="alert alert-light border mb-0">
                                    <small class="text-dark">Surat telah dibuat oleh <strong>Admin Tata Usaha</strong>.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Loop Disposisi -->
                        @foreach($disposisiList as $disposisi)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary">
                                <i class="bi bi-send-fill text-white" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-primary">Disposisi Pimpinan</h6>
                                <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($disposisi->created_at)->format('d M Y, H:i') }} WIB</p>
                                <div class="card border-0 bg-light shadow-sm">
                                    <div class="card-body p-3 border-start border-4 border-primary">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">DITERUSKAN KEPADA</small>
                                                <div class="fw-bold text-dark">{{ $disposisi->tujuan_disposisi }}</div>
                                            </div>
                                            <div class="col-12">
                                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">INSTRUKSI</small>
                                                <div class="text-dark">{{ $disposisi->isi_disposisi }}</div>
                                            </div>
                                            @if($disposisi->catatan)
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">CATATAN</small>
                                                <div class="fst-italic text-muted">"{{ $disposisi->catatan }}"</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Step Current: Menunggu / Selesai -->
                        @if($surat->status == 'Selesai' || $surat->status == 'Arsip')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success">
                                <i class="bi bi-check-all text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-success">Tindak Lanjut Selesai</h6>
                                <p class="text-muted small mb-2">Proses surat telah berakhir.</p>
                                <div class="alert alert-success border-0 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>Surat ini telah selesai ditindaklanjuti.</div>
                                </div>
                            </div>
                        </div>
                        @elseif($surat->status == 'Disposisi')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning">
                                <i class="bi bi-hourglass-split text-dark"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-dark">Sedang Diproses</h6>
                                <p class="text-muted small mb-2">Menunggu tindak lanjut dari bidang terkait.</p>
                                
                                @if(session('user_role') === 'Tata Usaha')
                                <div class="mt-3">
                                    <form action="{{ route('disposisi-keluar.finish', $surat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menandai surat ini sebagai SELESAI?');">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm">
                                            <i class="bi bi-check-circle me-1"></i> Tandai Selesai
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning">
                                <i class="bi bi-exclamation-lg text-dark"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-dark">Menunggu Arahan</h6>
                                <p class="text-muted small mb-2">Surat menunggu disposisi dari Pimpinan/Sekwan.</p>
                                
                                <!-- Action Form for Sekwan -->
                                @if(session('user_role') === 'Sekwan')
                                <div class="card border-warning mt-3 shadow-sm">
                                    <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-pencil-square me-2"></i> Form Disposisi</span>
                                    </div>
                                    <div class="card-body bg-white">
                                        <form action="{{ route('disposisi-keluar.store', $surat->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-dark">Diteruskan Kepada:</label>
                                                <select class="form-select form-select-sm" name="tujuan_disposisi" required>
                                                    <option value="" selected disabled>Pilih Tujuan...</option>
                                                    <option value="KBU (Umum)">KBU (Umum)</option>
                                                    <option value="KBK (Keuangan)">KBK (Keuangan)</option>
                                                    <option value="KBP (Persidangan)">KBP (Persidangan)</option>
                                                    <option value="KBH (Humas)">KBH (Humas)</option>
                                                    <option value="RT">RT</option>
                                                    <option value="Perlengkapan">Perlengkapan</option>
                                                    
                                                    <optgroup label="Komisi">
                                                        <option value="Komisi 1">Komisi 1</option>
                                                        <option value="Komisi 2">Komisi 2</option>
                                                        <option value="Komisi 3">Komisi 3</option>
                                                        <option value="Komisi 4">Komisi 4</option>
                                                        <option value="Komisi 5">Komisi 5</option>
                                                    </optgroup>

                                                    <optgroup label="Fraksi Partai">
                                                        <option value="Fraksi Golkar">Fraksi Golkar</option>
                                                        <option value="Fraksi Gerindra">Fraksi Gerindra</option>
                                                        <option value="Fraksi NasDem">Fraksi NasDem</option>
                                                        <option value="Fraksi PDI-P">Fraksi PDI-P</option>
                                                        <option value="Fraksi Demokrat">Fraksi Demokrat</option>
                                                        <option value="Fraksi PKB">Fraksi PKB</option>
                                                        <option value="Fraksi PKS">Fraksi PKS</option>
                                                        <option value="Fraksi PAN">Fraksi PAN</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-dark">Isi Instruksi:</label>
                                                <textarea class="form-control form-control-sm" name="isi_disposisi" rows="3" placeholder="Contoh: Segera tindak lanjuti..." required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold text-dark">Catatan (Opsional):</label>
                                                    <input type="text" class="form-control form-control-sm" name="catatan">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold text-dark">Batas Waktu:</label>
                                                    <input type="date" class="form-control form-control-sm" name="batas_waktu">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-dark w-100 fw-bold"><i class="bi bi-send-fill me-2"></i> Kirim Disposisi</button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-warning mt-3 mb-0 d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                    <div>
                                        <strong>Menunggu Disposisi!</strong><br>
                                        Surat ini belum didisposisikan.
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Column -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-success"><i class="bi bi-info-circle me-2"></i>Detail Surat</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted w-35 small text-uppercase fw-bold">No Surat</td>
                            <td class="fw-bold text-dark">{{ $surat->no_surat }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small text-uppercase fw-bold">Tujuan</td>
                            <td class="fw-bold text-dark">{{ $surat->tujuan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small text-uppercase fw-bold">Tanggal</td>
                            <td class="text-dark">{{ \Carbon\Carbon::parse($surat->tgl_keluar)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small text-uppercase fw-bold">Perihal</td>
                            <td class="text-dark">{{ $surat->perihal }}</td>
                        </tr>
                    </table>
                    
                    <hr class="my-3">
                    
                    <div class="d-grid">
                        @if($surat->file_path)
                        <a href="{{ route('surat-keluar.file', $surat->id) }}" target="_blank" class="btn btn-outline-danger shadow-sm py-2">
                            <i class="bi bi-file-earmark-pdf-fill me-2 fs-5"></i> <span class="fw-bold">Lihat Dokumen Asli</span>
                        </a>
                        @else
                        <button class="btn btn-light text-muted py-2" disabled>
                            <i class="bi bi-file-earmark-x me-2"></i> Tidak ada dokumen
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Status Terkini</h6>
                    <div class="d-flex align-items-center mb-3">
                        @if($surat->status == 'Draft')
                            <span class="badge bg-secondary text-white fs-6 px-3 py-2 rounded-pill">Draft</span>
                        @elseif($surat->status == 'Disposisi')
                            <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">Dalam Proses</span>
                        @elseif($surat->status == 'Dikirim')
                            <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">Dikirim</span>
                        @else
                            <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">Selesai / Arsip</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-0">
                        Terakhir diperbarui: <br>
                        <strong>{{ \Carbon\Carbon::parse($surat->updated_at)->diffForHumans() }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 2.5rem;
    }
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        box-shadow: 0 0 0 4px #fff;
    }
    .timeline-content {
        padding-left: 10px;
    }
</style>
@endsection
