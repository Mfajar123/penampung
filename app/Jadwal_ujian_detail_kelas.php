<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_ujian_detail_kelas extends Model
{
    protected $table = 't_jadwal_ujian_detail_kelas';

    public $timestamps = false;

    protected $fillable = [
        'id_jadwal_ujian_detail', 'id_kelas'
    ];

    public function jadwal_ujian_detail()
    {
        return $this->belongsTo('App\Jadwal_ujian_detail', 'id_jadwal_ujian_detail');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }
}
