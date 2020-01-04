<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner_detail extends Model
{
    protected $table = 't_kuesioner_detail';

    protected $primaryKey = 'id_kuesioner_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_kuesioner', 'id_kuesioner_pertanyaan', 'jawaban'
    ];

    public function kuesioner()
    {
        return $this->belongsTo('App\Kuesioner', 'id_kuesioner');
    }

    public function kuesioner_pertanyaan()
    {
        return $this->belongsTo('App\Kuesioner_pertanyaan', 'id_kuesioner_pertanyaan');
    }
}
