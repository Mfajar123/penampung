<?php

namespace App\Http\Controllers\Mahasiswa;
use DB;
use PDF;
use Auth;
use Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;
use App\Mahasiswa as AppMahasiswa;

class DospemController extends Controller
{
    public function index(){
        $dosen = DB::table('m_dosen')->select('gelar_depan','nama','gelar_belakang')->pluck('gelar_depan','nama','gelar_belakang');

        return view('pages.mahasiswa.pengajuan_dospem.index', compact('dosen'));
    }

    public function save(){
        
    }

    public function edit(){
    }

    public function update(){
    
    }
}
?>