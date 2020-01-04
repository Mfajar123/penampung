<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner_kategori extends Model
{
    protected $table = 'm_kuesioner_kategori';

    protected $primaryKey = 'id_kuesioner_kategori';

    public $timestamps = false;

    protected $fillable = [
        'id_kuesioner_form', 'title', 'jenis_pertanyaan'
    ];

    public function kuesioner_form()
    {
        return $this->belongsTo('App\Kuesioner', 'id_kuesioner_form');
    }

    public function kuesioner_pertanyaan()
    {
        return $this->hasMany('App\Kuesioner_pertanyaan', 'id_kuesioner_kategori');
    }
}
