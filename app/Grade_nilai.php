<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade_nilai extends Model
{
    protected $table = 'm_grade_nilai';

    protected $primaryKey = 'id_grade_nilai';

    public $timestamps = false;

    protected $fillable = [
        'tahun_akademik', 'huruf', 'nilai_min', 'nilai_max', 'bobot'
    ];
}
