<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi_detail extends Model
{
    protected $table = 't_absensi_detail';

    protected $primaryKey = 'id_absensi_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_jadwal', 'id_matkul', 'id_kelas', 'id_semester', 'id_dosen', 'tanggal', 'catatan_dosen'
    ];
}
