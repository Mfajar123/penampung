<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'tbl_provinsi';
    
    protected $primaryKey = 'id_provinsi';

    public $timestamps = false;

    protected $fillable = [
        'id_provinsi', 'kode_provinsi', 'nama_provinsi'
    ];

    function mahasiswa()
    {
    	return $this->hasMany('App\Mahasiswa', 'id_prov');
    }
    
    function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran', 'id_provinsi');
    }
    
    function mahasiswa_sekolah()
    {
        return $this->hasMany('App\Provinsi', 'id_provinsi');
    }
}
