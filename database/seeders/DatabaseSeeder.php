<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // ==========================================
        // SURAT MASUK (2 Data: 1 Pending, 1 Disposisi)
        // ==========================================

        // Surat Masuk 1: Belum Disposisi (Pending)
        SuratMasuk::create([
            'no_agenda' => 'AGD/001/2026',
            'no_surat' => 'SM/2026/001',
            'pengirim' => 'Dinas Pendidikan Kota Palembang',
            'perihal' => 'Undangan Sosialisasi Kurikulum Baru',
            'tgl_surat' => now()->subDays(2),
            'tgl_terima' => now()->subDays(1),
            'status' => 'Menunggu Disposisi'
        ]);

        // Surat Masuk 2: Sudah Disposisi
        $sm2 = SuratMasuk::create([
            'no_agenda' => 'AGD/002/2026',
            'no_surat' => 'SM/2026/002',
            'pengirim' => 'Badan Kepegawaian Daerah',
            'perihal' => 'Pemberitahuan Kenaikan Pangkat Berkala',
            'tgl_surat' => now()->subDays(5),
            'tgl_terima' => now()->subDays(4),
            'status' => 'Disposisi'
        ]);

        // Disposisi untuk Surat Masuk 2
        Disposisi::create([
            'surat_masuk_id' => $sm2->id,
            'tujuan_disposisi' => 'Kasubbag Umum',
            'sifat' => 'Penting',
            'isi_disposisi' => 'Mohon segera didata pegawai yang naik pangkat tahun ini.',
            'batas_waktu' => now()->addDays(3),
            'status' => 'Selesai',
            'catatan' => 'Lakukan koordinasi dengan BKD Provinsi.'
        ]);


        // ==========================================
        // SURAT KELUAR (2 Data: 1 Pending, 1 Disposisi)
        // ==========================================

        // Surat Keluar 1: Belum Disposisi (Draft/Pending)
        SuratKeluar::create([
            'no_surat' => 'SK/2026/001',
            'tujuan' => 'Walikota Palembang',
            'perihal' => 'Permohonan Audiensi',
            'tgl_keluar' => now(),
            'status' => 'Draft'
        ]);

        // Surat Keluar 2: Sudah Disposisi (Ada instruksi pimpinan)
        $sk2 = SuratKeluar::create([
            'no_surat' => 'SK/2026/002',
            'tujuan' => 'Dinas PUPR',
            'perihal' => 'Laporan Kerusakan Jalan Protokol',
            'tgl_keluar' => now()->subDays(2),
            'status' => 'Disetujui'
        ]);

        // Disposisi untuk Surat Keluar 2
        Disposisi::create([
            'surat_keluar_id' => $sk2->id,
            'tujuan_disposisi' => 'Staff Tata Usaha', // Biasanya disposisi SK ke pembuat surat/TU
            'sifat' => 'Biasa',
            'instruksi_pilihan' => ['Proses lebih lanjut', 'Koordinasi/Konfirmasikan'],
            'isi_disposisi' => '-', // SK biasanya pakai checklist
            'catatan' => 'Pastikan data lampiran sudah lengkap sebelum dikirim.',
            'ttd_nama' => 'H. Pimpinan, S.Sos, M.Si',
            'ttd_jabatan' => 'Sekretaris DPRD',
            'ttd_tanggal' => now()->subDays(1),
            'status' => 'Selesai'
        ]);
    }
}
