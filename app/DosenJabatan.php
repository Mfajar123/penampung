<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenJabatan extends Model
{
    protected $table = 'm_dosen_jabatan';
    protected $primaryKey = 'id_dosen_jabatan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'id_dosen_jabatan','nama', 'tunjangan_jabatan', 'tunjangan_sks', 'jumlah_komulatif_maksimal', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];
    function dosen()
    {
    	return $this->hasOne('App\Dosen', 'id_dosen_jabatan');
    }
}
