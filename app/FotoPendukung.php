<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class FotoPendukung extends model

{



    protected $table = 'm_foto_pendukung';

    protected $primaryKey = 'id_foto_pendukung';

    public $timestamps = false;



    protected $fillable = [

        'id_info', 'nama_foto', 'tanggal_upload' 
    ];



}

