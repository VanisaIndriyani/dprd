<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Keluar - {{ $surat->no_surat }}</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
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
            font-size: 9.5pt;
            margin: 0;
            padding: 8px;
        }
        .container {
            border: 1px solid #000;
            position: relative;
            width: 100%;
            page-break-inside: avoid;
        }
        /* Stabilkan garis tabel: gunakan border default */
        .header-side {
            float: left;
            width: 40px;
            border-right: 1px solid #000;
            text-align: center;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .header-side h2 {
            writing-mode: vertical-rl;
            transform: translateY(-50%) rotate(180deg);
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            font-size: 12pt;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .content {
            margin-left: 40px;
        }
        .header-top {
            text-align: center;
            padding: 5px 8px 5px;
            border-bottom: 1px solid #000;
        }
        .header-top-table {
            width: 100%;
        }
        .header-top-logo {
            width: 15%;
        }
        .header-top-text-main {
            font-size: 11pt;
            font-weight: bold;
        }
        .header-top-text-sub {
            font-size: 9pt;
        }
        .title-disposisi {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 6px;
            margin-bottom: 4px;
            letter-spacing: 1px;
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
        .header-cells td {
            padding: 0;
        }
        .header-cells .label,
        .header-cells .value {
            line-height: 1;
            margin: 0;
        }
        .label {
            font-size: 8.5pt;
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
            letter-spacing: 0.2px;
        }
        .value {
            font-size: 12pt;
            font-weight: bold;
            min-height: 18px;
            line-height: 1.4;
            word-break: break-word;
        }
        .handwriting {
            font-family: "Times New Roman", serif;
            font-weight: normal;
            white-space: pre-wrap;
        }
        .header-cells td {
            border-bottom: 1px solid #000;
        }
        .kv {
            margin-bottom: 8px;
        }
        .header-cells.top-row td {
            padding: 0;
            height: 0;
        }
        .header-cells.top-row .label,
        .header-cells.top-row .value {
            line-height: 1;
            margin: 0;
            font-size: 8pt;
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
          
            <div class="content">
                <div class="header-top">
                    <table class="header-top-table">
                        <tr>
                            <td class="header-top-logo" style="text-align: center;">
                                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="height: 36px;">
                            </td>
                            <td style="text-align: center;">
                                <div class="header-top-text-main">PEMERINTAH PROVINSI SUMATERA SELATAN</div>
                                <div class="header-top-text-main">SEKRETARIAT DPRD</div>
                                <div class="header-top-text-sub">Jln. Kapten A. Rivai Telp. (0711) 313184, 311537, 351272 Palembang 30137</div>
                                <div class="header-top-text-sub">E-mail: info@dprd.sumselprov.go.id &nbsp; Website: dprd.sumselprov.go.id</div>
                            </td>
                        </tr>
                    </table>
                    <div class="title-disposisi">LEMBAR DISPOSISI</div>
                </div>
                <table>
                <tr class="header-cells top-row">
                    <td colspan="3" style="border-right: 1px solid #000; width: 50%; padding: 0; height: 0;"></td>
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
                        <div class="value handwriting">{{ $surat->perihal }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <span class="label">Dari</span>
                        <div class="value handwriting">{{ $surat->pengolah ?? '-' }}</div>
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
                        <span class="label">Pengolah</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->tujuan_disposisi)
                                {{ $disposisi->tujuan_disposisi }}
                            @elseif(!empty($surat->tujuan))
                                {{ $surat->tujuan }}
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
                        <span class="label">Lembar</span>
                        <div class="value handwriting">
                            &nbsp;
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
