<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;
use DataTables;

use App\KRS;
use App\KRSItem;
use App\TahunAkademik;
use App\Mahasiswa;
use App\Jadwal;
use App\WaktuKuliah;

class KRSInputController extends Controller
{
    public function datatable(Request $request)
    {        
        $krs = KRS::select([
                't_krs.id_krs',
                DB::raw("CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) as nim_nama"),
                DB::raw("CONCAT(m_dosen.nip, ' - ', m_dosen.nama) as nip_nama"),
                't_tahun_akademik.keterangan'
            ])
            ->leftJoin('m_mahasiswa', 't_krs.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_dosen', 'm_mahasiswa.nip', '=', 'm_dosen.nip')
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', '=', 't_tahun_akademik.tahun_akademik');

        if (! empty($request->tahun_akademik)) $krs->where('t_krs.tahun_akademik', $request->tahun_akademik);

        $krs = $krs->orderBy('t_krs.id_krs', 'ASC')
            ->groupBy('t_krs.nim')
            ->groupBy('t_krs.tahun_akademik')
            ->groupBy('t_krs.status')
            ->get();
        
        $data = array();
        $no = 1;

        foreach ($krs as $list)
        {
            $data[] = [
                'no' => $no++,
                'id_krs' => $list->id_krs,
                'nim_nama' => $list->nim_nama,
                'nip_nama' => ! empty($list->nip_nama) ? $list->nip_nama : '<span class="text-danger">Belum ada Dosen PA</span>',
                'tahun_akademik' => $list->keterangan,
                'aksi' => "<a href='".route('admin.krs.input.print', $list->id_krs)."' class='btn btn-default btn-sm' target='_blank'><i class='fa fa-print'></i> Print</a>"
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        return view('pages.admin.krs.input.index', compact('list_tahun_akademik'));
    }

    public function tambah()
    {
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_mahasiswa = Mahasiswa::select([
                'm_mahasiswa.nim',
                DB::raw("CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) AS nim_nama")
            ])
            ->pluck('nim_nama', 'm_mahasiswa.nim');
        $list_waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        return view('pages.admin.krs.input.tambah', compact('list_tahun_akademik', 'list_mahasiswa', 'list_waktu_kuliah'));
    }

    public function simpan(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        // $krs = KRS::create([
        //     'nim' => $request->nim,
        //     'tahun_akademik' => $request->tahun_akademik,
        //     'id_semester' => $mahasiswa->id_semester,
        //     'is_delete' => 'N'
        // ]);

        // $data_krs_item = array();

        // foreach ($request->id_matkul as $matkul)
        // {
        //     $data_krs_item[] = [
        //         'id_krs' => $krs->id_krs,
        //         'id_matkul' => $matkul
        //     ];
        // }

        // $krs_item = KRSItem::insert($data_krs_item);

        // Session::flash('flash_message', 'Data berhasil disimpan.');
        
        $semester_ke = $mahasiswa->id_semester;

        if (empty($semester_ke))
        {
            $semester_ke = 1;
        }
        else
        {
            $semester_ke += 1;
        }

        $krs = KRS::create([
            'nim' => $mahasiswa->nim,
            'tahun_akademik' => $request->tahun_akademik,
            'id_semester' => $semester_ke,
            'id_waktu_kuliah' => $request->id_waktu_kuliah,
            'total_sks' => $request->total_sks,
            'is_delete' => 'N'
        ]);

        $data_krs_item = array();

        foreach ($request->id_matkul as $matkul)
        {
            $data_krs_item[] = [
                'id_krs' => $krs->id_krs,
                'id_matkul' => $matkul
            ];
        }

        $krs_item = KRSItem::insert($data_krs_item);

        Session::flash('flash_message', 'KRS berhasil disimpan.');

        return redirect()->route('admin.krs.input.index');
    }
    
    
   public function print($id_krs)
   {   
        $krs = KRS::findOrFail($id_krs);
        
        $siswa = Mahasiswa::select([
                // 'm_mahasiswa.*',
                // 'm_mahasiswa.nama as nama_siswa',                
                // 'm_dosen.nip',
                // 'm_dosen.nama as nama_dosen',
                // 'tbl_waktu_kuliah.*',
                // 'm_kelas.*',
                // 'm_kelas_detail.*',
                // 't_tahun_akademik.*'
                'm_mahasiswa.nim',
                'm_mahasiswa.nama',
                'tbl_waktu_kuliah.nama_waktu_kuliah',
                't_tahun_akademik.keterangan',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_dosen.nama AS nama_dosen',
                'tbl_prodi.nama_prodi',
                'm_kelas.nama_kelas',
            ])
            ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftjoin('m_dosen', 'm_mahasiswa.nip', 'm_dosen.nip')
            ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->leftJoin('tbl_prodi', 'm_mahasiswa.id_prodi', '=', 'tbl_prodi.id_prodi')
            ->where([
                'm_mahasiswa.nim' => $krs->nim,
                'm_kelas.tahun_akademik' => $krs->tahun_akademik
            ])
            ->first();

        $tahun_akademik = TahunAkademik::where('tahun_akademik', $krs->tahun_akademik)->first();
        
        $krs_item = $krs->krs_item()->groupBy('id_matkul')->get();
        $total_sks = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->sum('sks');


        return view('pages.admin.krs.input.print', compact('siswa', 'krs', 'krs_item', 'total_sks', 'tahun_akademik'));
    }
    

    public function get_matkul(Request $request)
    {
	$tahun_akademik = $request->tahun_akademik;
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        $semester_ke = $mahasiswa->id_semester;

            if (empty($semester_ke))
            {
                $semester_ke = 1;
            }
            else
            {
                $semester_ke += 1;
            }

            $jadwal = Jadwal::select([
                't_jadwal.id_jadwal',
                'm_matkul.id_matkul',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_matkul.sks'
            ])
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', '=', 'm_matkul.id_matkul')
            ->where([
                't_jadwal.tahun_akademik' => $tahun_akademik,
                't_jadwal.id_prodi' => $mahasiswa->id_prodi,
                't_jadwal.id_waktu_kuliah' => $mahasiswa->id_waktu_kuliah,
                't_jadwal.id_semester' => $semester_ke,
                't_jadwal.is_delete' => 'N'
            ])
            ->groupBy('m_matkul.id_matkul')
            ->get();
        
        return response()->json($jadwal, 200);
    }
}
