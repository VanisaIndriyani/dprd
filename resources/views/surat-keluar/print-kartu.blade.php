<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Keluar - {{ $surat->no_surat }}</title>
    <style>
        @media print {
            @page {
                size: A5 landscape;
                margin: 5mm;
            }
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-wrapper {
            width: 100%;
        }
        body {
            font-family: "Times New Roman", serif;
            font-size: 10.5pt;
            margin: 0;
            padding: 8px;
        }
        .container {
            border: 2px solid #000;
            position: relative;
            width: 100%;
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
        }
        .header-side h2 {
            transform: rotate(-90deg);
            font-size: 12.5pt;
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            white-space: nowrap;
            font-weight: bold;
        }
        .content {
            margin-left: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
        }
        .label {
            font-size: 9pt;
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
            letter-spacing: 0.2px;
        }
        .value {
            font-size: 11pt;
            font-weight: bold;
            min-height: 18px;
            line-height: 1.5;
            word-break: break-word;
        }
        .handwriting {
            font-family: "Times New Roman", serif;
            font-weight: normal;
            white-space: pre-wrap;
        }
        .header-cells td {
            border-bottom: 2px solid #000;
        }
        .kv {
            margin-bottom: 8px;
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
                    <td style="width: 65%; vertical-align: top;">
                        <div class="kv">
                            <span class="label">Tujuan Surat</span>
                            <div class="value handwriting">{{ $surat->tujuan }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Nomor Surat</span>
                            <div class="value handwriting">{{ $surat->no_surat }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Tanggal Surat</span>
                            <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_keluar)->format('d F Y') }}</div>
                        </div>
                    </td>
                    <td style="width: 35%; vertical-align: top;">
                        <div class="kv">
                            <span class="label">Dari / Pengolah</span>
                            <div class="value handwriting">{{ $surat->pengolah ?? '-' }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Lampiran</span>
                            <div class="value handwriting">-</div>
                        </div>
                        <div class="kv">
                            <span class="label">Sifat</span>
                            <div class="value handwriting">
                                @if($disposisi && $disposisi->sifat)
                                    {{ $disposisi->sifat }}
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 70px;">
                        <span class="label">Diteruskan Kepada</span>
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
                    <td colspan="4" style="height: 90px;">
                        <span class="label">Instruksi / Catatan</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->instruksi_pilihan)
                                @foreach($disposisi->instruksi_pilihan as $pilihan)
                                    <div>✓ {{ $pilihan }}</div>
                                @endforeach
                            @endif
                            @if($disposisi && $disposisi->isi_disposisi)
                                <div>{{ $disposisi->isi_disposisi }}</div>
                            @endif
                            @if($disposisi && $disposisi->catatan)
                                <div style="margin-top: 5px; font-style: italic;">"{{ $disposisi->catatan }}"</div>
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

            <div style="margin-top: 20px; text-align: right; padding-right: 20px;">
                <div style="display: inline-block; text-align: center;">
                    <div style="font-size: 10pt; margin-bottom: 5px;">Nama Jabatan Paraf dan Tanggal</div>
                    @if(isset($disposisi) && $disposisi->ttd_image)
                        <img src="{{ asset('storage/' . $disposisi->ttd_image) }}" alt="TTD" style="height: 60px; margin: 5px 0;">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div style="font-weight: bold; text-decoration: underline;">Nama</div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
