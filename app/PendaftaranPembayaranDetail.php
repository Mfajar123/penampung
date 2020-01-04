<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class PendaftaranPembayaranDetail extends model

{



    protected $table = 'tbl_daftar_pembayaran_detail';

    
    protected $primaryKey = 'id_daftar_detail_pembayaran';

    public $timestamps = false;



    protected $fillable = [
    
         'id_daftar_pembayaran', 'bayar_kelulusan', 'pembayaran_ke', 'tanggal_pembayaran',  'is_cancel'

    ];



    function pendaftaran_pembayaran()

    {

        return $this->belongsTo('App\PendaftaranPembayaran', 'id_pembayaran');

    }

    

}

