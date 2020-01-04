<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Session;

use Auth;

use DB;

use App\Dosen;

use App\Mahasiswa;

use App\KRS;

use App\Kelas;

use App\KRSItem;

use App\TahunAkademik;

use App\Pengumuman;

use App\KelasDetailRemedial;


class DosenController extends Controller

{

    function __construct(Request $req)

    {

        $this->middleware('auth:dosen');

    }



    function index()

    {

        $pengumuman = Pengumuman::where('is_delete', 'N')->where('umumkan_ke', '!=', 'Mahasiswa')->orderBy('waktu_pengumuman', 'DESC')->take(5)->skip(0)->get();
        
        
        return view('pages.home', compact('pengumuman'));


    }

    

    function password(Request $req)

    {

        $system = New SystemController();

        $route = 'dosen.password.ubah';



        $id = Auth::guard('dosen')->user()->id_dosen;

        $profil = Dosen::find($id);



        $password = $system->decrypt($profil->password, $profil->nip, $profil->nip);



        return view('pages.profil.password', compact('system', 'route', 'id', 'profil', 'password'));

    }

    function krs()

    {

        $t = @$_GET['tahun_akademik'];

        $tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->get();

        $nip = Auth::guard('dosen')->user()->nip;

        $no = 1;

        $mahasiswa = Mahasiswa::join('t_krs', 't_krs.nim', '=', 'm_mahasiswa.nim')->where('t_krs.tahun_akademik', $t)->where('nip', $nip)->get();

        return view('pages/dosen/krs/index', compact('mahasiswa', 'no', 'tahun_akademik'));

    }

    function krs_setuju($id)

    {

        $krs = KRS::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $krs->nim)->first();
        
        $list_kelas_remedial = array();

        $kelas = Kelas::select([
            'm_kelas.id_kelas',
            DB::raw("(COUNT(DISTINCT m_kelas_detail.nim) >= m_kelas.kapasitas) AS isFull")
        ])
        ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
        ->leftJoin('m_kelas_detail_remedial', 'm_kelas.id_kelas', '=', 'm_kelas_detail_remedial.id_kelas')
        ->where([
            'm_kelas.id_semester' => $krs->id_semester,
            'm_kelas.tahun_akademik' => $krs->tahun_akademik,
            'm_kelas.id_prodi' => $mahasiswa->id_prodi,
            'm_kelas.id_waktu_kuliah' => $krs->id_waktu_kuliah,
        ])
        ->having('isFull', '=', 0)
        ->groupBy('m_kelas.id_kelas')
        ->orderBy('m_kelas.kode_kelas', 'ASC')
        ->first();

        if (empty($kelas))
        {
            Session::flash('flash_message', 'Semua kelas sudah full.');
        }
        else
        {
            // $list_jadwal = DB::table('t_jadwal AS j')
            //     ->select([
            //         'h.nama_hari',
            //         'j.jam_mulai',
            //         'j.jam_selesai',
            //     ])
            //     ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
            //     ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
            //     ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
            //     ->where([
            //         'j.tahun_akademik' => $krs->tahun_akademik,
            //         'j.id_kelas' => $kelas->id_kelas
            //     ])
            //     ->whereIn('m.id_matkul', @$krs->krs_item()->pluck('id_matkul'))
            //     ->orderBy('h.id_hari', 'ASC')
            //     ->orderBy('j.jam_mulai', 'ASC')
            //     ->get();
                    
            // foreach ($krs->krs_item()->where('is_repeat', 1)->get() as $item)
            // {
            //     $kelas_remedial = array();
                
            //     foreach ($list_jadwal as $list)
            //     {
            //         $kelas_remedial = Kelas::select([
            //                 't_jadwal.hari',
            //                 'm_kelas.id_kelas',
            //                 't_jadwal.jam_mulai',
            //                 't_jadwal.jam_selesai',
            //                 DB::raw("(COUNT(m_kelas_detail.nim) >= m_kelas.kapasitas) AS isFull")
            //             ])
            //             ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            //             ->leftJoin('m_kelas_detail_remedial', 'm_kelas.id_kelas', '=', 'm_kelas_detail_remedial.id_kelas')
            //             ->rightJoin('t_jadwal', 'm_kelas.id_kelas', '=', 't_jadwal.id_kelas')
            //             ->where([
            //                 'm_kelas.id_prodi' => $mahasiswa->id_prodi,
            //                 'm_kelas.id_waktu_kuliah' => $krs->id_waktu_kuliah,
            //                 't_jadwal.id_matkul' => $item->id_matkul,
            //                 't_jadwal.hari' => $list->nama_hari,
            //                 // ['t_jadwal.jam_mulai', '<', $list->jam_mulai],
            //                 // ['t_jadwal.jam_selesai', '>', $list->jam_selesai]
            //             ])
            //             ->whereNotBetween('t_jadwal.jam_mulai', [$list->jam_mulai, $list->jam_selesai])
            //             ->having('isFull', '=', 0)
            //             ->groupBy('m_kelas.id_kelas')
            //             ->orderBy('m_kelas.id_kelas', 'ASC')
            //             ->first();
                        
            //         if (!empty($kelas_remedial)) break;
            //     }

            //     if (empty($kelas_remedial))
            //     {
            //         Session::flash('flash_message', 'Kelas untuk mata kuliah ' . @$item->matkul->nama_matkul . ' sudah full/bentrok dengan jadwal mahasiswa.');

            //         return redirect()->back();
            //     }
            //     else
            //     {
            //         $list_kelas_remedial[] = array(
            //             'id_kelas' => $kelas_remedial->id_kelas,
            //             'id_matkul' => $item->id_matkul,
            //             'nim' => $mahasiswa->nim
            //         );
            //     }
            // }

            if (empty($krs->id_waktu_kuliah)) $krs->update(['id_waktu_kuliah' => $mahasiswa->id_waktu_kuliah]);

            $krs->update([
                'status' => 'Y'
            ]);
            
            $kelas->kelas_detail()->create([
                'nim' => $mahasiswa->nim
            ]);

            // KelasDetailRemedial::insert($list_kelas_remedial);

            $mahasiswa->update([
                'id_semester' => $mahasiswa->id_semester + 1,
		        'is_updated_information' => 'F'
            ]);
    
            Session::flash('flash_message', 'KRS berhasil di disetujui.');
        }

        return redirect()->back();
    }

    function krs_tolak($id)

    {

        $krs = KRS::find($id);

        $krs->update(['status' => 'N']);

        Session::flash('success', 'KRS Ditolak');

        return redirect()->route('dosen.krs');

    }

    function krs_detail()

    {

        $t = $_GET['tahun_akademik'];

        $nim = $_GET['nim'];

        $id = $_GET['id'];

        $krs = KRSItem::join('t_krs', 't_krs.id_krs', '=', 't_krs_item.id_krs')->where('tahun_akademik', $t)->where('t_krs.id_krs', $id)->where('nim', $nim)->groupBy('t_krs_item.id_matkul')->get();

        $mahasiswa = Mahasiswa::where('nim', $nim)->get();

        foreach($mahasiswa as $m);

            $nama = $m->nama;

        return view('pages/dosen/krs/detail', compact('krs', 'nama', 'id'));

    }

    public function print($id_krs)
    {
        $krs = KRS::findOrFail($id_krs);
        $krs_item = $krs->krs_item()->get();
        $total_sks = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->sum('sks');
        $mahasiswa_temp = Mahasiswa::where('nim', $krs->nim)->first();

        if( $mahasiswa_temp->id_status == '6' )    
        {  
            $mahasiswa = Mahasiswa::leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                ->where('m_mahasiswa.nim', $krs->nim)->first();
        }
        else
        {
            $mahasiswa = Mahasiswa::leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
                ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
                ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
                ->where([
                    'm_mahasiswa.nim' => $krs->nim,
                    'm_kelas.tahun_akademik' => $krs->tahun_akademik,
                ])
                ->first();
        }

        return view('pages.dosen.krs.print', compact('mahasiswa', 'krs', 'krs_item', 'total_sks'));
    }

}

