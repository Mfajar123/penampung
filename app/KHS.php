<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    protected $table = 't_khs';

    protected $fillable = [
    	'tahun_akademik', 'nim', 'kode_matkul', 'id_prodi', 'id_semester', 'id_kelas', 'id_dosen', 'sts', 'nilai', 'hadir', 'tugas', 'uts', 'uas', 'total', 'bobot', 'transkrip'
    ];

    public $timestamps = false;	

    function mahasiswa()
    {
        return $this->belongsTo('App\Mahasiswa', 'nim');
    }

    function matkul()
    {
        return $this->belongsTo('App\Matkul', 'kode_matkul');
    }

    function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    function semester()
    {
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }
    
    function dosen()
    {
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
}
