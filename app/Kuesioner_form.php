<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner_form extends Model
{
    protected $table = 'm_kuesioner_form';

    protected $primaryKey = 'id_kuesioner_form';

    public $timestamps = false;

    protected $fillable = [
        'id_kuesioner_form'
    ];

    public function kuesioner_kategori()
    {
        return $this->hasMany('App\Kuesioner_kategori', 'id_kuesioner_form');
    }
}
