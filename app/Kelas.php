<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'm_kelas';
    
    protected $primaryKey = 'id_kelas';

    public $timestamps = false;

    protected $fillable = [
        'id_semester', 'id_prodi', 'tahun_akademik', 'kode_kelas', 'nama_kelas', 'id_waktu_kuliah', 'kapasitas', 'created_date', 'created_by', 'updated_by', 'updated_date', 'deleted_date', 'deleted_by', 'is_delete'
    ];

    public function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa', 'id_kelas');
    }

    function jadwal()
    {
        return $this->hasMany('App\Jadwal', 'id_kelas');
    }
    function waktu_kuliah()
    {
        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');
    }
    public function kelas_detail()
    {
        return $this->hasMany('App\KelasDetail', 'id_kelas');   
    }
    function semester()
    {
        return $this->belongsTo('App\Semester', 'id_semester');
    }
    function tahun_akademik()
    {
        return $this->belongsTo('App\TahunAkademik', 'tahun_akademik');
    }
    public function akademik_tahun()
    {
        return $this->belongsTo('App\TahunAkademik', 'tahun_akademik');
    }
    function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai', 'id_kelas');
    }
    
    public function kelas_detail_remedial()
    {
        return $this->hasMany('App\KelasDetailRemedial', 'id_kelas');
    }
}
