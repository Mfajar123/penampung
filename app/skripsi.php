<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class skripsi extends Model
{
    protected $table ='skripsi';
    protected $fillable = ['id','nim','nama','prodi','judul1','judul2','judul3','judul_disetujui','dospem1','dospem2','scan_formulir'];
}
