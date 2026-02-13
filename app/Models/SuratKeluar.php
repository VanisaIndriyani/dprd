<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_surat',
        'pengolah',
        'tujuan',
        'perihal',
        'tgl_keluar',
        'status',
        'file_path',
    ];

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }
}
