<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Pembukaan_krs;
use App\Prodi;

class PembukaanKrsController extends Controller
{
    public function index()
    {
        $list_pembukaan = DB::table('m_pembukaan_krs AS pk')
            ->select([
                'pk.id_pembukaan_krs',
                'p.nama_prodi',
                'pk.tanggal_mulai',
                'pk.tanggal_selesai'
            ])
            ->leftJoin('tbl_prodi AS p', 'pk.id_prodi', '=', 'p.id_prodi')
            ->get();

        return view('pages.admin.pembukaan_krs.index', compact('list_pembukaan'));
    }

    public function tambah()
    {
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        return view('pages.admin.pembukaan_krs.create', compact('list_prodi'));
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        
        $input['tanggal_mulai'] = date('Y-m-d', strtotime( $request->tanggal_mulai ));

        $input['tanggal_selesai'] = date('Y-m-d', strtotime( $request->tanggal_selesai ));

        $pembukaan_krs = Pembukaan_krs::create($input);

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return redirect()->route('admin.setting.pembukaan_krs.index');
    }

    public function edit($id)
    {
        $pembukaan_krs = Pembukaan_krs::findOrFail($id);
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        
       $tanggal_mulai =  date('d-M-Y', strtotime($pembukaan_krs->tanggal_mulai));
        $tanggal_selesai =  date('d-M-Y', strtotime($pembukaan_krs->tanggal_selesai));
        return view('pages.admin.pembukaan_krs.edit', compact('pembukaan_krs', 'list_prodi', 'tanggal_selesai', 'tanggal_mulai'));
    }

    public function perbarui($id, Request $request)
    {
        $pembukaan_krs = Pembukaan_krs::findOrFail($id);

        $input = $request->all();
        
        $input['tanggal_mulai'] = date('Y-m-d', strtotime( $request->tanggal_mulai ));

        $input['tanggal_selesai'] = date('Y-m-d', strtotime( $request->tanggal_selesai ));

        $pembukaan_krs->update($input);
        
        

        Session::flash('flash_message', 'Data berhasil diperbarui.');

        return redirect()->route('admin.setting.pembukaan_krs.index');
    }

    public function hapus($id)
    {
        $pembukaan_krs = Pembukaan_krs::findOrFail($id);

        $pembukaan_krs->delete();

        Session::flash('flash_message', 'Data berhasil dihapus.');

        return redirect()->route('admin.setting.pembukaan_krs.index');
    }
}
