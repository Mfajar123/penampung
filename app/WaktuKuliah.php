<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaktuKuliah extends Model
{
    protected $table = 'tbl_waktu_kuliah';
    protected $primaryKey = 'id_waktu_kuliah';
    protected $fillable = [
      'nama_waktu_kuliah'
    ];
    public $timestamps = false;

    function pendaftaran()
    {
    	return $this->hasMany('App\Pendaftaran', 'id_waktu_kuliah');
    }
    
    function jadwal()
    {
        return $this->belongsTo('App\Jadwal', 'id_waktu_kuliah');
    }
    
    function kelas()
    {
        return $this->hasOne('App\Kelas', 'id_waktu_kuliah');
    }
    
    function kategori_pembayaran()
    {
        return $this->hasMany('App\KategoriPembayaran', 'id_waktu_kuliah');
    }

    function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa', 'id_waktu_kuliah');
    }
}
