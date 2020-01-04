<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\TahunAkademik;
use App\KHS;
use App\KRS;
use App\KRSItem;
use App\Pembukaan_krs;
use App\Jadwal;

class RemedialController extends Controller
{
    public function pembukaan_krs()
    {
        return Pembukaan_krs::where([
                ['id_prodi', '=', Auth::guard('mahasiswa')->user()->id_prodi],
                ['tanggal_mulai', '<=', date('Y-m-d')],
                ['tanggal_selesai', '>=', date('Y-m-d')]
            ])
            ->first();
    }

    public function index()
    {
        $list_tahun_akademik = TahunAkademik::where([
                ['tahun_akademik', '>=', Auth::guard('mahasiswa')->user()->tahun_akademik]
            ])
            ->orderBy('tahun_akademik', 'DESC')
            ->pluck('keterangan', 'tahun_akademik');

        $pembukaan_krs = $this->pembukaan_krs();        

        return view('pages.mahasiswa.remedial.index', compact('list_tahun_akademik', 'pembukaan_krs'));
    }

    public function get_remedial(Request $request)
    {        
        $list_remedial = KHS::select([
            'm_matkul.id_matkul',
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            't_khs.total',
            'm_grade_nilai.huruf'
        ])
        ->leftjoin('m_matkul', 't_khs.kode_matkul', '=', 'm_matkul.kode_matkul')
        ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
        ->where([
            't_khs.tahun_akademik' => $request->tahun_akademik,
            't_khs.nim' => Auth::guard('mahasiswa')->user()->nim
        ])
        ->whereIn('m_grade_nilai.huruf', ['C', 'D', 'E'])
        ->get();

        return response()->json(['status' => 'success', 'data' => $list_remedial]);
    }

    function get_jadwal(Request $request)
    {
        $id_matkul = $request->id_matkul;
        
        $krs = KRS::where([
            't_krs.nim' => Auth::guard('mahasiswa')->user()->nim
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->first();

        $list_jadwal = Jadwal::select([
            't_jadwal.hari',
            't_jadwal.jam_mulai',
            't_jadwal.jam_selesai',
            't_jadwal.id_kelas'
        ])
        ->leftJoin('m_hari', 't_jadwal.hari', '=', 'm_hari.nama_hari')
        ->where([
            't_jadwal.id_matkul' => $id_matkul,
            't_jadwal.tahun_akademik' => @$krs->tahun_akademik,
            't_jadwal.id_waktu_kuliah' => @$krs->id_waktu_kuliah
        ])
        ->orderBy('m_hari.id_hari', 'ASC')
        ->orderBy('t_jadwal.jam_mulai')
        ->get();

        return response()->json(['status' => 'success', 'krs' => $krs, 'list_jadwal' => $list_jadwal]);
    }

    public function ulang_matkul(Request $request)
    {
        $id_matkul = $request->id_matkul;
        $id_kelas = $request->id_kelas;

        $krs = KRS::where([
            't_krs.nim' => Auth::guard('mahasiswa')->user()->nim
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->first();

        $krs_item = KRSItem::insert([
            'id_krs' => $krs->id_krs,
            'id_matkul' => $id_matkul,
            'id_kelas' => $id_kelas,
            'is_repeat' => 1
        ]);

        return response()->json(['status' => 'success']);
    }
}
