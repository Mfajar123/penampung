<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Jadwal;
use App\Matkul;
use App\Persentase_nilai;

class PersentaseNilaiController extends Controller
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

        foreach ($jadwal_akademik as $jadwal)
        {
            $list_tahun_akademik[$jadwal->tahun_akademik] = $jadwal->keterangan;
        }

        if ($request->tahun_akademik)
        {
            $list_jadwal = Jadwal::select([
                't_jadwal.id_matkul',
                't_jadwal.tahun_akademik',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_matkul.sks'
            ])
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', '=', 'm_matkul.id_matkul')
            ->leftJoin('t_tahun_akademik', 't_jadwal.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->where([
                't_jadwal.id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                't_jadwal.tahun_akademik' => $request->tahun_akademik
            ])
            ->groupBy('t_jadwal.id_matkul')
            ->orderBy('t_jadwal.jam_mulai', 'ASC')
            ->get();
        }

        return view('pages.dosen.persentase_nilai.index', compact('list_tahun_akademik', 'list_jadwal'));
    }

    public function atur()
    {
        $persentase_nilai = Persentase_nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen
        ])->first();

        if (empty($persentase_nilai))
        {
            return view('pages.dosen.persentase_nilai.atur', compact('matkul', 'tahun_akademik', 'persentase_nilai'));
        }
        else
        {
            return view('pages.dosen.persentase_nilai.atur', compact('matkul', 'tahun_akademik', 'persentase_nilai'));
        }
    }

    public function perbarui(Request $request)
    {
        $input = $request->all();
        $input['id_dosen'] = Auth::guard('dosen')->user()->id_dosen;

        $persentase_nilai = Persentase_nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen
        ])->first();

        if (empty($persentase_nilai))
        {
            $create = Persentase_nilai::create($input);
        }
        else
        {
            $persentase_nilai->update($input);
        }

        Session::flash('flash_message', 'Persentase Nilai berhasil disimpan.');

        return redirect()->route('dosen.nilai.persentase.atur');
    }
}
