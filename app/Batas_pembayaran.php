<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batas_pembayaran extends Model
{
    protected $table = 'm_batas_pembayaran';

    public $timestamps = false;

    protected $fillable = [
        'jenis_pembayaran', 'bulan', 'semester', 'jenis_ujian', 'created_by', 'created_date',
        'updated_by', 'updated_date'
    ];
}
