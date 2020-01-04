<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahasiswaSekolah extends Model
{
    protected $table = 'm_mahasiswa_sekolah';
    
    public $timestamps = false;

    protected $fillable = [
        'nim', 'pt_asal', 'asal_sekolah', 'no_ijazah', 'jurusan', 'alamat_sekolah', 'kabupaten_sekolah', 'id_provinsi'
    ];

    function mahasiswa()
    {
    	return $this->belongTo('App\Mahasiswa', 'nim');
    }

    function provinsi()
    {
    	return $this->belongsTo('App\Provinsi', 'id_provinsi');
    }
}