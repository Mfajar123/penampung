<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class upload_skpi extends Model
{
    protected $table = "upload_skpi";
 
    protected $fillable = ['nim','sertifikat_ospek','sertifikat_seminar','sertifikat_bnsp'];
}
