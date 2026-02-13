<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->string('ttd_nama')->nullable()->after('catatan');
            $table->string('ttd_jabatan')->nullable()->after('ttd_nama');
            $table->date('ttd_tanggal')->nullable()->after('ttd_jabatan');
            $table->json('instruksi_pilihan')->nullable()->after('isi_disposisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropColumn(['ttd_nama', 'ttd_jabatan', 'ttd_tanggal', 'instruksi_pilihan']);
        });
    }
};
