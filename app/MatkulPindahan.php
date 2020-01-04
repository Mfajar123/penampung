<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatkulPindahan extends Model
{
    protected $table = 'tbl_matkul_pindahan';

    protected $primaryKey = 'id_matkul_pindahan';

    protected $fillable = [
        'nim', 'id_matkul',  'sks',  'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date', 'is_delete'
    ];

    public $timestamps = false;
}
