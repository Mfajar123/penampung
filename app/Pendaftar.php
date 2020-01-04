<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';

    protected $primaryKey = 'kd_daftar';

    public $incrementing = false;
    
    public $timestamps = false;

    protected $fillable = [
        'kd_daftar', 'nama', 'email', 'no_telp', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tgl_lahir', 'tgl_daftar', 'asal_sekolah', 'id_daftar', 'id_provinsi', 'id_prodi', 'id_waktu_kuliah' , 'id_jenjang'
    ];

    public function daftar()
    {
        return $this->belongsTo('App\Daftar', 'id_daftar');
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Provinsi', 'id_provinsi');
    }

    public function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    public function waktu_kuliah()
    {
        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');
    }

    public function jenjang()
    {
        return $this->belongsTo('App\Jenjang', 'id_jenjang');
    }
}
