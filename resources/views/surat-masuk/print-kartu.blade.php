<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Surat Masuk - {{ $surat->no_surat }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }
        @media print {
            .no-print { display: none; }
        }
        html, body {
            height: 100%;
        }
        body {
            margin: 0;
        }
        .container, table, tr, td {
            page-break-inside: avoid;
        }
        .print-wrapper {
            width: 100%;
        }
        body {
            font-family: {{ isset($pdf) ? '"Times", serif' : '"Times New Roman", serif' }};
            font-size: {{ isset($pdf) ? '9pt' : '9.5pt' }};
            margin: 0;
            padding: {{ isset($pdf) ? '5px' : '8px' }};
        }
        .container {
            border: 1px solid #000;
            position: relative;
            width: 100%;
            page-break-inside: avoid;
            height: 100%;
        }
        .content table { border-left: 0; border-top: 0; }
        .content tr:first-child td { border-top: 0; }
        @if(!isset($pdf))
        .header-side {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 40px;
            border-right: 1px solid #000;
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
            margin-left: 40px;
        }
        @else
        .header-side {
            float: left;
            width: 40px;
            border-right: 1px solid #000;
            text-align: center;
            position: relative;
        }
        .header-side h2 {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-size: 12pt;
            margin: 10px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .content {
            margin-left: 40px;
        }
        @endif
        .header-top {
            text-align: center;
            padding: {{ isset($pdf) ? '4px 8px 4px' : '5px 8px 5px' }};
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
            padding: {{ isset($pdf) ? '4px 5px' : '4px 6px' }};
            vertical-align: top;
        }
        .label {
            font-size: {{ isset($pdf) ? '8pt' : '8.5pt' }};
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
            letter-spacing: 0.2px;
        }
        .value {
            font-size: {{ isset($pdf) ? '10pt' : '10.5pt' }};
            font-weight: bold;
            min-height: 18px;
            line-height: {{ isset($pdf) ? '1.35' : '1.4' }};
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
        .title-disposisi {
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 16px; font-size: 15px; cursor: pointer; background:#000; color:#fff; border-radius:4px; border:none;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 16px; font-size: 15px; cursor: pointer;">Tutup</button>
    </div>

    <div class="print-wrapper">
        <div class="container">
            <div class="header-side">
                @if(isset($pdf))
                <div class="vertical-text" style="font-weight:bold;font-size:12pt;text-align:center;position:absolute;top:50%;left:0;right:0;transform:translateY(-50%);">
                    L<br>E<br>M<br>B<br>A<br>R<br>&nbsp;<br>D<br>I<br>S<br>P<br>O<br>S<br>I
                </div>
                @else
                <h2></h2>
                @endif
            </div>
            <div class="content">
                <div class="header-top">
                    <table class="header-top-table">
                        <tr>
                            <td class="header-top-logo" style="text-align: center;">
                                <img src="{{ isset($pdf) ? public_path('img/logo.jpg') : asset('img/logo.jpg') }}" alt="Logo" style="height: {{ isset($pdf) ? '30px' : '36px' }};">
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
                    <td colspan="6" style="min-height: {{ isset($pdf) ? '0' : '30px' }};"></td>
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
                    <td colspan="2" style="min-height: {{ isset($pdf) ? '50px' : '60px' }};">
                        <span class="label">Hal / Isi Ringkas</span>
                        <div class="value handwriting">{{ $surat->perihal }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="min-height: {{ isset($pdf) ? '50px' : '60px' }};">
                        <span class="label">Diteruskan kepada sdr :</span>
                        <div class="value handwriting">
                            @if($disposisi && $disposisi->tujuan_disposisi)
                                <div>✓ {{ $disposisi->tujuan_disposisi }}</div>
                            @else
                                <div>&nbsp;</div>
                            @endif
                        </div>
                    </td>
                    <td style="min-height: {{ isset($pdf) ? '50px' : '60px' }};">
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
                    <td colspan="2" style="min-height: {{ isset($pdf) ? '50px' : '60px' }};">
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
                        <img src="{{ isset($pdf) ? public_path('storage/' . $disposisi->ttd_image) : asset('storage/' . $disposisi->ttd_image) }}" alt="TTD" style="height: {{ isset($pdf) ? '50px' : '60px' }}; margin: 5px 0;">
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
