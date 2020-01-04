<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 't_tahun_akademik';
    protected $primaryKey = 'id_tahun_akademik';
    protected $fillable = [
      'tahun_akademik', 'semester', 'keterangan', 'status', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];
    public $timestamps = false;
    
    function jadwal()
    {
    	return $this->hasOne('App\Jadwal', 'id_tahun_akademik');
    }
    
    function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran', 'id_tahun_akademik');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai', 'id_tahun_akademik');
    }
}
