<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 't_absensi';

    protected $primaryKey = 'id_absensi';

    public $timestamps = false;

    protected $fillable = [
        'id_jadwal', 'id_matkul', 'id_kelas', 'id_dosen', 'id_semester', 'tanggal', 'nim', 'keterangan', 'notes', 'pertemuan_ke'
    ];
}
