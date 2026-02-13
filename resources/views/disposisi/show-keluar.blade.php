@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('surat-keluar') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('surat-keluar.print', $surat->id) }}" target="_blank" class="btn btn-light btn-sm shadow-sm text-dark border">
                    <i class="bi bi-printer-fill me-2"></i> Cetak Kartu Disposisi
                </a>
            </div>
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
                                                
                                                @if($disposisi->instruksi_pilihan)
                                                    <ul class="mb-1 ps-3 text-dark small">
                                                        @foreach($disposisi->instruksi_pilihan as $pilihan)
                                                            <li>{{ $pilihan }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                
                                                @if($disposisi->isi_disposisi)
                                                <div class="text-dark">{{ $disposisi->isi_disposisi }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">SIFAT</small>
                                                        <div>
                                                            @if($disposisi->sifat == 'Segera')
                                                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i> Segera</span>
                                                            @elseif($disposisi->sifat == 'Sangat Segera')
                                                                <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i> Sangat Segera</span>
                                                            @elseif($disposisi->sifat == 'Rahasia')
                                                                <span class="badge bg-dark"><i class="bi bi-eye-slash me-1"></i> Rahasia</span>
                                                            @else
                                                                <span class="badge bg-secondary">Biasa</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">BATAS WAKTU</small>
                                                        <div class="fw-bold text-danger">
                                                            @if($disposisi->batas_waktu)
                                                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($disposisi->batas_waktu)->format('d M Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($disposisi->catatan)
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">CATATAN</small>
                                                <div class="fst-italic text-muted">"{{ $disposisi->catatan }}"</div>
                                            </div>
                                            @endif
                                            
                                            <!-- TTD Display -->
                                            <div class="col-12 mt-3 pt-3 border-top text-end">
                                                <div class="d-inline-block text-center" style="min-width: 150px;">
                                                    <small class="d-block fw-bold text-dark mb-1">{{ $disposisi->ttd_jabatan ?? 'Sekretaris DPRD' }}</small>
                                                    <small class="d-block text-muted mb-1">Paraf & Tanggal: {{ $disposisi->ttd_tanggal ? \Carbon\Carbon::parse($disposisi->ttd_tanggal)->format('d/m/Y') : '-' }}</small>
                                                    @if($disposisi->ttd_image)
                                                        <img src="{{ asset('storage/' . $disposisi->ttd_image) }}" alt="TTD" class="d-block" style="height: 60px; margin: 5px 0 5px auto;">
                                                    @else
                                                        <div style="height: 60px;"></div>
                                                    @endif
                                                    <div class="fw-bold text-dark border-bottom border-dark pb-1 d-inline-block px-3">{{ $disposisi->ttd_nama ?? 'Pimpinan' }}</div>
                                                </div>
                                            </div>
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
                                        <form action="{{ route('disposisi-keluar.store', $surat->id) }}" method="POST" enctype="multipart/form-data">
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
                                                <label class="form-label small fw-bold text-dark">Instruksi / Harap:</label>
                                                <div class="bg-light p-3 rounded border">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="instruksi_pilihan[]" value="Tanggapan dan Saran" id="check1">
                                                        <label class="form-check-label" for="check1">Tanggapan dan Saran</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="instruksi_pilihan[]" value="Proses lebih lanjut" id="check2">
                                                        <label class="form-check-label" for="check2">Proses lebih lanjut</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="instruksi_pilihan[]" value="Koordinasi/Konfirmasikan" id="check3">
                                                        <label class="form-check-label" for="check3">Koordinasi/Konfirmasikan</label>
                                                    </div>
                                                </div>
                                                <textarea class="form-control form-control-sm mt-2" name="isi_disposisi" rows="2" placeholder="Instruksi tambahan lainnya..."></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold text-dark">Sifat Surat:</label>
                                                    <select class="form-select form-select-sm" name="sifat" required>
                                                        <option value="" selected disabled>Pilih Sifat...</option>
                                                        <option value="Biasa">Biasa</option>
                                                        <option value="Segera">Segera</option>
                                                        <option value="Sangat Segera">Sangat Segera</option>
                                                        <option value="Rahasia">Rahasia</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label small fw-bold text-dark">Batas Waktu:</label>
                                                    <input type="date" class="form-control form-control-sm" name="batas_waktu">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-dark">Catatan (Opsional):</label>
                                                <input type="text" class="form-control form-control-sm" name="catatan">
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label small fw-bold text-dark border-bottom w-100 pb-1">Tanda Tangan</label>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <label class="small text-muted">Jabatan</label>
                                                        <input type="text" class="form-control form-control-sm bg-light" name="ttd_jabatan" value="Sekretaris DPRD" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="small text-muted">Tanggal</label>
                                                        <input type="date" class="form-control form-control-sm bg-light" name="ttd_tanggal" value="{{ date('Y-m-d') }}" readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="small text-muted">Nama Lengkap</label>
                                                        <input type="text" class="form-control form-control-sm" name="ttd_nama" value="{{ session('user_name') }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="small text-muted">Upload Tanda Tangan (Opsional)</label>
                                                        <input type="file" class="form-control form-control-sm" name="ttd_image" accept="image/*" id="ttd_image_input">
                                                        <div class="form-text small text-muted">Format: JPG, PNG.</div>
                                                    </div>

                                                    <!-- Digital Signature Pad -->
                                                    <div class="col-12">
                                                        <label class="small text-muted">Atau Buat Tanda Tangan Digital</label>
                                                        <div class="border rounded p-2 bg-light">
                                                            <canvas id="signature-canvas" class="bg-white border w-100" height="150" style="touch-action: none;"></canvas>
                                                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                                                <button type="button" class="btn btn-sm btn-outline-danger" id="clear-signature">
                                                                    <i class="bi bi-eraser me-1"></i> Hapus Tanda Tangan
                                                                </button>
                                                                <small class="text-muted fst-italic" id="signature-status">Coret di canvas di atas</small>
                                                            </div>
                                                            <input type="hidden" name="ttd_signature_base64" id="ttd_signature_base64">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-sm btn-dark w-100 fw-bold" id="submit-disposisi"><i class="bi bi-send-fill me-2"></i> Kirim Disposisi</button>
                                        </form>
                                    </div>
                                </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('signature-canvas');
        const clearBtn = document.getElementById('clear-signature');
        const hiddenInput = document.getElementById('ttd_signature_base64');
        const statusText = document.getElementById('signature-status');
        const form = canvas.closest('form');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let hasSignature = false;

        // Resize canvas to fit container
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        function startDrawing(e) {
            isDrawing = true;
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault(); // Prevent scrolling on touch
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            hasSignature = true;
            statusText.innerText = "Tanda tangan terdeteksi";
            statusText.classList.add('text-success');
            statusText.classList.remove('text-muted');
        }

        function stopDrawing() {
            if (isDrawing) {
                isDrawing = false;
                updateHiddenInput();
            }
        }

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            
            if (e.touches && e.touches.length > 0) {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            } else {
                clientX = e.clientX;
                clientY = e.clientY;
            }
            
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function updateHiddenInput() {
            if (hasSignature) {
                hiddenInput.value = canvas.toDataURL('image/png');
            } else {
                hiddenInput.value = '';
            }
        }

        // Mouse Events
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        // Touch Events
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        // Clear Button
        clearBtn.addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Use actual width/height
            hasSignature = false;
            hiddenInput.value = '';
            statusText.innerText = "Coret di canvas di atas";
            statusText.classList.remove('text-success');
            statusText.classList.add('text-muted');
        });

        // Form Submit
        form.addEventListener('submit', function(e) {
            updateHiddenInput();
        });
    });
</script>
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
