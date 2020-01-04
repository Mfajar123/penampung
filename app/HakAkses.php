<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'tbl_menu';

    public $timestamps = false;

    protected $fillable = [
        'id_admin', 'm_mahasiswa', 'm_dosen', 'm_karyawan', 'm_matkul'
    ];
}
