<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 't_nilai';

    protected $primaryKey = 'id_nilai';

    public $timestamps = false;

    protected $fillable = [
        'id_dosen', 'id_tahun_akademik', 'id_kelas', 'id_matkul'
    ];

    public function dosen()
    {
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

    public function tahun_akademik()
    {
        return $this->belongsTo('App\TahunAkademik', 'id_tahun_akademik');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }

    public function matkul()
    {
        return $this->belongsTo('App\Matkul', 'id_matkul');
    }

    public function nilai_mahasiswa()
    {
        return $this->hasMany('App\Nilai_mahasiswa', 'id_nilai');
    }
}
