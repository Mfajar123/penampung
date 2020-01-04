<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiayaPindahan extends model
{

    protected $table = 'tbl_biaya_pindahan';
    
    protected $primaryKey = 'id_biaya';

    protected $fillable = [
        'id_biaya','tahun_akademik', 'nama_biaya', 'biaya', 'minimal', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'is_delete'
    ];
}
