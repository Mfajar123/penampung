<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\TahunAkademik;
use App\Semester;
use App\Kuesioner;
use App\Kuesioner_kategori;

class RekapAngketDosenController extends Controller
{
    public function index(Request $request)
    {
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');

        $count_pedagogik = Kuesioner_kategori::where('title', 'KOMPETENSI PEDAGOGIK')->first()->kuesioner_pertanyaan()->count();
        $count_profesional = Kuesioner_kategori::where('title', 'KOMPETENSI PROFESIONAL')->first()->kuesioner_pertanyaan()->count();
        $count_kepribadian = Kuesioner_kategori::where('title', 'KOMPETENSI KEPRIBADIAN')->first()->kuesioner_pertanyaan()->count();
        $count_sosial = Kuesioner_kategori::where('title', 'KOMPETENSI SOSIAL')->first()->kuesioner_pertanyaan()->count();
        
        $list_rekapitulasi = Kuesioner::select([
                'm_dosen.nip',
                'm_dosen.nama',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                DB::raw("SUM(
                    CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PEDAGOGIK' THEN
                        t_kuesioner_detail.jawaban
                    ELSE
                        0
                    END
                ) AS sumPedagogik"),
                DB::raw("SUM(
                    CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PROFESIONAL' THEN
                        t_kuesioner_detail.jawaban
                    ELSE
                        0
                    END
                ) AS sumProfesional"),
                DB::raw("SUM(
                    CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI KEPRIBADIAN' THEN
                        t_kuesioner_detail.jawaban
                    ELSE
                        0
                    END
                ) AS sumKepribadian"),
                DB::raw("SUM(
                    CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI SOSIAL' THEN
                        t_kuesioner_detail.jawaban
                    ELSE
                        0
                    END
                ) AS sumSosial"),
                DB::raw("SUM(t_kuesioner_detail.jawaban) AS sumTotal"),
                DB::raw("(
                    SELECT
                        COUNT(k.nim)
                    FROM t_kuesioner k
                    WHERE
                        k.id_dosen = t_kuesioner.id_dosen AND
                        k.id_matkul = t_kuesioner.id_matkul AND
                        k.id_kelas = t_kuesioner.id_kelas AND
                        k.tahun_akademik = t_kuesioner.tahun_akademik
                ) AS countPenilai")
            ])
            ->leftJoin('m_dosen', 't_kuesioner.id_dosen', 'm_dosen.id_dosen')
            ->leftJoin('m_matkul', 't_kuesioner.id_matkul', 'm_matkul.id_matkul')
            ->rightJoin('t_kuesioner_detail', 't_kuesioner.id_kuesioner', 't_kuesioner_detail.id_kuesioner')
            ->leftJoin('m_kuesioner_pertanyaan', 't_kuesioner_detail.id_kuesioner_pertanyaan', 'm_kuesioner_pertanyaan.id_kuesioner_pertanyaan')
            ->leftJoin('m_kuesioner_kategori', 'm_kuesioner_pertanyaan.id_kuesioner_kategori', 'm_kuesioner_kategori.id_kuesioner_kategori')
            ->groupBy('t_kuesioner_detail.id_kuesioner');

        if (! empty($request->tahun_akademik)) $list_rekapitulasi->where('t_kuesioner.tahun_akademik', $request->tahun_akademik);
        if (! empty($request->id_semester)) $list_rekapitulasi->where('t_kuesioner.id_semester', $request->id_semester);
        
        $list_rekapitulasi = $list_rekapitulasi->orderBy('nip', 'ASC')->get();

        return view('pages.admin.rekap_angket_dosen.index', compact('list_tahun_akademik', 'list_semester', 'list_rekapitulasi', 'count_pedagogik', 'count_profesional', 'count_kepribadian', 'count_sosial'));
    }
}
