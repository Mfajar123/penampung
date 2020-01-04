<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_spp extends Model
{
    protected $table = 't_pembayaran_spp';

    protected $primaryKey = 'id_pembayaran_spp';

    public $timestamps = false;

    protected $fillable = [
        'id_admin', 'nim', 'id_tahun_akademik', 'bulan', 'tanggal_pembayaran', 'bayar', 'keterangan', 'id_dispensasi'
    ];
}
