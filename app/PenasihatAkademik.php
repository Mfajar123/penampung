<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class PenasihatAkademik extends model

{



    protected $table = 'tbl_penasihat_akademik';

    protected $primaryKey = 'id_penasihat_akademik';

    public $timestamps = false;



    protected $fillable = [

         'nip', 'tahun_masuk', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by' ,'deleted_date', 'is_delete' ];


}

