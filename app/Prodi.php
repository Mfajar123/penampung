<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'tbl_prodi';
    
    protected $primaryKey = 'id_prodi';

    public $timestamps = false;

    protected $fillable = [
        'id_prodi', 'kode_prodi', 'nama_prodi'
    ];

    function mahasiswa()
    {
    	return $this->hasMany('App\Mahasiswa', 'id_prodi');
    }

    function matkul()
    {
        return $this->hasMany('App\Matkul', 'id_prodi');
    }
    
    function jadwal()
    {
        return $this->hasOne('App\Jadwal', 'id_prodi');
    }
    
    function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran', 'id_prodi');
    }

    function kategori_pembayaran()
    {
        return $this->hasMany('App\KategoriPembayaran', 'id_prodi');
    }
    
    function khs()
    {
        return $this->hasMany('App\KHS', 'id_prodi');
    }
}
