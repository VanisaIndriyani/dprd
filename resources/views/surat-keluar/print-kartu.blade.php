<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Keluar - {{ $surat->no_surat }}</title>
    <style>
        .print-wrapper {
            width: 100%;
        }
        @media print {
            @page {
                size: A5 landscape;
                margin: 6mm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .print-wrapper {
                transform: scale(0.85);
                transform-origin: top left;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            margin: 0;
            padding: 10px;
        }
        .container {
            width: 100%;
            border: 2px solid #000;
            padding: 0;
            position: relative;
            page-break-inside: avoid;
        }
        .header-side {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 40px;
            border-right: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
        }
        .header-side h2 {
            transform: rotate(-90deg);
            white-space: nowrap;
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .content {
            margin-left: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }
        .label {
            font-size: 10pt;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        .value {
            font-weight: bold;
            font-size: 11pt;
        }
        .handwriting {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12pt;
            color: #000;
        }
        .row-header td {
            border-top: none;
            border-left: none;
            border-right: none;
        }
        .header-cells td {
            border-bottom: 2px solid #000;
        }
        .btn-print {
            background-color: #0d6efd; 
            color: white; 
            border: none; 
            border-radius: 5px;
        }
        .btn-close {
            background-color: #6c757d; 
            color: white; 
            border: none; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" class="btn-print" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-right: 10px;">Cetak Kartu</button>
        <button onclick="window.close()" class="btn-close" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <div class="print-wrapper">
        <div class="container">
            <div class="header-side">
                <h2>Kartu Surat Keluar</h2>
            </div>
            <div class="content">
                <table>
                <tr class="header-cells">
                    <td colspan="3" style="border-right: 1px solid #000; width: 50%;">
                        <!-- Empty Space for Header / Logo if needed -->
                        <div style="height: 40px;"></div>
                    </td>
                    <td style="width: 15%;">
                        <span class="label">Indek</span>
                        <div class="value">&nbsp;</div>
                    </td>
                    <td style="width: 15%;">
                        <span class="label">Kode</span>
                        <div class="value">000.1.5</div>
                    </td>
                    <td style="width: 20%;">
                        <span class="label">Nomor Urut</span>
                        <div class="value handwriting">-</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 80px;">
                        <span class="label">Isi Ringkas / Perihal</span>
                        @php
                            $isiRingkas = $surat->perihal;
                            $prefix = 'Tindak Lanjut Disposisi: ';
                            if (strpos($isiRingkas, $prefix) === 0) {
                                $isiRingkas = substr($isiRingkas, strlen($prefix));
                            }
                        @endphp
                        <div class="value handwriting">{{ $isiRingkas }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span class="label">Dari / Pengolah</span>
                        <div class="value handwriting">{{ $surat->pengolah ?? '-' }}</div>
                    </td>
                    <td colspan="3">
                        <span class="label">Tujuan Surat</span>
                        <div class="value handwriting">{{ $surat->tujuan }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 30%;">
                        <span class="label">Tanggal Surat</span>
                        <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_keluar)->format('d F Y') }}</div>
                    </td>
                    <td colspan="2" style="width: 40%;">
                        <span class="label">Nomor Surat</span>
                        <div class="value handwriting">{{ $surat->no_surat }}</div>
                    </td>
                    <td colspan="2" style="width: 30%;">
                        <span class="label">Lampiran</span>
                        <div class="value handwriting">-</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 60px;">
                        <span class="label">Pengolah / Diteruskan Kepada</span>
                        <div class="value handwriting">
                            @if($disposisi)
                                {{ $disposisi->tujuan_disposisi }}
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Tanggal Diteruskan</span>
                        <div class="value handwriting">
                            @if($disposisi)
                                {{ \Carbon\Carbon::parse($disposisi->created_at)->format('d F Y') }}
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Paraf</span>
                        <div class="value">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height: 80px;">
                        <span class="label">Instruksi / Catatan</span>
                        <div class="value handwriting">
                            @if($disposisi)
                                @if($disposisi->instruksi_pilihan)
                                    <ul style="margin: 0; padding-left: 20px;">
                                        @foreach($disposisi->instruksi_pilihan as $pilihan)
                                            <li>{{ $pilihan }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if($disposisi->isi_disposisi)
                                    <div>{{ $disposisi->isi_disposisi }}</div>
                                @endif
                                @if($disposisi->catatan)
                                    <div style="margin-top: 5px; font-style: italic;">"{{ $disposisi->catatan }}"</div>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Sifat</span>
                        <div class="value handwriting">
                            @if($disposisi)
                                {{ $disposisi->sifat }}
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            @if($disposisi)
            <div style="margin-top: 20px; text-align: right; padding-right: 20px;">
                <div style="display: inline-block; text-align: center;">
                    <div style="font-size: 10pt; margin-bottom: 5px;">{{ $disposisi->ttd_jabatan }}</div>
                    @if($disposisi->ttd_image)
                        <img src="{{ asset('storage/' . $disposisi->ttd_image) }}" alt="TTD" style="height: 60px; margin: 5px 0;">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div style="font-weight: bold; text-decoration: underline;">{{ $disposisi->ttd_nama }}</div>
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
</body>
</html>
