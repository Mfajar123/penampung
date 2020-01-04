<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenPendidikan extends Model
{
    protected $table = 'm_dosen_pendidikan';
    public $timestamps = false;
    protected $fillable = [
        'nip', 'jenjang', 'nama_sekolah', 'jurusan', 'gelar', 'konsentrasi'
    ];
    function dosen()
    {
    	return $this->belongsTo('App\Dosen', 'nip');
    }
}
