<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembukaan_krs extends Model
{
    protected $table = 'm_pembukaan_krs';

    protected $primaryKey = 'id_pembukaan_krs';

    public $timestamps = false;

    protected $fillable = [
        'id_prodi', 'tanggal_mulai', 'tanggal_selesai'
    ];
}
