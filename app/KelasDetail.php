<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class KelasDetail extends Model

{

    protected $table = 'm_kelas_detail';

    

    protected $primaryKey = 'id_kelas_detail';



    public $timestamps = false;



    protected $fillable = [

        'id_kelas', 'nim', 'no_absen'

    ];



    public function mahasiswa()

    {

        return $this->belongsTo('App\Mahasiswa', 'nim');

    }

    function kelas()

    {

        return $this->belongsTo('App\Kelas', 'id_kelas');

    }

}

