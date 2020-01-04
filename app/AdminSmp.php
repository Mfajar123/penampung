<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class AdminSmp extends \Eloquent implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'm_admin_smp';
    
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username', 'password', 'nama', 'tmp_lahir', 'tgl_lahir', 'jenkel', 'agama', 'alamat', 'no_telp', 'foto_profil', 'remember_token', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'is_delete'
    ];

    public function role()
    {
        return $this->hasMany('App\Role', 'id_admin');
    }
}
