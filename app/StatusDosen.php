<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusDosen extends Model
{
    protected $table = 'm_dosen_status';
    
    protected $primaryKey = 'id_status';

    public $timestamps = false;

    protected $fillable = [
        'id_status', 'nama_Status'
    ];

    function dosen()
    {
    	return $this->hasMany('App\Dosen', 'id_status');
    }
}
