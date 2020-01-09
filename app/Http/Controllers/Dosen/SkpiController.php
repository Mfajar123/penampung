<?php

namespace App\Http\Controllers\Dosen;
use Auth;
use DB;
use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkpiController extends Controller
{
    public function index(Request $request){
        $data_skpi=skpi::all();
        return view ('pages.dosen.skpi.index',['data_skpi'=>$data_skpi]);

        return view('pages.dosen.skpi.index');
    }

    public function cari(Request $request){
        
        $cari = $request->cari;
 
        $cari_skpi = skpi::
        where('nim','like',"%".$cari."%")
        ->where('nama','like',"%".$cari."%")->get();

 
		return view('dosen.skpi.index', compact('cari_skpi'));
    }
}
?>