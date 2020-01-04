<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

/*use App\Users;*/
use App\Prodi;

class ProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function tambah()
    {
        return view('pages.admin.prodi.tambah');
    }

    public function simpan(Request $request)
    {
       	$tambah = $request->all();
        $tambah['nama_fakultas'] = $request->nama_prodi;

        if (trim($request->nama_prodi == ""))
        {
            # code...
            Session::flash('fail', 'Nama Prodi Harus Diisi!');

            return redirect()->back();
        }
        else
        {
            
            if(Prodi::where('nama_prodi', 'LIKE', '%'.$request->nama_prodi.'%')->count() > 0)
            {
                Session::flash('fail', 'Nama Prodi Sudah Ada!');

                return redirect()->back()->withInput($request->all());
            }
            else
            {
                Prodi::create($tambah);

                Session::flash('success', 'Prodi Telah Ditambahkan.');
            }
        }
        return redirect()->route('admin.prodi');
    }

    public function ubah($id)
    {
        $prodi = Prodi::find($id);
        return view('pages.admin.prodi.ubah', compact('prodi', 'id'));
    }

    public function perbarui($id, Request $request)
    {
        if (trim($request->nama_prodi == "")) {
            # code...
            Session::flash('fail', 'Nama Prodi Harus Diisi!');
        }else{
            $ubah = $request->all();
            $ubah['nama_fakultas'] = $request->nama_prodi;

            Prodi::find($id)->update($ubah);

            Session::flash('success', 'Nama Prodi Telah Diubah.');
        }

        return redirect()->route('admin.prodi');
    }

    public function hapus($id)
    {
    	Prodi::find($id)->delete();

        Session::flash('fail', 'Prodi Telah Dihapus.');

        return redirect()->route('admin.prodi');
    }
}
