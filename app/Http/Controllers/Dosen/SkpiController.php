<?php

namespace App\Http\Controllers\Dosen;
use Auth;
use DB;
use App\PenasihatAkademik;
use File;
use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class SkpiController extends Controller
{
    public function index()
	{
		$dosen = Auth::guard('dosen')->user()->nip;


		$data_skpi = DB::table('skpi')->select('skpi.*','tbl_detail_penasihat_akademik.*')
		->leftjoin('tbl_detail_penasihat_akademik','tbl_detail_penasihat_akademik.nim', '=', 'skpi.nim')
		->where('tbl_detail_penasihat_akademik.nip','=', $dosen)
		->paginate(5);
  
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

		return redirect()->back()->with('approved','Data Berhasil disetujui!!!');
	}

	public function hapus($id){
		$gambar = skpi::where('id',$id)->first();
		file::delete('images/skpi/'.$gambar->sertifikat_ospek);

		skpi::where('id',$id)->delete();

		return redirect()->back()->with('hapus','Data Berhasil Dihapus!!!');
	}
}
?>