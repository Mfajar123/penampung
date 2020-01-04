<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner_pertanyaan extends Model
{
    protected $table = 'm_kuesioner_pertanyaan';

    protected $primaryKey = 'id_kuesioner_pertanyaan';

    public $timestamps = false;

    protected $fillable = [
        'id_kuesioner_kategori', 'pertanyaan'
    ];

    public function kuesioner_kategori()
    {
        return $this->belongsTo('App\Kuesioner_kategori', 'id_kuesioner_kategori');
    }
}
