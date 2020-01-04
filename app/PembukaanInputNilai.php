<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembukaanInputNilai extends Model
{
    protected $table = 's_pembukaan_input_nilai';

    protected $primaryKey = 'id_pembukaan_nilai';

    public $timestamps = false;

    protected $fillable = [
        'tanggal_mulai', 'tanggal_selesai'
    ];
}
