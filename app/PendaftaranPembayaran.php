<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class PendaftaranPembayaran extends model

{



    protected $table = 'tbl_daftar_pembayaran';

    
    protected $primaryKey = 'id_daftar_pembayaran';

    public $timestamps = false;



    protected $fillable = [
    
         'id_daftar', 'id_daftar_kategori', 'status_pembayaran'

    ];



    function pendaftaran()

    {

        return $this->belongsTo('App\Pendaftaran', 'id_daftar');

    }



    function kategori()

    {

        return $this->belongsTo('App\KategoriPembayaran', 'id_daftar_kategori');

    }

     function detail()

    {

        return $this->belongsTohasMany('App\PendaftaranPembayaranDetail', 'id_daftar_pembayaran');

    }

}

