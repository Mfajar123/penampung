<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $table = 'tbl_kompetensi';
    
    protected $primaryKey = 'id_kompetensi';

    public $timestamps = false;

    protected $fillable = [
        'nama_kompetensi'
    ];

    function matkul()
    {
    	return $this->hasMany('App\Matkul', 'id_kompetensi');
    }
}
