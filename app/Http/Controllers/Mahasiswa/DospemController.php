<?php

namespace App\Http\Controllers\Mahasiswa;
use DB;
use PDF;
use Auth;
use App\skripsi;
use App\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;
use App\Mahasiswa as AppMahasiswa;

class DospemController extends Controller
{
    public function index(){
        $nim= Auth::guard('mahasiswa')->user()->nim;

        $data = Dosen::select('nama','gelar_belakang')->get();
        return view('pages.mahasiswa.pengajuan_dospem.index', compact('data'));
    }

    public function save(Request $request){
        $nim= Auth::guard('mahasiswa')->user()->nim;

        $this->validate($request,[
			'scan_formulir' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            ]);
 
		// menyimpan data file yang diupload ke variabel $file
        $file1 = $request->file('scan_formulir');

        $formulir = time()."_".$file1->getClientOriginalName();
 
      	// isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'images/scan_formulir';
        $file1->move($tujuan_upload,$formulir);

        skripsi::select('nim')->where('nim',$nim)->update([
            'judul_disetujui'=>$request->judul_disetujui,
            'dospem1'=>$request->dospem1,
            'dospem2'=>$request->dospem2,
            'scan_formulir'=>$formulir,
        ]);

        return redirect()->back()->with('sukses','Data Berhasil Disimpan!!!');
    }
    
    public function edit(){
    }

    public function update(){
    
    }
}
?>