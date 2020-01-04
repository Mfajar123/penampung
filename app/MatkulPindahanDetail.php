<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatkulPindahanDetail extends Model
{
    protected $table = 'tbl_detail_matkul_pindahan';

    protected $primaryKey = 'id_detail_matkul_pindahan';

    protected $fillable = [
        'id_matkul_pindahan', 'id_matkul',  'sks', 'nilai'
    ];

    public $timestamps = false;
}
