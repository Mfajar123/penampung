<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;



use File;

use Auth;

use Session;

use DB;

use DataTables;



use App\Mahasiswa;
use App\KRS;
use App\MahasiswaSekolah;
use App\MahasiswaPekerjaan;
use App\MahasiswaOrtu;
use App\MahasiswaStatus;
use App\Prodi;
use App\Jenjang;
use App\TahunAkademik;
use App\Provinsi;
use App\WaktuKuliah;




class MahasiswaAdminController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth:admin');

    }

	public function get_now_tahun_akademik()
    {
        // $bulan = date('m');

        // if ($bulan >= 02 and $bulan <= 04) {
        //     $tahun_lalu = date("Y") - 1;
        //     $belakang = "20";
        //     $tahun = $tahun_lalu.$belakang;
        // }else{
        //     $tahun_sekarang = date("Y");
        //     $belakang = "10";
        //     $tahun = $tahun_sekarang.$belakang;
        // }
        
        // return $tahun;
        
        return KRS::orderBy('tahun_akademik', 'DESC')->first()->tahun_akademik;
    }


    public function datatable(Request $request)
    {
        $data = array();
        $no = 1;

    //    $list_mahasiswa = Mahasiswa::select([
    //         'm_mahasiswa.nim as nimm',
    //         'm_mahasiswa.nama',
    //         'm_mahasiswa.id_mahasiswa',
    //         'm_mahasiswa.tmp_lahir',
    //         'm_mahasiswa.tgl_lahir',
    //         'm_mahasiswa.jenkel',
    //         'm_mahasiswa.id_status',
    //         'm_mahasiswa.id_prodi',
    //         'm_mahasiswa.id_waktu_kuliah',
    //         'm_mahasiswa.is_disable_spp',
    //         'tbl_mahasiswa_status.*',
    //         'tbl_detail_penasihat_akademik.*',
    //         'm_dosen.nama as nama_dosen',
    //         'tbl_waktu_kuliah.*',
    //         'm_kelas_detail.*',
    //         'm_kelas.*',
    //         'm_mahasiswa.is_delete',
            
    //     ])
    //     ->leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
    //     ->leftJoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', '=', 'm_mahasiswa.id_waktu_kuliah')
    //     ->leftJoin('tbl_detail_penasihat_akademik', 'm_mahasiswa.nim', '=', 'tbl_detail_penasihat_akademik.nim')
    //     ->leftjoin('m_dosen', 'm_dosen.nip', 'tbl_detail_penasihat_akademik.nip')
    //     ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
    //     ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas');

        $list_mahasiswa = Mahasiswa::select([
            'm_mahasiswa.id_mahasiswa',
            'm_mahasiswa.nim as nimm',
            'm_mahasiswa.nama',
            'm_mahasiswa.tmp_lahir',
            'm_mahasiswa.tgl_lahir',
            'm_dosen.nama as nama_dosen',
            DB::raw("(
                SELECT
                    m_kelas.nama_kelas
                FROM
                    m_kelas_detail
                LEFT JOIN
                    m_kelas ON m_kelas_detail.id_kelas = m_kelas.id_kelas
                WHERE
                    m_kelas_detail.nim = m_mahasiswa.nim
                ORDER BY
                    m_kelas_detail.id_kelas DESC
                LIMIT 1
            ) AS nama_kelas"),
            DB::raw("(
                SELECT
                    t_krs.tahun_akademik
                FROM
                    t_krs
                WHERE
                    t_krs.nim = m_mahasiswa.nim
                ORDER BY
                    t_krs.tahun_akademik DESC
                LIMIT 1
            ) AS tahun_akademik"),
            DB::raw("(
                SELECT
                    t_pembayaran_spp.bulan
                FROM
                    t_pembayaran_spp
                WHERE
                    t_pembayaran_spp.nim = m_mahasiswa.nim
                ORDER BY
                    t_pembayaran_spp.id_pembayaran_spp DESC
                LIMIT 1
            ) AS bulan")
        ])
        ->leftJoin('tbl_detail_penasihat_akademik', 'm_mahasiswa.nim', 'tbl_detail_penasihat_akademik.nim')
        ->leftJoin('m_dosen', 'm_dosen.nip', 'tbl_detail_penasihat_akademik.nip');

        switch ($request->type) {
            case "aktif":
                $list_mahasiswa = $list_mahasiswa->having('tahun_akademik', $this->get_now_tahun_akademik());
                break;
            case "non-aktif":
                $list_mahasiswa = $list_mahasiswa->having('tahun_akademik', '<', $this->get_now_tahun_akademik());
                break;
            case "lulus": break;
            case "keluar": break;
            case "cuti":
                $list_mahasiswa = $list_mahasiswa->having('tahun_akademik', '<', $this->get_now_tahun_akademik())
                    ->havingRaw('(bulan = ? OR bulan = ?)', [2, 8]);
                break;
        }

        if (! empty($request->tahun_akademik)) $list_mahasiswa = $list_mahasiswa->where('m_mahasiswa.tahun_akademik', $request->tahun_akademik);

        if (! empty($request->id_status))  $list_mahasiswa = $list_mahasiswa->where('m_mahasiswa.id_status', $request->id_status);
        
        if (! empty($request->id_prodi)) $list_mahasiswa = $list_mahasiswa->where('m_mahasiswa.id_prodi', $request->id_prodi);
        
        if (! empty($request->id_waktu_kuliah)) $list_mahasiswa = $list_mahasiswa->where('m_mahasiswa.id_waktu_kuliah', $request->id_waktu_kuliah);
        
        $list_mahasiswa = $list_mahasiswa->where('m_mahasiswa.is_delete', 'N')
            ->groupBy('nimm')
            ->orderBy('nimm')
            ->get();

        foreach ($list_mahasiswa as $list) {
            if ($list->is_disable_spp == 1) {
                $btn_spp = '<a href="'.route('admin.mahasiswa.disable_spp', $list->id_mahasiswa).'" class="btn btn-success btn-sm">Enable Pembayaran SPP</a>';
            } else {
                $btn_spp = '<a href="'.route('admin.mahasiswa.disable_spp', $list->id_mahasiswa).'" class="btn btn-danger btn-sm">Disable Pembayaran SPP</a>';
            }

            $data[] = array(
                'no' => $no++,
                'nim' => ! empty($list->nimm) ? $list->nimm  : '-',
                'nama' => ! empty($list->nama) ? $list->nama : '-',
                'nama_kelas' => ! empty($list->nama_kelas) ? $list->nama_kelas : '-',
                'ttl' => (! empty($list->tmp_lahir) ? $list->tmp_lahir : '-').', '.(! empty($list->tgl_lahir) ? date('d M Y', strtotime($list->tgl_lahir)) : '-'),
                'jenkel' => ! empty($list->jenkel) ? $list->jenkel : '-',
                'dosen_pa' => ! empty($list->nama_dosen) ? $list->nama_dosen : '-',
                'aksi' => '
                    <a href="'.route('admin.mahasiswa.detail', $list->id_mahasiswa).'" class="btn btn-info btn-sm" title="detail"><i class="fa fa-search"></i></a>
                    '.$btn_spp.'
                '
            );
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    function index($type = null)
    {
        $list_status = MahasiswaStatus::pluck('nama_status', 'id_status');
        $list_prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        $list_wakul = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');
        $list_tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        $list_tahun_akademik->prepend('- Semua -', '');
        $list_status->prepend('- Semua -', '');
        $list_prodi->prepend('- Semua -', '');
        $list_wakul->prepend('- Semua -', '');

        return view('pages.admin.mahasiswa.index', compact('list_status', 'list_tahun_akademik', 'list_prodi', 'list_wakul', 'type'));
    }

    public function disable_spp($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'is_disable_spp' => $mahasiswa->is_disable_spp == 0 ? 1 : 0
        ]);

        Session::flash('success', 'Status Pembayaran SPP untuk mahasiswa '.$mahasiswa->nama.' berhasil dirubah menjadi '.($mahasiswa->is_disable_spp == 0 ? 'Enable' : 'Disable'));

        return redirect()->back();
    }



    public function detail($id)

    {

        $mahasiswa = Mahasiswa::find($id);

        $sekolah = MahasiswaSekolah::where('nim', $mahasiswa->nim)->first();

        $pekerjaan = MahasiswaPekerjaan::where('nim', $mahasiswa->nim)->first();

        $ortu = MahasiswaOrtu::where('nim', $mahasiswa->nim)->first();

        $system = new SystemController();

	    $kelas = DB::table('m_kelas')
            ->select([
                'm_kelas.id_prodi',
                'm_kelas.kode_kelas',
                'tbl_waktu_kuliah.nama_waktu_kuliah',
                'tbl_semester.semester_ke',
                't_tahun_akademik.keterangan',
                DB::raw("(t_tahun_akademik.tahun_akademik = ".$this->get_now_tahun_akademik().") AS actived")
            ])
            ->leftJoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->leftJoin('tbl_semester', 'm_kelas.id_semester', 'tbl_semester.id_semester')
            ->rightJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftJoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', '=', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->where([
                'm_kelas_detail.nim' => $mahasiswa->nim
            ])
            ->get();
            
        
        $jumlah_sks = KRS::leftjoin('t_krs_item', 't_krs_item.id_krs', 't_krs.id_krs')
                            ->leftjoin('m_matkul', 't_krs_item.id_matkul', 'm_matkul.id_matkul')
                            ->where('t_krs.nim', $mahasiswa->nim)
                            ->sum('sks');

        $status_mahasiswa = DB::table('m_mahasiswa')
            ->leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
            ->where('m_mahasiswa.nim', $mahasiswa->nim)
            ->first();



        return view('pages.admin.mahasiswa.detail', compact('mahasiswa', 'system', 'sekolah', 'pekerjaan', 'ortu', 'jumlah_sks', 'kelas', 'status_mahasiswa'));

    }

}

