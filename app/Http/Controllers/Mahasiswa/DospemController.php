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

        skripsi::select('nim')->where('nim',$nim)->update([
            'dospem1'=>$request->dospem1,
            'dospem2'=>$request->dospem2,
        ]);

        return redirect()->back();
    }
    
    public function edit(){
    }

    public function update(){
    
    }
}
?>