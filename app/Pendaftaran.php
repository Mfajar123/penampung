<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Pendaftaran extends \Eloquent implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'tbl_daftar';
    
    protected $primaryKey = 'id_daftar';

    protected $fillable = [
        'id_daftar', 'nama', 'no_telp', 'alamat', 'id_provinsi', 'id_waktu_kuliah', 'tahun_akademik', 'tanggal_lahir', 'tempat_lahir', 'id_prodi', 'id_jenjang', 'id_promo', 'status_bayar', 'bayar', 'registration', 'id_status', 'transkrip', 'tanggal_pembayaran', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'is_delete'
    ];

    function provinsi()
    {
    	return $this->belongsTo('App\Provinsi', 'id_provinsi');
    }

    function waktu_kuliah()
    {
        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');
    }

    function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    function jenjang()
    {
        return $this->belongsTo('App\Jenjang', 'id_jenjang');
    }

    function promo()
    {
        return $this->belongsTo('App\Promo', 'id_promo');
    }

    function nilai()
    {
        return $this->hasOne('App\PendaftaranNilai','id_daftar');
    }

    function pembayaran()
    {
        return $this->hasOne('App\PendaftaranPembayaran', 'id_daftar');
    }

    function status()
    {
        return $this->belongsTo('App\MahasiswaStatus', 'id_status');
    }

    
}
