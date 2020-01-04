<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 't_jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
    	'tahun_akademik', 'id_prodi', 'hari', 'id_semester', 'id_kelas', 'id_matkul', 'jam_mulai', 'jam_selesai', 'id_waktu_kuliah', 'id_dosen', 'id_ruang', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];
    public $timestamps = false;
    function tahun_akademik()
    {
    	return $this->belongsTo('App\TahunAkademik', 'tahun_akademik');
    }
    function prodi()
    {
    	return $this->belongsTo('App\Prodi', 'id_prodi');
    }
    function semester()
    {
    	return $this->belongsTo('App\Semester', 'id_semester');
    }
    function kelas()
    {
    	return $this->belongsTo('App\Kelas', 'id_kelas');
    }
    function matkul()
    {
    	return $this->belongsTo('App\Matkul', 'id_matkul');
    }
    function dosen()
    {
    	return $this->belongsTo('App\Dosen', 'id_dosen');
    }
    function ruang()
    {
    	return $this->belongsTo('App\Ruang', 'id_ruang');
    }
    function waktu_kuliah()
    {
        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');
    }
    function krs_item()
    {
        return $this->hasOne('Aoo\KRSItem', 'id_jadwal');
    }
}
