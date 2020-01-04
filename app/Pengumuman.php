<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Pengumuman extends model

{

    protected $table = 'm_pengumuman';

    protected $primaryKey = 'id_pengumuman';

    public $timestamps = false;



    protected $fillable = [

        'id_pengumuman', 'judul_pengumuman', 'ringkasan_pengumuman', 'waktu_pengumuman', 'isi_pengumuman', 'foto_pengumuman', 'sumber_pengumuman',  'umumkan_ke','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date', 'is_delete' ];





}

