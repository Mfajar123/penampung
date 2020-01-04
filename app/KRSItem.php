<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRSItem extends Model
{
    protected $table = 't_krs_item';
    protected $primaryKey = 'id_krs_item';
    protected $fillable = [
    	'id_krs', 'id_matkul', 'id_kelas', 'is_repeat', 'is_repeat_approved'
    ];
    public $timestamps = false;

    public function krs()
    {
        return $this->belongsTo('App\KRS', 'id_krs');
    }
    public function matkul()
    {
        return $this->belongsTo('App\Matkul', 'id_matkul');
    }
    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }
}
