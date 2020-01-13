<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formulir_judul extends Model
{
    protected $table ='judul_skripsi';
    protected $fillable = ['id','nim','nama','prodi','judul1','judul2','judul3'];
}
