<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Dosen extends \Eloquent implements Authenticatable    
{
    use AuthenticableTrait;
    protected $table = 'm_dosen';
    protected $primaryKey = 'id_dosen';
    public $timestamps = false;
    protected $fillable = [
        'nip','password', 'nidn', 'gelar_depan', 'nama', 'gelar_belakang', 'id_dosen_jabatan', 'id_prodi', 'status_dosen', 'no_skyys', 'tgl_skyys', 'tempat_lahir', 'tgl_lahir', 'warga_negara', 'jenis_kelamin', 'status_pernikahan', 'agama', 'alamat', 'no_telp', 'no_hp', 'email', 'foto_profil', 'tgl_berhenti', 'remember_token', 'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete', 'auth'
    ];
    function pendidikan()
    {
    	return $this->hasOne('App\DosenPendidikan', 'nip');
    }
    function jabatan()
    {
        return $this->belongsTo('App\DosenJabatan', 'id_dosen_jabatan');
    }
    function prodi()
    {
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }
    function jadwal()
    {
        return $this->hasOne('App\Jadwal', 'id_matkul');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai', 'id_dosen');
    }
}
