<?php

namespace App\Http\Controllers\Mahasiswa;
use DB;
use Auth;
use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;
use App\Mahasiswa as AppMahasiswa;

class SkpiController extends Controller
{
    public function index(){

    $data_skpi=skpi::all();

    return view ('pages/mahasiswa/skpi/index',['data_skpi'=>$data_skpi]);
    }

    public function save(Request $request){
        $nim= Auth::guard('mahasiswa')->user()->nim;
        $nama= Auth::guard('mahasiswa')->user()->nama;
    
        $this->validate($request, [
			'sertifikat_ospek' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'sertifikat_seminar' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'sertifikat_bnsp' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            ]);
 
		// menyimpan data file yang diupload ke variabel $file
        $file1 = $request->file('sertifikat_ospek');
        $file2 = $request->file('sertifikat_seminar');
        $file3 = $request->file('sertifikat_bnsp');

        $nama_ospek = time()."_".$file1->getClientOriginalName();
        $nama_seminar = time()."_".$file2->getClientOriginalName();
        $nama_bnsp = time()."_".$file3->getClientOriginalName();
 
      	// isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'images/skpi';
        $file1->move($tujuan_upload,$nama_ospek);
        $file2->move($tujuan_upload,$nama_seminar);
        $file3->move($tujuan_upload,$nama_bnsp);
        
        skpi::create([
            'nim'=> $nim,
            'nama'=> $nama,
            'sertifikat_ospek'=> $nama_ospek,
            'sertifikat_seminar'=> $nama_seminar,
            'sertifikat_bnsp' => $nama_bnsp,
            'status'=>'N'
        ]);

        return redirect()->back();
        
    }
}
?>