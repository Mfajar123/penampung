<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendaftaranNilai extends Model
{
    protected $table = 'tbl_daftar_nilai';

    public $timestamps = false;

    protected $fillable = [
        'id_daftar', 'nilai', 'status'
    ];

    function pendaftaran()
    {
    	return $this->belongsTo('App\Pendaftaran', 'id_daftar');
    }
}
