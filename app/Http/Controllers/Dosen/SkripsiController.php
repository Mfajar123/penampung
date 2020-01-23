<?php

namespace App\Http\Controllers\Dosen;
use Auth;
use DB;
use File;
use App\skripsi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkripsiController extends Controller
{

    public function index(){
        $data = skripsi::all();

        return view('pages.dosen.skpi.acc_judul',['data'=>$data]);
    }

    public function cari(Request $request)
	{
		$cari = $request->cari;
 
    	$data = DB::table('skripsi')
        ->where('nama','like',"%".$cari."%")
		->paginate(10);
 
    	return view('pages.dosen.skpi.acc_judul',['data'=>$data]);
    }
    
    public function edit($id)
	{
        $edit = skripsi::find($id);
        return view('pages.dosen.skpi.update_judul',compact('edit'));
    }

    public function update(Request $request,$id)
    {
        $nim= Auth::guard('mahasiswa')->user()->nim;

        skripsi::find($id)->update([
            'judul_disetujui'=>$request->judul,
            'tgl_mulai_bimbingan'=>$request->mulai_bimbingan,
            'tgl_selesai_bimbingan'=>$request->selesai_bimbingan,
        ]);

        return redirect()->back();
    }

}
?>