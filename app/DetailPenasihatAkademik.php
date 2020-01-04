<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class DetailPenasihatAkademik extends model

{



    protected $table = 'tbl_detail_penasihat_akademik';

    protected $primaryKey = 'id_detail_penasihat_akademik';

    public $timestamps = false;



    protected $fillable = [

         'nip', 'nim', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by' ,'deleted_date', 'is_delete' ];
}

