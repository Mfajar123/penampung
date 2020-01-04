<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Absensi;
use App\Jadwal;
use App\KRS;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $krs = array();
        $absensi = array();

        // Mengambil tahun akademik dari siswa tersebut
        $list_tahun_akademik = DB::table('t_krs AS krs')
            ->select([
                'krs.tahun_akademik',
                'ta.keterangan'
            ])
            ->join('t_tahun_akademik AS ta', 'krs.tahun_akademik', '=', 'ta.tahun_akademik')
            ->where([
                'krs.nim' => Auth::guard('mahasiswa')->user()->nim
            ])
            ->groupBy('krs.tahun_akademik')
            ->pluck('ta.keterangan', 'krs.tahun_akademik');

        if ($request->tahun_akademik) {
            if (Auth::guard('mahasiswa')->check()) {
                $krs = KRS::where(['tahun_akademik' => $request->tahun_akademik, 'nim' => Auth::guard('mahasiswa')->user()->nim])->first();
            } elseif (Auth::guard('wali')->check()) {
                $krs = KRS::where(['tahun_akademik' =>$request->tahun_akademikt, 'nim' => Auth::guard('wali')->user()->nim])->first();            
            }

            $jadwal = Jadwal::where(['tahun_akademik' => $request->tahun_akademik, 'id_semester' => ! empty($krs->id_semester) ? $krs->id_semester : '-'])->get();
        }

        return view('pages.mahasiswa.absensi.index', compact('list_tahun_akademik', 'krs', 'jadwal'));
    }
}
