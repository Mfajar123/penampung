<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;



class Mahasiswa extends \Eloquent implements Authenticatable

{

    use AuthenticableTrait;



    protected $table = 'm_mahasiswa';

    

    protected $primaryKey = 'id_mahasiswa';



    protected $fillable = [

        'nim', 'password', 'no_ktp', 'nama', 'email', 'tmp_lahir', 'tgl_lahir', 'agama', 'jenkel', 'warga_negara', 'nip', 'tahun_akademik', 'status', 'kelurahan', 'kode_pos', 'kecamatan', 'alamat', 'jalan', 'rt', 'rw', 'id_prov', 'kota', 'provinsi', 'no_telp', 'sumber_biaya', 'foto_profil', 'id_status', 'tahun_masuk', 'id_waktu_kuliah', 'id_prodi', 'id_jenjang', 'id_semester', 'id_daftar', 'isFirstLogin', 'is_disable_spp', 'is_updated_information', 'remember_token', 'created_at', 'updated_at', 'is_delete', 'auth'

    ];



    function statusMahasiswa()

    {

    	return $this->belongsTo('App\MahasiswaStatus', 'id_status');

    }



    function prodi()

    {

        return $this->belongsTo('App\Prodi', 'id_prodi');

    }



    function provinsi()

    {

        return $this->belongsTo('App\Provinsi', 'id_provinsi');

    }



    function sekolah()

    {

        return $this->hasOne('App\MahasiswaSekolah', 'nim');

    }



    function pekerjaan()

    {

        return $this->hasOne('App\MahasiswaPekerjaan', 'nim');

    }



    function ortu()

    {

        return $this->hasOne('App\MahasiswaOrtu', 'nim');

    }



    function semester()

    {

        return $this->belongsTo('App\Semester', 'id_semester');

    }



    function waktu_kuliah()

    {

        return $this->belongsTo('App\WaktuKuliah', 'id_waktu_kuliah');

    }

    

    function jenjang()

    {

        return $this->belongsTo('App\Jenjang', 'id_jenjang');

    }

    

    function khs()

    {

        return $this->hasMany('App\KHS', 'nim');

    }



    public function kelas_detail()

    {

        return $this->hasMany('App\Kelas_detail', 'nim');

    }

}

