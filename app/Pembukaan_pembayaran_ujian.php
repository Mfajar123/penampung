<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembukaan_pembayaran_ujian extends Model
{
    protected $table = 's_pembukaan_pembayaran_ujian';

    protected $primaryKey = 'id_pembukaan_pembayaran_ujian';

    public $timestamps = false;

    protected $fillable = [
        'jenis_ujian', 'tanggal_mulai', 'tanggal_selesai'
    ];
}
