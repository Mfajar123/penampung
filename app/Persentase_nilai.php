<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persentase_nilai extends Model
{
    protected $table = 't_nilai_persentase';

    protected $primaryKey = 'id_nilai_persentase';

    public $timestamps = false;

    protected $fillable = [
        'id_dosen', 'kehadiran', 'tugas', 'uts', 'uas'
    ];

    public function dosen()
    {
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
}
