<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleLink extends Model
{
    
    protected $table = 'm_role_link';

    protected $primaryKey = 'id_role_link';

    public $timestamps = false;

    protected $fillable = [
        'id_role', 'id_menu', 'can_access', 'can_create', 'can_modify', 'can_delete', 'see_restricted'
    ];

}
