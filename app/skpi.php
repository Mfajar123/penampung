<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class skpi extends Model
{
    protected $table ='skpi';
    protected $fillable = ['id','nim','sertifikat_ospek','sertifikat_seminar','sertifikat_bnsp'];
}
