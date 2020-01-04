<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shared_material extends Model
{
    protected $table = 't_shared_material';

    protected $primaryKey = 'id_shared_material';

    public $timestamps = false;

    protected $fillable = [
        'id_dosen', 'id_prodi', 'nama_materi', 'file'
    ];
}
