<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai_mahasiswa extends Model
{
    protected $table = 't_nilai_mahasiswa';

    public $timestamps = false;

    protected $fillable = [
        'id_nilai', 'nim', 'tugas', 'uts', 'uas'
    ];

    public function nilai()
    {
        return $this->belongsTo('App\Nilai', 'id_nilai');
    }
}
