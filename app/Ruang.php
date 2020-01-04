<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'm_ruang';
    protected $primaryKey = 'id_ruang';
    protected $fillable = ['kode_ruang', 'nama_ruang', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'];
    public $timestamps = false;
    function jadwal()
    {
    	return $this->hasOne('App\Jadwal', 'id_ruang');
    }
}
