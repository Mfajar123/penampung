<?php

namespace App\Http\Controllers\Mahasiswa;
use App\config;
use DB;
use App\formulir_judul;
use PDF;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;
use App\Mahasiswa as AppMahasiswa;

class JudulController extends Controller
{
    public function index(){

    return view ('pages/mahasiswa/formulir_judul/index');
    }

    public function save(Request $request){
        $nim= Auth::guard('mahasiswa')->user()->nim;
        $nama= Auth::guard('mahasiswa')->user()->nama;
        $prodi= Auth::guard('mahasiswa')->user()->id_prodi;

        DB::table('judul_skripsi')->insert([
            'nim' =>$nim,
            'nama' =>$nama,
            'prodi' =>$prodi,
            'judul1' => $request->judul1,
            'judul2' => $request->judul2,
            'judul3' => $request->judul3,
        ]);

       return redirect()->back();
    }

    public function cetak(Request $request){
        // $data = DB::table('judul_skripsi');
 
        $data = formulir_judul::all();
        $pdf = PDF::loadview('pages.mahasiswa.formulir_judul.cetak_judul',['data'=>$data]);
        return $pdf->stream();

    }

}
?>