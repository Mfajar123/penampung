<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasDetailRemedial extends Model
{
    protected $table = 'm_kelas_detail_remedial';

    protected $primaryKey = 'id_kelas_detail_remedial';

    public $timestamps = false;

    protected $fillable = [
        'id_kelas', 'id_matkul', 'nim'
    ];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }

    public function matkul()
    {
        return $this->belongsTo('App\Matkul', 'id_matkul');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Mahasiswa', 'nim');
    }
}
