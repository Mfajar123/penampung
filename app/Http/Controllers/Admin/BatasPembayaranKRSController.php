<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\OptionsController;

use Auth;
use Session;

use App\Batas_pembayaran;

class BatasPembayaranKRSController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = new OptionsController();
    }

    public function index()
    {
        $list_batas_pembayaran = Batas_pembayaran::where([
            'jenis_pembayaran' => 'KRS'
        ])
        ->get();
        
        $list_bulan = $this->options->list_bulan();

        return view('pages.admin.batas_pembayaran.krs.index', compact('list_batas_pembayaran', 'list_bulan'));
    }

    public function tambah()
    {
        $list_bulan = $this->options->list_bulan();
        $list_semester = $this->options->list_semester();

        return view('pages.admin.batas_pembayaran.krs.tambah', compact('list_bulan', 'list_semester'));
    }

    public function simpan(Request $request)
    {
        Batas_pembayaran::create([
            'jenis_pembayaran' => 'KRS',
            'semester' => $request->semester,
            'bulan' => $request->bulan,
            'created_by' => Auth::guard('admin')->user()->id_admin,
            'created_date' => date('Y-m-d H:i:s')
        ]);

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return redirect()->route('admin.batas_pembayaran.krs');
    }

    public function edit($id)
    {
        $batas_pembayaran = Batas_pembayaran::findOrFail($id);

        $list_bulan = $this->options->list_bulan();
        $list_semester = $this->options->list_semester();

        return view('pages.admin.batas_pembayaran.krs.edit', compact('batas_pembayaran', 'list_bulan', 'list_semester'));
    }

    public function perbarui($id, Request $request)
    {
        $batas_pembayaran = Batas_pembayaran::findOrFail($id);
        
        $batas_pembayaran->update([
            'semester' => $request->semester,
            'bulan' => $request->bulan,
            'created_by' => Auth::guard('admin')->user()->id_admin,
            'created_date' => date('Y-m-d H:i:s')
        ]);

        Session::flash('flash_message', 'Data berhasil diperbarui.');

        return redirect()->route('admin.batas_pembayaran.krs');
    }

    public function hapus($id)
    {
        $batas_pembayaran = Batas_pembayaran::findOrFail($id);

        $batas_pembayaran->delete();

        Session::flash('flash_message', 'Data berhasil dihapus.');

        return redirect()->route('admin.batas_pembayaran.krs');
    }
}
