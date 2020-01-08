<?php

namespace App\Http\Controllers\Mahasiswa;
use Auth;
use App\skpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkpiController extends Controller
{
    public function index(){

    $data_skpi=skpi::all();

    return view ('pages/mahasiswa/skpi/index',['data_skpi'=>$data_skpi]);
    }

    public function save(Request $request){
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $this->validate($request, [
			'sertifikat_ospek' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
            'sertifikat_seminar' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
            'sertifikat_bnsp' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
            ]);
 
		// menyimpan data file yang diupload ke variabel $file
        $file1 = $request->file('sertifikat_ospek');
        $file2 = $request->file('sertifikat_seminar');
        $file3 = $request->file('sertifikat_bnsp');

        $nama_ospek = $mahasiswa->nim."_ospek";
        $nama_seminar = $mahasiswa->nim."_seminar";
        $nama_bnsp = $mahasiswa->nim."_bnsp";
 
      	// isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'images/skpi';
        $file1->move($tujuan_upload,$nama_ospek);
        $file2->move($tujuan_upload,$nama_seminar);
        $file3->move($tujuan_upload,$nama_bnsp);
        
        skpi::create([
            'nim'=>$mahasiswa->nim,
            'sertifikat_ospek'=> $nama_ospek,
            'sertifikat_seminar'=> $nama_seminar,
            'sertifikat_bnsp' => $nama_bnsp,
        ]);

	    return redirect()->back()->with(['success' => 'Data Berhasil Disimpan']);;
    }
}
?>