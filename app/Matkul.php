<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'm_matkul';

    protected $primaryKey = 'id_matkul';

    protected $fillable = [
        'id_prodi', 'id_semester', 'id_jenjang', 'id_kompetensi', 'kode_matkul', 'nama_matkul', 'sks', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];

    public $timestamps = false;

    function prodi()
    {
    	return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    function semester()
    {
    	return $this->belongsTo('App\Semester', 'id_semester');
    }

    function jenjang()
    {
        return $this->belongsTo('App\Jenjang', 'id_jenjang');
    }

    function kompetensi()
    {
        return $this->belongsTo('App\Kompetensi', 'id_kompetensi');
    }
    
    function jadwal()
    {
        return $this->hasOne('App\Jadwal', 'id_matkul');
    }
    
    function khs()
    {
        return $this->hasMany('App\KHS', 'kode_matkul');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai', 'id_matkul');
    }
}
