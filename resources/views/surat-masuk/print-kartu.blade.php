<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Masuk - {{ $surat->no_surat }}</title>
    <style>
        @media print {
            @page {
                size: A5 landscape;
                margin: 10mm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            border: 2px solid #000;
            padding: 0;
            position: relative;
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
            padding: 5px 8px;
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
            font-size: 12pt;
        }
        .handwriting {
            font-family: 'Courier New', Courier, monospace; /* Fallback for handwriting style */
            font-size: 14pt;
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
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Kartu</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <div class="container">
        <div class="header-side">
            <h2>Kartu Surat Masuk</h2>
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
                        <div class="value handwriting">{{ $surat->no_agenda ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 80px;">
                        <span class="label">Isi Ringkas</span>
                        <div class="value handwriting">{{ $surat->perihal }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <span class="label">Dari</span>
                        <div class="value handwriting">{{ $surat->pengirim }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 30%;">
                        <span class="label">Tanggal Surat</span>
                        <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_surat)->format('d F Y') }}</div>
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
                            @if($disposisi)
                                {{ $disposisi->tujuan_disposisi }}
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Tgl. Diteruskan</span>
                        <div class="value handwriting">
                            @if($disposisi)
                                {{ \Carbon\Carbon::parse($disposisi->created_at)->format('d F Y') }}
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Tanda Terima</span>
                        <div class="value">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="height: 40px;">
                        <span class="label">Catatan</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->catatan)
                                {{ $disposisi->catatan }}
                            @endif
                        </div>
                    </td>
                    <td colspan="2">
                        <span class="label">Lembar</span>
                        <div class="value">&nbsp;</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>