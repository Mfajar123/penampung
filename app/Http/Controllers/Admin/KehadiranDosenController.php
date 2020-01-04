<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;

use App\TahunAkademik;
use App\Absensi;
use App\Jadwal;

class KehadiranDosenController extends Controller
{
    protected function index(Request $request)
    {
        $list_kehadiran = [];

        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        if ($request->tahun_akademik) {
            $list_kehadiran = Absensi::select([
                'm_dosen.nip',
                'm_dosen.nama',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_kelas.id_prodi',
                'm_kelas.kode_kelas',
                DB::raw("COUNT(DISTINCT t_absensi.tanggal) AS kehadiran")
            ])
            ->leftJoin('t_jadwal', 't_absensi.id_jadwal', 't_jadwal.id_jadwal')
            ->leftJoin('m_matkul', 't_absensi.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_kelas', 't_absensi.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('m_dosen', 't_absensi.id_dosen', 'm_dosen.id_dosen')
            ->where([
                't_jadwal.tahun_akademik' => $request->tahun_akademik
            ])
            ->groupBy('t_absensi.id_jadwal')
            ->groupBy('t_absensi.id_dosen')
            ->groupBy('t_absensi.id_kelas')
            ->groupBy('t_absensi.id_matkul')
            ->orderBy('m_dosen.nama', 'ASC')
            ->get();
        }

        return view('pages.admin.kehadiran_dosen.index', compact('list_kehadiran', 'list_tahun_akademik'));
    }
}
