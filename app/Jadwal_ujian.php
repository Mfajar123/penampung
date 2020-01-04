<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_ujian extends Model
{
    protected $table = 't_jadwal_ujian';

    protected $primaryKey = 'id_jadwal_ujian';

    public $timestamps = false;

    protected $fillable = [
        'id_tahun_akademik', 'jenis_ujian'
    ];

    public function tahun_akademik()
    {
        return $this->belongsTo('App\TahunAkademik', 'id_tahun_akademik');
    }

    public function jadwal_ujian_detail()
    {
        return $this->hasMany('App\Jadwal_ujian_detail', 'id_jadwal_ujian');
    }
}
