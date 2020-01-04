<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

use App\PembukaanInputNilai;

class PembukaanInputNilaiController extends Controller
{
    public function index()
    {
        $pembukaan_input_nilai = PembukaanInputNilai::findOrFail(1);

        return view('pages.admin.pembukaan_input_nilai.index', compact('pembukaan_input_nilai'));
    }

    public function store(Request $request)
    {
        $pembukaan_input_nilai = PembukaanInputNilai::findOrFail(1);
        
        $pembukaan_input_nilai->update($request->all());

        Session::flash('flash_message', 'Pembukaan KRS berhasil diupdate.');

        return redirect()->back();
    }
}
