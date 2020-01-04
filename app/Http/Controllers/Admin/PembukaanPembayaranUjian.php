<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

use App\Pembukaan_pembayaran_ujian;

class PembukaanPembayaranUjian extends Controller
{
    public function index()
    {
        $list_pembukaan_pembayaran_ujian = Pembukaan_pembayaran_ujian::get();
        $jenis_ujian = array('uts' => 'UTS', 'uas' => 'UAS', 'remedial' => 'Remedial');

        return view('pages.admin.pembukaan_pembayaran_ujian.index', compact('list_pembukaan_pembayaran_ujian', 'jenis_ujian'));
    }

    public function tambah()
    {
        return view('pages.admin.pembukaan_pembayaran_ujian.create');
    }

    public function simpan(Request $request)
    {
        $simpan = Pembukaan_pembayaran_ujian::create($request->all());

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return redirect()->route('admin.setting.pembukaan_pembayaran_ujian.index');
    }

    public function edit($id)
    {
        $pembukaan_pembayaran_ujian = Pembukaan_pembayaran_ujian::findOrFail($id);

        return view('pages.admin.pembukaan_pembayaran_ujian.edit', compact('pembukaan_pembayaran_ujian'));
    }

    public function perbarui($id, Request $request)
    {
        $pembukaan_pembayaran_ujian = Pembukaan_pembayaran_ujian::findOrFail($id);
        
        $pembukaan_pembayaran_ujian->update($request->all());

        Session::flash('flash_message', 'Data berhasil diperbarui.');

        return redirect()->route('admin.setting.pembukaan_pembayaran_ujian.index');
    }

    public function hapus($id)
    {
        $pembukaan_pembayaran_ujian = Pembukaan_pembayaran_ujian::findOrFail($id);
        
        $pembukaan_pembayaran_ujian->delete();

        Session::flash('flash_message', 'Data berhasil dihapus.');

        return redirect()->route('admin.setting.pembukaan_pembayaran_ujian.index');
    }
}
