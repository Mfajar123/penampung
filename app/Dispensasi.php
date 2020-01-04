<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Dispensasi extends model

{



    protected $table = 'tbl_dispensasi';

    
    protected $primaryKey = 'id_dispensasi';

    public $timestamps = false;



    protected $fillable = [
    
         'id_daftar', 'nim', 'tanggal_akan_bayar', 'nominal_akan_bayar', 'jenis_pembayaran', 'tanggal_bayar', 'id_tahun_akademik', 'bulan', 'status', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date', 'is_delete'

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

    function mahasiswa()
    {
        return $this->belongsTo('App\Mahasiswa', 'nim');
    }

}

