<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'm_menu';

    protected $primaryKey = 'id_menu';

    public $timestamps = false;

    protected $fillable = [
        'id_menu', 'parent_id_1', 'parent_id_2', 'parent_id_3', 'menu_type', 'menu_position', 'nama_menu', 'link_menu', 'icon_menu', 'input_by', 'input_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete'
    ];

    public function menu_role()
    {
        return $this->belongsToMany('App\Menu_role', 'menu_role_akses', 'id_menu', 'id_menu_role');
    }
    
}
