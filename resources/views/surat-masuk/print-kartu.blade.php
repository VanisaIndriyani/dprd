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
        .header-top {
            text-align: center;
            padding: 6px 10px 6px;
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
        .title-disposisi {
            letter-spacing: 1px;
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
                    <td style="width: 65%; vertical-align: top;">
                        <div class="kv">
                            <span class="label">Surat dari</span>
                            <div class="value handwriting">{{ $surat->pengirim }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Nomor Surat</span>
                            <div class="value handwriting">{{ $surat->no_surat }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Tanggal Surat</span>
                            <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_surat)->format('d F Y') }}</div>
                        </div>
                    </td>
                    <td style="width: 35%; vertical-align: top;">
                        <div class="kv">
                            <span class="label">Diterima Tgl</span>
                            <div class="value handwriting">{{ \Carbon\Carbon::parse($surat->tgl_terima)->format('d F Y') }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">No Agenda</span>
                            <div class="value handwriting">{{ $surat->no_agenda ?? '-' }}</div>
                        </div>
                        <div class="kv">
                            <span class="label">Sifat</span>
                            <div class="value handwriting">
                                @if($disposisi && $disposisi->sifat)
                                    {{ $disposisi->sifat }}
                                @else
                                    &nbsp;
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 70px;">
                        <span class="label">Hal / Isi Ringkas</span>
                        <div class="value handwriting">{{ $surat->perihal }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="height: 80px;">
                        <span class="label">Diteruskan kepada sdr :</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->tujuan_disposisi)
                                <div>✓ {{ $disposisi->tujuan_disposisi }}</div>
                            @else
                                <div>&nbsp;</div>
                            @endif
                        </div>
                    </td>
                    <td style="height: 80px;">
                        <span class="label">Dengan hormat harap :</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->instruksi_pilihan)
                                @foreach($disposisi->instruksi_pilihan as $pilihan)
                                    <div>✓ {{ $pilihan }}</div>
                                @endforeach
                            @else
                                <div>&nbsp;</div>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 90px;">
                        <span class="label">Catatan</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->catatan)
                                {{ $disposisi->catatan }}
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
