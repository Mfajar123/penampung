<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\Jadwal;
use App\Dosen;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $jadwal_akademik = DB::select(DB::raw("
            select ta.tahun_akademik, ta.keterangan
            from t_jadwal j
            inner join t_tahun_akademik ta on j.tahun_akademik = ta.tahun_akademik
            where j.id_dosen= '".Auth::guard('dosen')->user()->id_dosen."'
        "));

        $list_tahun_akademik = array();
        $list_jadwal = array();
        $list_hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

        foreach ($jadwal_akademik as $jadwal)
        {
            $list_tahun_akademik[$jadwal->tahun_akademik] = $jadwal->keterangan;
        }

        if ($request->tahun_akademik)
        {
            $list_jadwal = Jadwal::where([
                'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                'tahun_akademik' => $request->tahun_akademik
            ])->orderBy('jam_mulai', 'asc')->get();
        }

        return view('pages.dosen.jadwal.index', compact('list_tahun_akademik', 'list_hari', 'list_jadwal'));
    }
    
    public function print($id)
    {
        $jadwal_akademik = DB::select(DB::raw("
            select ta.tahun_akademik, ta.keterangan
            from t_jadwal j
            inner join t_tahun_akademik ta on j.tahun_akademik = ta.tahun_akademik
            where j.id_dosen= '".Auth::guard('dosen')->user()->id_dosen."'
        "));
        $dosen = Dosen::where('nip', Auth::guard('dosen')->user()->nip)->get();
        $list_tahun_akademik = array();
        $list_jadwal = array();
        $list_hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

        foreach ($jadwal_akademik as $jadwal)
        {
            $list_tahun_akademik[$jadwal->tahun_akademik] = $jadwal->keterangan;
        }

        if ($id)
        {
            $list_jadwal = Jadwal::where([
                'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                'tahun_akademik' => $id
            ])->orderBy('jam_mulai', 'asc')->get();
        }

        return view('pages.dosen.jadwal.print', compact('list_tahun_akademik', 'dosen', 'list_hari', 'list_jadwal'));
    }
}
