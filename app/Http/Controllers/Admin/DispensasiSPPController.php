<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;

use DB;
use Auth;
use Session;
use DataTables;

use App\Dispensasi;
use App\Mahasiswa;
use App\TahunAkademik;
use App\Pembayaran_spp;

class DispensasiSPPController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = new OptionsController();
    }

    public function datatable()
    {
        $data = array();
        $no = 1;

        $dispensasi = Dispensasi::select([
            'tbl_dispensasi.*',
            'm_mahasiswa.nama',
            't_tahun_akademik.keterangan'
        ])
        ->where([
            'tbl_dispensasi.jenis_pembayaran' => 'Pembayaran SPP',
            'tbl_dispensasi.is_delete' => 'N'
        ])
        ->leftJoin('m_mahasiswa', 'tbl_dispensasi.nim', 'm_mahasiswa.nim')
        ->leftJoin('t_tahun_akademik', 'tbl_dispensasi.id_tahun_akademik', 't_tahun_akademik.id_tahun_akademik')
        ->get();

        foreach ($dispensasi as $list)
        {
            $bayar = '';

            if (strtolower($list->status) == 'belum bayar') {
                $bayar = '<a href="'.route('admin.dispensasi_spp.sudah_dibayar', $list->id_dispensasi).'" class="btn btn-success btn-sm" title="Sudah Bayar" onClick="return konfirmasi_sudah_bayar()"><i class="fa fa-check"></i> Sudah Bayar</a>';
            }

            $list['no'] = $no++;
            $list['nama_bulan'] = $this->options->list_bulan()[$list->bulan];
            $list['tanggal_akan_bayar'] = date('j M Y', strtotime($list->tanggal_akan_bayar));
            $list['nominal_akan_bayar'] = number_format($list->nominal_akan_bayar, 0, ',', '.');
            $list['status'] = (strtolower($list->status) == 'belum bayar' ? '<span class="text-danger">'.$list->status.'</span>' : '<span class="text-success">'.$list->status.'</span>');
            $list['aksi'] = '
                '.$bayar.'
                <a href="'.route('admin.dispensasi_spp.detail', $list->id_dispensasi).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>
                <a href="'.route('admin.dispensasi_spp.edit', $list->id_dispensasi).'" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.dispensasi_spp.hapus', $list->id_dispensasi).'" class="btn btn-danger btn-sm" title="Hapus" onClick="return konfirmasi_hapus()"><i class="fa fa-remove"></i></a>
            ';

            $data[] = $list;
        }
        
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.admin.dispensasi_spp.index');
    }

    public function tambah()
    {
        $list_mahasiswa = Mahasiswa::select([
            'nim',
            DB::raw("CONCAT(nim, ' - ', nama) AS nim_nama")
        ])
        ->pluck('nim_nama', 'nim');

        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'id_tahun_akademik');

        $list_bulan = $this->options->list_bulan();

        return view('pages.admin.dispensasi_spp.tambah', compact('list_mahasiswa', 'list_tahun_akademik', 'list_bulan'));
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        $input['jenis_pembayaran'] = 'Pembayaran SPP';
        $input['status'] = 'Belum Bayar';
        $input['created_by'] = Auth::guard('admin')->user()->id_admin;
        $input['created_date'] = Date('Y-m-d H:i:s');

        $dispensasi = Dispensasi::create($input);

        $pembayaran_spp = Pembayaran_spp::create([
            'id_admin' => Auth::guard('admin')->user()->id_admin,
            'nim' => $request->nim,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'bulan' => $request->bulan,
            'tanggal_pembayaran' => $request->tanggal_akan_bayar,
            'bayar' => $request->nominal_akan_bayar,
            'id_dispensasi' => $dispensasi->id_dispensasi
        ]);

        Session::flash('success', 'Dispensasi berhasil disimpan.');

        return redirect()->route('admin.dispensasi_spp.index');
    }

    public function edit($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);

        $list_mahasiswa = Mahasiswa::select([
            'nim',
            DB::raw("CONCAT(nim, ' - ', nama) AS nim_nama")
        ])
        ->pluck('nim_nama', 'nim');

        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'id_tahun_akademik');

        $list_bulan = $this->options->list_bulan();

        return view('pages.admin.dispensasi_spp.edit', compact('dispensasi', 'list_mahasiswa', 'list_tahun_akademik', 'list_bulan'));
    }

    public function perbarui($id, Request $request)
    {
        $dispensasi = Dispensasi::findOrFail($id);
        $pembayaran_spp = Pembayaran_spp::where('id_dispensasi', $id)->first();

        $input = $request->all();
        $input['updated_by'] = Auth::guard('admin')->user()->id_admin;
        $input['updated_date'] = Date('Y-m-d H:i:s');

        $dispensasi->update($input);

        $pembayaran_spp->update([
            'id_admin' => Auth::guard('admin')->user()->id_admin,
            'nim' => $request->nim,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'bulan' => $request->bulan,
            'tanggal_pembayaran' => $request->tanggal_akan_bayar,
            'bayar' => $request->nominal_akan_bayar
        ]);

        Session::flash('success', 'Dispensasi berhasil diperbarui.');

        return redirect()->route('admin.dispensasi_spp.index');
    }

    public function hapus($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);
        $pembayaran_spp = Pembayaran_spp::where('id_dispensasi', $id)->first();

        $pembayaran_spp->delete();

        $dispensasi->update([
            'deleted_by' => Auth::guard('admin')->user()->id_admin,
            'deleted_date' => date('Y-m-d H:i:s'),
            'is_delete' => 'Y'
        ]);

        Session::flash('success', 'Dispensasi berhasil dihapus.');

        return redirect()->route('admin.dispensasi_spp.index');
    }

    public function sudah_dibayar($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);

        $dispensasi->update([
            'status' => 'Sudah Bayar',
            'updated_by' => Auth::guard('admin')->user()->id_admin,
            'updated_date' => date('Y-m-d H:i:s'),
            'tanggal_bayar' => date('Y-m-d')
        ]);

        Session::flash('success', 'Dispensasi berhasil dibayar.');

        return redirect()->route('admin.dispensasi_spp.index');
    }

    public function detail($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $dispensasi->nim)->first();

        return view('pages.admin.dispensasi_spp.detail', compact('dispensasi', 'mahasiswa'));
    }

    public function print()
    {

    }
}
