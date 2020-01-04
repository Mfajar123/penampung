<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    protected $table = 'm_role';

    protected $primaryKey = 'id_role';

    public $timestamps = false;

    protected $fillable = [
        'id_role', 'role_name', 'level'
    ];

}
