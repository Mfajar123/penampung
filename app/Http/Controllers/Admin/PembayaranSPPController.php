<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use DataTables;

use App\TahunAkademik;
use App\Mahasiswa;
use App\Pembayaran_spp;

class PembayaranSPPController extends Controller
{
    private $list_bulan;

    public function __construct()
    {
        $this->list_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    public function datatable(Request $request)
    {
        $data = array();
        $no = 1;

        $list_mahasiswa = DB::table('m_mahasiswa')
            ->select([
                'm_mahasiswa.nim',
                DB::raw("CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) AS nim_nama")
            ]);

        if ($request->tahun_akademik)
        {
            $list_mahasiswa = $list_mahasiswa->where([
                'tahun_akademik' => $request->tahun_akademik
            ]);
        }

        $list_mahasiswa = $list_mahasiswa->get();

        $list_checked = array();

        if (is_array(Session::get('pembayaran_spp.list_mahasiswa'))) $list_checked = Session::get('pembayaran_spp.list_mahasiswa');
        
        foreach ($list_mahasiswa as $list) {
            $checked = in_array($list->nim, $list_checked) ? 'checked' : '';

            $data[] = [
                'no' => $no++,
                'nim_nama' => $list->nim_nama,
                'aksi' => '<button type="button" value="'.$list->nim.'" class="btn btn-success btn-sm btn-detail-pembayaran"><i class="fa fa-money"></i> Bayar</button>'
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        Session::forget('pembayaran_spp.list_mahasiswa');
        
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_tahun_akademik->prepend('Semua Tahun Akademik', '');

        return view('pages.admin.pembayaran_spp.index', compact('list_tahun_akademik'));
    }

    public function transaksi()
    {
        $list_mahasiswa = Mahasiswa::select('nim', DB::raw("CONCAT(nim, ' - ', nama) AS nim_nama"))->pluck('nim_nama', 'nim');
        $list_bulan = $this->list_bulan;

        return view('pages.admin.pembayaran_spp.transaksi', compact('list_mahasiswa', 'list_bulan'));
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        $input['id_admin'] = Auth::guard('admin')->user()->id_admin;
        $input['tanggal_pembayaran'] = date('Y-m-d');

        $input['created_by'] = Auth::guard('admin')->user()->nama;
        $input['created_date'] = date('Y-m-d');


        $pembayaran_spp = Pembayaran_spp::create($input);

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return response()->json(array('status' => 'success'), 200);
    }

    public function get_tahun_akademik($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $response = array();

        if (!empty($mahasiswa->tahun_akademik)) {
            $list_tahun_akademik = TahunAkademik::select('id_tahun_akademik', 'keterangan')->where('tahun_akademik', '>=', $mahasiswa->tahun_akademik)->orderBy('tahun_akademik', 'DESC')->get();
            
            $response['status'] = 'success';
            $response['tahun_akademik'] = $list_tahun_akademik;
        } else {
            $response['status'] = 'error';
            $response['tahun_akademik'] = array();
        }

        return response()->json($response, 200);
    }

    public function get_pembayaran_spp($nim, $id_tahun_akademik)
    {
        $tahun_akademik = TahunAkademik::select('semester')->where('id_tahun_akademik', $id_tahun_akademik)->first();

        if ($tahun_akademik->semester == 'Ganjil') {
            $list_bulan = array(
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
                1 => 'Januari'
            );
        } else {
            $list_bulan = array(
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
            );
        }

        $response = array();
        
        $response['status'] = 'success';
        $no = 1;

        // foreach ($list_bulan as $key => $val) {
        //     $pembayaran_spp = Pembayaran_spp::where([
        //             't_pembayaran_spp.nim' => $nim,
        //             't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
        //             't_pembayaran_spp.bulan' => $key
        //         ])
        //         ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
        //         ->first();
        //     $count_pembayaran_spp = Pembayaran_spp::where([
        //             't_pembayaran_spp.nim' => $nim,
        //             't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
        //             't_pembayaran_spp.bulan' => $key
        //         ])
        //         ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
        //         ->count();
                
        //     $status = ($count_pembayaran_spp == 0) ? "<span class='text-danger'>Belum Bayar</span>" : "<span class='text-success'>Sudah Bayar</span>";
            
        //     if (! empty($pembayaran_spp->id_dispensasi)) {
        //         $status = "<span class='text-success'>Dispensasi [".ucwords($pembayaran_spp->status)."]</span>";
        //     }
            
        //     $response['pembayaran_spp'][] = array(
        //         'no' => $no++,
        //         'id_pembayaran_spp' => @$pembayaran_spp->id_pembayaran_spp,
        //         'key_bulan' => $key,
        //         'bulan' => $val,
        //         'status' => $status,
        //         'bayar' => ! empty($pembayaran_spp->bayar) ? "Rp. ".number_format($pembayaran_spp->bayar, 0, ",", ".") : '-',
        //         'tanggal' => ! empty($pembayaran_spp->tanggal_pembayaran) ? date('d M Y', strtotime($pembayaran_spp->tanggal_pembayaran)) : '-',
        //         'keterangan' => ! empty($pembayaran_spp->keterangan) ? $pembayaran_spp->keterangan : '-'
        //     );
        // }
        foreach ($list_bulan as $key => $val) {
            $pembayaran_spp = Pembayaran_spp::select('*', 'tbl_dispensasi.tanggal_bayar AS tgl_bayar_dis')
                // ->select('tbl_dispensasi.tanggal_bayar AS tgl_bayar_dis')
                ->where([
                    't_pembayaran_spp.nim' => $nim,
                    't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
                    't_pembayaran_spp.bulan' => $key
                ])
                ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
                ->first();
            $count_pembayaran_spp = Pembayaran_spp::where([
                    't_pembayaran_spp.nim' => $nim,
                    't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
                    't_pembayaran_spp.bulan' => $key
                ])
                ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
                ->count();
                
            $status = ($count_pembayaran_spp == 0) ? "<span class='text-danger'>Belum Bayar</span>" : "<span class='text-success'>Sudah Bayar</span>";
            $tanggal_dispensasi = "-";
            $tanggal = ! empty($pembayaran_spp->tanggal_pembayaran) ? date('d M Y', strtotime($pembayaran_spp->tanggal_pembayaran)) : '-';
            
            if (! empty($pembayaran_spp->id_dispensasi)) {
                $status = "<span class='text-success'>Dispensasi [".ucwords($pembayaran_spp->status)."]</span>";
                $tanggal_dispensasi = date('d M Y', strtotime($pembayaran_spp->tanggal_pembayaran));
                if($pembayaran_spp->tgl_bayar_dis != '0000-00-00'){
                    $tanggal = date('d M Y', strtotime($pembayaran_spp->tgl_bayar_dis));
                }else{
                    $tanggal = "-";
                }
            }
                        
            $response['pembayaran_spp'][] = array(
                'no' => $no++,
                'id_pembayaran_spp' => @$pembayaran_spp->id_pembayaran_spp,
                'key_bulan' => $key,
                'bulan' => $val,
                'status' => $status,
                'bayar' => ! empty($pembayaran_spp->bayar) ? "Rp. ".number_format($pembayaran_spp->bayar, 0, ",", ".") : '-',
                'tanggal_dispensasi' => $tanggal_dispensasi,
                'tanggal' => $tanggal,
                'keterangan' => ! empty($pembayaran_spp->keterangan) ? $pembayaran_spp->keterangan : '-'
            );
        }


        return response()->json($response, 200);
    }

    public function add_list_mahasiswa(Request $request)
    {
        // Session::forget('pembayaran_spp.list_mahasiswa');

        if (is_array(Session::get('pembayaran_spp.list_mahasiswa')))
        {
            if (! in_array($request->nim, Session::get('pembayaran_spp.list_mahasiswa')))
            {
                Session::push('pembayaran_spp.list_mahasiswa', $request->nim);
            }
            else
            {
                $key = array_keys(Session::get('pembayaran_spp.list_mahasiswa'), $request->nim)[0];

                Session::pull('pembayaran_spp.list_mahasiswa.'.$key);
            }
        }
        else
        {
            Session::push('pembayaran_spp.list_mahasiswa', $request->nim);
        }

        return Session::get('pembayaran_spp.list_mahasiswa');
    }

    public function get_tahun_akademik_index_page(Request $request)
    {
        $list_tahun_akademik = TahunAkademik::select(
            'id_tahun_akademik',
            'keterangan'
        );

        if ($request->tahun_akademik) $list_tahun_akademik = $list_tahun_akademik->where('tahun_akademik', '>=', $request->tahun_akademik);
        
        $list_tahun_akademik = $list_tahun_akademik->orderBy('tahun_akademik', 'DESC')
        ->get();

        return response()->json(['tahun_akademik' => $list_tahun_akademik], 200);
    }

    public function get_pembayaran_spp_index_page(Request $request)
    {
        $id_tahun_akademik = $request->id_tahun_akademik;

        if (empty($id_tahun_akademik)) return response()->json(['status' => 'success', 'pembayaran_spp' => []]);

        $tahun_akademik = TahunAkademik::select('semester')->where('id_tahun_akademik', $id_tahun_akademik)->first();

        if ($tahun_akademik->semester == 'Ganjil') {
            $list_bulan = array(
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
                1 => 'Januari'
            );
        } else {
            $list_bulan = array(
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
            );
        }

        $response = array();
        
        $response['status'] = 'success';
        $no = 1;

        foreach ($list_bulan as $key => $val) {
            $response['pembayaran_spp'][] = array(
                'no' => $no++,
                'key_bulan' => $key,
                'bulan' => $val
            );
        }

        return response()->json($response, 200);
    }

    public function simpan_index_page(Request $request)
    {
        $pembayaran_spp = Pembayaran_spp::create([
            'id_admin' => Auth::guard('admin')->user()->id_admin,
            'nim' => $request->nim,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'bulan' => $request->bulan,
            'tanggal_pembayaran' => date('Y-m-d'),
            'bayar' => $request->bayar,
            'keterangan' => $request->keterangan,
        ]);

        Session::flash('success', 'Pembayaran berhasil disimpan.');

        return redirect()->back();
    }

    public function hapus_pembayaran_spp($id)
    {
        $pembayaran_spp = Pembayaran_spp::findOrFail($id);

        $pembayaran_spp->delete();
        
        Session::flash('success', 'Pembayaran berhasil dihapus.');

        return redirect()->back();
    }
    
     public function lpspp(request $request)
    {


            $awal = $request->awal;
            $akhir = $request->akhir;
            $no = 1;

            $laporan = DB::select(DB::raw("
                    SELECT * FROM t_pembayaran_spp 
                    LEFT JOIN t_tahun_akademik ON t_pembayaran_spp.id_tahun_akademik = t_tahun_akademik.id_tahun_akademik
                    LEFT JOIN m_mahasiswa ON t_pembayaran_spp.nim = m_mahasiswa.nim
                    LEFT JOIN tbl_prodi ON m_mahasiswa.id_prodi = tbl_prodi.id_prodi
                    LEFT JOIN tbl_semester ON m_mahasiswa.id_semester = tbl_semester.id_semester
                    WHERE date(t_pembayaran_spp.tanggal_pembayaran) BETWEEN '$awal' AND '$akhir' 
                "));



        return view('pages.admin.pembayaran_spp.lpspp', compact('laporan', 'awal', 'akhir', 'no'));
    } 
    
}
