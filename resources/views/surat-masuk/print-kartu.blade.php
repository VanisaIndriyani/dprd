<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Masuk - {{ $surat->no_surat }}</title>
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
            font-family: Arial, sans-serif;
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
        .header-top {
            text-align: center;
            padding: 8px 12px 6px;
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
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Kartu</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <div class="print-wrapper">
        <div class="container">
            <div class="header-side">
                <h2>Lembar Disposisi</h2>
            </div>
            <div class="content">
                <div class="header-top">
                    <table class="header-top-table">
                        <tr>
                            <td class="header-top-logo" style="text-align: center;">
                                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="height: 40px;">
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
                    <td colspan="2" style="width: 30%;">
                        <span class="label">Diterima Tgl</span>
                        <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_terima)->format('d F Y') }}</div>
                    </td>
                    <td colspan="2" style="width: 40%;">
                        <span class="label">No Agenda</span>
                        <div class="value handwriting">{{ $surat->no_agenda ?? '-' }}</div>
                    </td>
                    <td colspan="2" style="width: 30%;">
                        <span class="label">Sifat</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->sifat)
                                {{ $disposisi->sifat }}
                            @else
                                &nbsp;
                            @endif
                        </div>
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
                    <td colspan="6" style="height: 60px;">
                        <span class="label">Instruksi / Harap</span>
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
                            @endif
                        </div>
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
