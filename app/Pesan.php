<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
     protected $table = 'm_pesan';

    protected $primaryKey = 'id_pesan';

    public $timestamps = false;



    protected $fillable = [

        'id_pesan', 'nama', 'email', 'tanggal_pesan', 'no_telp', 'subjek', 'pesan', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date', 'is_delete' ];

}
