<?php

namespace App\Http\Controllers\Mahasiswa;
use DB;
use App\skripsi;
use PDF;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;

class JudulController extends Controller
{
    public function index(){
        $nim= Auth::guard('mahasiswa')->user()->nim;
        $data = skripsi::all()->where('nim',$nim); 
        return view('pages.mahasiswa.formulir_judul.index',['data'=>$data]);
    }

    public function save(Request $request){
        $nim= Auth::guard('mahasiswa')->user()->nim;
        $nama= Auth::guard('mahasiswa')->user()->nama;
        $prodi= Auth::guard('mahasiswa')->user()->id_prodi;

        if( skripsi::where('nim', $nim)->first() != null ) { 
            return redirect()->back()->with('gagal', 'Anda Sudah Pernah Menginput Data!!!'); 
        }

        else{
        DB::table('skripsi')->insert([
            'nim' =>$nim,
            'nama' =>$nama,
            'prodi' =>$prodi,
            'judul1' => $request->judul1,
            'judul2' => $request->judul2,
            'judul3' => $request->judul3,
        ]);}

       return redirect()->back();
    }

    public function cetak(Request $request){

        $nim= Auth::guard('mahasiswa')->user()->nim;
        $data =skripsi::all()->where('nim',$nim);

        $pdf = PDF::loadview('pages.mahasiswa.formulir_judul.cetak_judul',['data'=>$data]);
        return $pdf->stream();
    }

    public function edit($id)
	{
        $edit = skripsi::find($id);
        return view('pages.mahasiswa.formulir_judul.edit',compact('edit'));
    }

    public function update(Request $request,$id)
    {
        $edit = skripsi::find($id);
        $edit->update($request->all());

        return redirect()->route('mahasiswa.judul')->with('update','Judul Berhasil Diubah');
    }
}
?>