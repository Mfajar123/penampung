<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'tbl_jenjang';
    
    protected $primaryKey = 'id_jenjang';

    public $timestamps = false;

    protected $fillable = [
        'nama_jenjang'
    ];

    function mahasiswa()
    {
    	return $this->hasMany('App\Mahasiswa', 'id_jenjang');
    }

    function matkul()
    {
    	return $this->hasMany('App\Matkul', 'id_jenjang');
    }
    
    function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran', 'id_jenjang');
    }
}
