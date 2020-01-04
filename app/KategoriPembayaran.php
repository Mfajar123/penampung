<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends model
{

    protected $table = 'tbl_daftar_kategori';
    
    protected $primaryKey = 'id_daftar_kategori';

    protected $fillable = [
        'tahun_akademik', 'id_prodi', 'id_waktu_kuliah', 'kode_kategori', 'nama_kategori', 'biaya', 'minimal_biaya', 'potongan', 'nilai_terendah', 'nilai_tertinggi', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'is_delete'
    ];

    function waktu_kuliah()
    {
        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');
    }

    function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }
    
    function pembayaran()
    {
        return $this->hasMany('App\PendaftaranPembayaran', 'id_daftar_kategori');
    }
}
