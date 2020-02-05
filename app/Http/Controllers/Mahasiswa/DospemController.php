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

        $data = DB::select("SELECT d.id_dosen, 
                                   d.nama, 
                                   d.gelar_belakang 
                              FROM m_dosen d
                         LEFT JOIN skripsi s 
                                ON d.id_dosen = s.dospem1 
                          group by d.id_dosen, d.nama, d.gelar_belakang 
                            having count(1) <=10");

        return view('pages.mahasiswa.pengajuan_dospem.index', compact('data'));
    }

    public function save(Request $request){
        $nim= Auth::guard('mahasiswa')->user()->nim;

        skripsi::select('nim')->where('nim',$nim)->update([
            'dospem1'=>$request->dospem1,
        ]);

        return redirect()->back();
    }
    
    public function edit(){
    }

    public function update(){
    
    }
}
?>