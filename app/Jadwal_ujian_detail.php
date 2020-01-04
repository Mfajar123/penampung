<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_ujian_detail extends Model
{
    protected $table = 't_jadwal_ujian_detail';

    protected $primaryKey = 'id_jadwal_ujian_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_jadwal_ujian', 'tanggal', 'jam_mulai', 'jam_selesai', 'id_ruang', 'id_matkul'
    ];

    public function jadwal_ujian()
    {
        return $this->belongsTo('App\Jadwal_ujian', 'id_jadwal_ujian');
    }

    public function ruang()
    {
        return $this->belongsTo('App\Ruang', 'id_ruang');
    }
    
    public function matkul()
    {
        return $this->belongsTo('App\Matkul', 'id_matkul');
    }

    public function jadwal_ujian_detail_kelas()
    {
        return $this->hasMany('App\Jadwal_ujian_detail_kelas', 'id_jadwal_ujian_detail');
    }
}
