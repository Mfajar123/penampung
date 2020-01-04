<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahasiswaPekerjaan extends Model
{
    protected $table = 'm_mahasiswa_pekerjaan';
    
    public $timestamps = false;

    protected $fillable = [
        'nim', 'perusahaan', 'posisi', 'alamat_perusahaan'
    ];

    function mahasiswa()
    {
    	return $this->belongTo('App\Mahasiswa', 'nim');
    }
}