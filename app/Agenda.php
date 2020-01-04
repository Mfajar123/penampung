<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'm_agenda';

    protected $primaryKey = 'id_agenda';

    public $timestamps = false;
    
    protected $fillable = [
        'judul', 'tanggal_mulai', 'tanggal_selesai', 'created_by', 'created_date', 'updated_by',' updated_date', 'deleted_by', 'deleted_date', 'is_delete'
    ];
}
