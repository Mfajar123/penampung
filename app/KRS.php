<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRS extends Model
{
    protected $table = 't_krs';
    protected $primaryKey = 'id_krs';
    protected $fillable = [
    	'nim', 'tahun_akademik', 'id_semester', 'id_waktu_kuliah', 'total_sks', 'file_surat', 'status', 'keterangan', 'is_delete'
    ];
    public $timestamps = false;	
    public function mahasiswa()
    {
        return $this->belongsTo('App\Mahasiswa', 'nim');
    }
    public function tahun_akademik()
    {
        return $this->belongsTo('App\TahunAkademik', 'tahun_akademik');
    }
    public function semester()
    {
        return $this->belongsTo('App\Semester', 'id_semester');
    }
    public function krs_item()
    {
        return $this->hasMany('App\KRSItem', 'id_krs');
    }
}
