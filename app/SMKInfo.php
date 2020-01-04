<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class SMKInfo extends model

{

    protected $table = 'm_info_smk';

    protected $primaryKey = 'id_info';

    public $timestamps = false;



    protected $fillable = [

        'id_info', 'judul_info', 'ringkasan_info', 'waktu_info', 'isi_info', 'foto_info', 'sumber_info', 'id_kategori_info' ,'create_by', 'create_date', 'update_by', 'update_date', 'delete_by', 'delete_date', 'is_delete' ];



    function SMKKategoriInfo()

    {

        return $this->belongsTo('App\SMKKategoriInfo', 'id_kategori_info');
        /* 'App/nama_model', 'field relasi'  */

    }


}

