<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahasiswaStatus extends Model
{
    protected $table = 'tbl_mahasiswa_status';
    
    protected $primaryKey = 'id_status';

    public $timestamps = false;

    protected $fillable = [
        'id_status', 'nama_Status'
    ];

    function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa', 'id_status');
    }
}
