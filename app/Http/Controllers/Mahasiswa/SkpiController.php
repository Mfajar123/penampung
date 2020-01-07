<?php

namespace App\Http\Controllers\Mahasiswa;

use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkpiController extends Controller
{
    public function index(){
    return view ('pages/mahasiswa/skpi/index');
    
    $data_skpi= \App\skpi::all();
    return view ('pages/mahasiswa/skpi/index',['data_skpi'=>$data_skpi]);
    }

    public function save(Request $request){
        skpi::create($request->all());
        dd(skpi::all());
    }
}
?>