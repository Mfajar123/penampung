<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Kuesioner_pertanyaan;
use App\TahunAkademik;
use App\Semester;

class SaranKritikController extends Controller
{
    protected function data($pertanyaan)
    {
        $data = Kuesioner_pertanyaan::select([
                'm_dosen.nip',
                'm_dosen.nama',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_kelas.kode_kelas',
                'm_kelas.nama_kelas',
                'm_mahasiswa.nim',
                'm_mahasiswa.nama AS nama_mahasiswa',
                't_kuesioner_detail.jawaban'
            ])
            ->rightJoin('t_kuesioner_detail', 'm_kuesioner_pertanyaan.id_kuesioner_pertanyaan', 't_kuesioner_detail.id_kuesioner_pertanyaan')
            ->leftJoin('t_kuesioner', 't_kuesioner_detail.id_kuesioner', 't_kuesioner.id_kuesioner')
            ->leftJoin('m_dosen', 't_kuesioner.id_dosen', 'm_dosen.id_dosen')
            ->leftJoin('m_matkul', 't_kuesioner.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_mahasiswa', 't_kuesioner.nim', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 't_kuesioner.id_kelas', 'm_kelas.id_kelas')
            ->where('m_kuesioner_pertanyaan.pertanyaan', $pertanyaan)
            ->whereNotNull('t_kuesioner_detail.jawaban')
            ->groupBy('t_kuesioner.id_dosen')
            ->groupBy('t_kuesioner.id_matkul')
            ->groupBy('t_kuesioner.id_kelas')
            ->groupBy('t_kuesioner.nim');
        
        return $data;
    }

    protected function sarana_prasarana(Request $request)
    {
        $title = 'Sarana Prasarana';
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $data = $this->data('Sarana – prasarana');

        if (! empty($request->tahun_akademik)) $data->where('t_kuesioner.tahun_akademik', $request->tahun_akademik);
        if (! empty($request->id_semester)) $data->where('t_kuesioner.id_semester', $request->id_semester);

        $data = $data->get();

        if (! empty($request->export_to_excel)) return view('pages.admin.saran_kritik.export', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));

        return view('pages.admin.saran_kritik.index', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));
    }

    protected function materi_proses_pembelajaran(Request $request)
    {
        $title = 'Materi dan Proses Pembelajaran';
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $data = $this->data('Materi dan proses pembelajaran');

        if ($request->tahun_akademik && $request->id_semester) {
            $data->where([
                    't_kuesioner.tahun_akademik' => $request->tahun_akademik,
                    't_kuesioner.id_semester' => $request->id_semester
                ]);
        }

        $data = $data->get();

        if (! empty($request->export_to_excel)) return view('pages.admin.saran_kritik.export', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));

        return view('pages.admin.saran_kritik.index', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));
    }

    protected function metode_evaluasi_sistem_penilaian(Request $request)
    {
        $title = 'Metode Evaluasi dan Sistem Penilaian';
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $data = $this->data('Metode evaluasi dan sistem penilaian/ Uji Kompetensi Dasar');

        if ($request->tahun_akademik && $request->id_semester) {
            $data->where([
                    't_kuesioner.tahun_akademik' => $request->tahun_akademik,
                    't_kuesioner.id_semester' => $request->id_semester
                ]);
        }

        $data = $data->get();

        if (! empty($request->export_to_excel)) return view('pages.admin.saran_kritik.export', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));

        return view('pages.admin.saran_kritik.index', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));
    }

    protected function pengembangan_soft_skill_mahasiswa(Request $request)
    {
        $title = 'Pengembangan Soft Skill Mahasiswa';
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $data = $this->data('Pengembangan soft skill mahasiswa');

        if ($request->tahun_akademik && $request->id_semester) {
            $data->where([
                    't_kuesioner.tahun_akademik' => $request->tahun_akademik,
                    't_kuesioner.id_semester' => $request->id_semester
                ]);
        }

        $data = $data->get();

        if (! empty($request->export_to_excel)) return view('pages.admin.saran_kritik.export', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));

        return view('pages.admin.saran_kritik.index', compact('title', 'list_tahun_akademik', 'list_semester', 'data'));
    }
}
