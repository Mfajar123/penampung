<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'm_promo';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
      'nama_promo', 'diskon', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];
    public $timestamps = false;
    
    function pendaftaran()
    {
    	return $this->hasMany('App\Pendaftaran', 'id_promo');
    }
}
