<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use File;
use Auth;
use Session;
use DB;
use DataTables;

use App\Dosen;
use App\Mahasiswa;
use App\TahunAkademik;
use App\Prodi;
use App\PenasihatAkademik;
use App\DetailPenasihatAkademik;

class DosenPAController extends Controller
{

       public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $req)
    {
        $data = array();
        $no = 1;

       $dosen_pa = PenasihatAkademik::select([
            'tbl_penasihat_akademik.*',
            'm_dosen.nama',
            'tbl_prodi.*',
            DB::raw("(SELECT COUNT(*) FROM tbl_detail_penasihat_akademik AS mc WHERE mc.nip = tbl_penasihat_akademik.nip and mc.is_delete = 'N') AS jumlah")
        ])
        ->leftjoin('m_dosen', 'm_dosen.nip', '=', 'tbl_penasihat_akademik.nip')
        ->leftJoin('m_mahasiswa', 'm_mahasiswa.nip', '=', 'm_dosen.nip')
        ->leftJoin('tbl_prodi', 'm_dosen.id_prodi', 'tbl_prodi.id_prodi')
        ->where('status_dosen', '1')
        ->where('tbl_penasihat_akademik.is_delete', 'N')
        ->groupBy('nama');

        if (! empty($req->id_prodi))
        {
            $dosen_pa = $dosen_pa->where('m_dosen.id_prodi', $req->id_prodi);
        }

         $dosen_pa = $dosen_pa->get();

        foreach ($dosen_pa as $list)
        {
            $word = "'Anda Yakin Akan Mengembalikan Data Penasihat Akademik ".$list->nama."'";
            $data[] = array(
                'no' => $no++,
                'nip' => ! empty($list->nip) ? $list->nip  : '-',
                'nama' => ! empty($list->nama) ? $list->nama : '-',
                'prodi' => ! empty($list->nama_prodi) ? $list->nama_prodi : '-',
                'jumlah' => ! empty($list->jumlah) ? $list->jumlah : '-',
                'aksi' => '<a href="'.route('admin.dosen.pa.detail', $list->nip).'" class="btn btn-info btn-sm" title="detail"><i class="fa fa-search"></i></a>
                <a href="'.route('admin.dosen.pa.hapus', $list->nip).'" onclick="return confirm('.$word.')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>'
            );
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

     function index()
    {
        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');

        $prodi->prepend('- Semua -', '');


        return view('pages.admin.dosen_pa.index', compact('prodi'));
    }

    public function tambah()
    {
        $list_prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        $list_dosen = Dosen::select('nip', 'nama')->where('status_dosen', '1')->orderBy('nama', 'ASC')->pluck('nama', 'nip');
        $list_tahun_masuk = DB::table('m_mahasiswa AS m')->select('m.tahun_masuk')->orderBy('m.tahun_masuk', 'DESC')->groupBy('m.tahun_masuk')->pluck('m.tahun_masuk', 'm.tahun_masuk');

        return view('pages.admin.dosen_pa.tambah', compact('list_dosen', 'list_tahun_masuk', 'list_prodi'));
    }

    public function simpan(Request $request)
    {
        if (count($request->nim) > 0) {
            $update = Mahasiswa::whereIn('nim', $request->nim)->update(['nip' => $request->nip]);
        }

        $inputdosen = PenasihatAkademik::create(['nip' => $request->nip, 'tahun_masuk' => $request->tahun_masuk, 'created_by' => Auth::guard('admin')->user()->nama, 'created_date' => date('Y-m-d') ]);

            $banyak = count($request->nim);
            for ($i =0; $i < $banyak; $i++) {
            DetailPenasihatAkademik::create(['nip' => $request->nip, 'nim' => $request->nim[$i],  'created_by' => Auth::guard('admin')->user()->nama, 'created_date' => date('Y-m-d') ]);
            }
        return redirect()->route('admin.dosen.pa.index');
    }

    public function detail($nip)
    {
        $tahun_masuk = @$_POST['tahun_masuk'];

        $tm = Mahasiswa::pluck('tahun_masuk', 'tahun_masuk');

        $list_mahasiswa = DB::table('m_mahasiswa AS m')
            ->select('m.nim', 'm.nama', 'm.tmp_lahir', 'm.tahun_masuk', 'm.tgl_lahir', 'm.jenkel', 'tbl_detail_penasihat_akademik.id_detail_penasihat_akademik')
            ->leftjoin('tbl_detail_penasihat_akademik', 'm.nim', '=', 'tbl_detail_penasihat_akademik.nim')
            ->where('tbl_detail_penasihat_akademik.nip', $nip)
            ->where('tbl_detail_penasihat_akademik.is_delete', 'N')
            ->orderBy('m.nim', 'ASC')
            ->groupBy('m.nim');
            
        if (isset($tahun_masuk))
        {
            $list_mahasiswa = $list_mahasiswa->where('tahun_masuk', $tahun_masuk);
        }
        
        $list_mahasiswa = $list_mahasiswa->get();

        return view('pages.admin.dosen_pa.detail', compact('list_mahasiswa', 'tm', 'nip'));
    }

     public function hapus_dosen($id)
    {
        PenasihatAkademik::where('nip', $id)->update(['deleted_by' => Auth::guard('admin')->user()->nama, 'deleted_date' => date('Y-m-d'),'is_delete' => 'Y']);
        DetailPenasihatAkademik::where('nip', $id)->update(['deleted_by' => Auth::guard('admin')->user()->nama, 'deleted_date' => date('Y-m-d'),'is_delete' => 'Y']);

        Mahasiswa::where('nip', $id)->update([ 'nip' => '' ]);
  
        Session::flash('fail', 'Data Penasihat Berhasil Dihapus.');
  
        return redirect()->route('admin.dosen.pa.index');
    }

    public function hapus_siswa($id, $nip)
    {
        DetailPenasihatAkademik::find($id)->update(['deleted_by' => Auth::guard('admin')->user()->nama, 'deleted_date' => date('Y-m-d'),'is_delete' => 'Y']);
        
        $pa =  DetailPenasihatAkademik::find($id);

        $ms = Mahasiswa::where('nim', $pa->nim)->update([ 'nip' => '']);


        Session::flash('fail', 'Data Penasihat Berhasil Dihapus.');
  
        return redirect()->route('admin.dosen.pa.detail', $nip);
    }


   
    public function get_mahasiswa($tahun_masuk, $prodi)
    {
            $list_mahasiswa = DB::table('m_mahasiswa AS m')
                ->select(['m.nim', 'm.nama', 'm.tmp_lahir', 'm.id_prodi', 'm.nip', 'tbl_prodi.*', 'm.tgl_lahir', 'm.jenkel', 'm_dosen.nama as dosen'])
                ->leftjoin('tbl_prodi', 'm.id_prodi', 'tbl_prodi.id_prodi')
                ->leftjoin('m_dosen', 'm.nip', 'm_dosen.nip')  
                ->where('m.tahun_masuk', $tahun_masuk)
                ->where('m.id_prodi', $prodi)
                ->orderBy('m.nim', 'ASC')
                ->get();
        
        return $list_mahasiswa;
    }


   
}
