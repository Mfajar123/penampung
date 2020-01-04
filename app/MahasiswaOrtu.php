<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahasiswaOrtu extends Model
{
    protected $table = 'm_mahasiswa_ortu';
    
    public $timestamps = false;

    protected $fillable = [
        'nim', 'nama_ibu', 'nama_ayah', 'alamat_ortu', 'no_telp_ortu'
    ];

    function mahasiswa()
    {
    	return $this->belongTo('App\Mahasiswa', 'nim');
    }
}