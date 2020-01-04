<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 't_kuesioner';

    protected $primaryKey = 'id_kuesioner';

    public $timestamps = false;

    protected $fillable = [
        'id_kuesioner_form', 'id_dosen', 'nim', 'tahun_akademik', 'id_semester', 'id_matkul', 'id_matkul', 'id_kelas', 'tanggal'
    ];

    public function kuesioner_form()
    {
        return $this->belongsTo('App\Kuesioner_form', 'id_kuesioner_form');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

    public function semester()
    {
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    public function matkul()
    {
        return $this->belongsTo('App\Matkul', 'id_matkul');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }
}
