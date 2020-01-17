<?php

namespace App\Http\Controllers\Dosen;
use Auth;
use DB;
use File;
use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkpiController extends Controller
{
    public function index()
	{
		$data_skpi = DB::table('skpi')->paginate(5);
 
		return view ('pages.dosen.skpi.index',['data_skpi'=>$data_skpi]);
 
	}
 
	public function cari(Request $request)
	{
		$cari = $request->cari;
 
    	$data_skpi = DB::table('skpi')
        ->where('nama','like',"%".$cari."%")
		->paginate(5);
 
    	return view ('pages.dosen.skpi.index',['data_skpi'=>$data_skpi]);
	}

	public function confirm($id)
	{
		skpi::find($id)->update(['status'=>'approved']);

		return redirect()->back();
	}
}
?>