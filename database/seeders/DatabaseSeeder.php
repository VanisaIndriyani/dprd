<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Surat Masuk
        $sm1 = \App\Models\SuratMasuk::create([
            'no_surat' => 'SM/2026/001',
            'pengirim' => 'Dinas Pendidikan Sumsel',
            'perihal' => 'Undangan Rapat Koordinasi',
            'tgl_terima' => now()->subDays(2),
            'status' => 'Menunggu Disposisi'
        ]);

        $sm2 = \App\Models\SuratMasuk::create([
            'no_surat' => 'SM/2026/002',
            'pengirim' => 'Gubernur Sumsel',
            'perihal' => 'Laporan Anggaran 2025',
            'tgl_terima' => now()->subDays(1),
            'status' => 'Disposisi'
        ]);
        
        // Seed Disposisi for SM2
        \App\Models\Disposisi::create([
            'surat_masuk_id' => $sm2->id,
            'tujuan_disposisi' => 'Kabag Keuangan',
            'isi_disposisi' => 'Segera pelajari dan tindak lanjuti',
            'batas_waktu' => now()->addDays(3),
            'status' => 'Pending',
            'catatan' => 'Penting!'
        ]);

        \App\Models\SuratMasuk::create([
            'no_surat' => 'SM/2026/003',
            'pengirim' => 'Kementerian Dalam Negeri',
            'perihal' => 'Peraturan Baru DPRD',
            'tgl_terima' => now(),
            'status' => 'Arsip'
        ]);

        // Seed Surat Keluar
        \App\Models\SuratKeluar::create([
            'no_surat' => 'SK/2026/001',
            'tujuan' => 'Walikota Palembang',
            'perihal' => 'Balasan Undangan',
            'tgl_keluar' => now()->subDays(5),
            'status' => 'Dikirim'
        ]);

        \App\Models\SuratKeluar::create([
            'no_surat' => 'SK/2026/002',
            'tujuan' => 'Dinas PUPR',
            'perihal' => 'Permohonan Data Jalan',
            'tgl_keluar' => now(),
            'status' => 'Draft'
        ]);
    }
}
