<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'tbl_semester';
    
    protected $primaryKey = 'id_semester';

    public $timestamps = false;

    protected $fillable = [
        'id_semester', 'semester_ke'
    ];

    function matkul()
    {
        return $this->hasMany('App\Matkul', 'id_semester');
    }
    
    function jadwal()
    {
        return $this->hasOne('App\Jadwal', 'id_semester');
    }
    
    function mahasiswa()
    {
        return $this->hasOne('App\Mahasiswa', 'id_semester');
    }
    
    function khs()
    {
        return $this->hasMany('App\KHS', 'id_semester');
    }
}
