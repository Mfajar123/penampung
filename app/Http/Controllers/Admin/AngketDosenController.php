<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Kuesioner;
use App\Kuesioner_kategori;
use App\Dosen;
use App\Matkul;
use App\TahunAkademik;
use App\Semester;

class AngketDosenController extends Controller
{
    protected function index(Request $request)
    {
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');

        $data = Kuesioner::select([
                't_kuesioner.id_dosen',
                't_kuesioner.id_matkul',
                't_kuesioner.tahun_akademik',
                't_kuesioner.id_semester',
                'm_dosen.nip',
                'm_dosen.nama',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_matkul.kode_matkul',
                'm_kelas.nama_kelas',
                'm_matkul.nama_matkul'
            ])
            ->leftJoin('m_dosen', 't_kuesioner.id_dosen', 'm_dosen.id_dosen')
            ->leftJoin('m_matkul', 't_kuesioner.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_kelas', 't_kuesioner.id_kelas', 'm_kelas.id_kelas')
            ->rightJoin('t_kuesioner_detail', 't_kuesioner.id_kuesioner', 't_kuesioner_detail.id_kuesioner')
            ->leftJoin('m_kuesioner_pertanyaan', 't_kuesioner_detail.id_kuesioner_pertanyaan', 'm_kuesioner_pertanyaan.id_kuesioner_pertanyaan')
            ->leftJoin('m_kuesioner_kategori', 'm_kuesioner_pertanyaan.id_kuesioner_kategori', 'm_kuesioner_kategori.id_kuesioner_kategori')
            ->groupBy('t_kuesioner_detail.id_kuesioner');

        if (! empty($request->tahun_akademik)) $data->where('t_kuesioner.tahun_akademik', $request->tahun_akademik);
        if (! empty($request->id_semester)) $data->where('t_kuesioner.id_semester', $request->id_semester);
        
        $data = $data->orderBy('nip', 'ASC')->get();

        return view('pages.admin.angket_dosen.index', compact('list_tahun_akademik', 'list_semester', 'data'));
    }

    protected function detail($id_dosen, $id_matkul, $tahun_akademik, $id_semester)
    {
        $no = 1;
        $data = [];

        $count_pedagogik = Kuesioner_kategori::where('title', 'KOMPETENSI PEDAGOGIK')->first()->kuesioner_pertanyaan()->count();
        $count_profesional = Kuesioner_kategori::where('title', 'KOMPETENSI PROFESIONAL')->first()->kuesioner_pertanyaan()->count();
        $count_kepribadian = Kuesioner_kategori::where('title', 'KOMPETENSI KEPRIBADIAN')->first()->kuesioner_pertanyaan()->count();
        $count_sosial = Kuesioner_kategori::where('title', 'KOMPETENSI SOSIAL')->first()->kuesioner_pertanyaan()->count();
        
        $list_detail_kuesioner = Kuesioner::select([
                't_kuesioner.nim',
                'm_mahasiswa.nama',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                DB::raw("COUNT(DISTINCT t_kuesioner.nim) AS count_penilai"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PEDAGOGIK' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_pedagogik"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PROFESIONAL' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_profesional"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI KEPRIBADIAN' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_kepribadian"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI SOSIAL' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_sosial")
            ])
            ->leftJoin('m_matkul', 't_kuesioner.id_matkul', 'm_matkul.id_matkul')
            ->rightJoin('t_kuesioner_detail', 't_kuesioner.id_kuesioner', 't_kuesioner_detail.id_kuesioner')
            ->leftJoin('m_kuesioner_pertanyaan', 't_kuesioner_detail.id_kuesioner_pertanyaan', 'm_kuesioner_pertanyaan.id_kuesioner_pertanyaan')
            ->leftJoin('m_kuesioner_kategori', 'm_kuesioner_pertanyaan.id_kuesioner_kategori', 'm_kuesioner_kategori.id_kuesioner_kategori')
            ->leftJoin('m_mahasiswa', 't_kuesioner.nim', 'm_mahasiswa.nim')
            ->where([
                't_kuesioner.id_dosen' => $id_dosen,
                't_kuesioner.id_matkul' => $id_matkul,
                't_kuesioner.tahun_akademik' => $tahun_akademik,
                't_kuesioner.id_semester' => $id_semester
            ])
            ->groupBy('t_kuesioner_detail.id_kuesioner')
            ->get();

        foreach ($list_detail_kuesioner as $list) {
            $list['no'] = $no++;
            $list['nim'] = $list->nim;
            $list['nama'] = $list->nama;
            $list['total_pedagogik'] = number_format(($list->sum_pedagogik / $count_pedagogik), 2);
            $list['total_profesional'] = number_format(($list->sum_profesional / $count_profesional), 2);
            $list['total_kepribadian'] = number_format(($list->sum_kepribadian / $count_kepribadian), 2);
            $list['total_sosial'] = number_format(($list->sum_sosial / $count_sosial), 2);

            $data[] = $list;
        }

        $dosen = Dosen::findOrFail($id_dosen);
        $matkul = Matkul::findOrFail($id_matkul);
        $tahun_akademik = TahunAkademik::where('tahun_akademik', $tahun_akademik)->first();
        $semester = Semester::findOrFail($id_semester);

        return view('pages.admin.angket_dosen.detail', compact('dosen', 'matkul', 'tahun_akademik', 'semester', 'data'));
    }

    protected function print($id_dosen, $id_matkul, $tahun_akademik, $id_semester)
    {
        $no = 1;
        $data = [];

        $count_pedagogik = Kuesioner_kategori::where('title', 'KOMPETENSI PEDAGOGIK')->first()->kuesioner_pertanyaan()->count();
        $count_profesional = Kuesioner_kategori::where('title', 'KOMPETENSI PROFESIONAL')->first()->kuesioner_pertanyaan()->count();
        $count_kepribadian = Kuesioner_kategori::where('title', 'KOMPETENSI KEPRIBADIAN')->first()->kuesioner_pertanyaan()->count();
        $count_sosial = Kuesioner_kategori::where('title', 'KOMPETENSI SOSIAL')->first()->kuesioner_pertanyaan()->count();
        
        $list_detail_kuesioner = Kuesioner::select([
                't_kuesioner.nim',
                'm_mahasiswa.nama',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                DB::raw("COUNT(DISTINCT t_kuesioner.nim) AS count_penilai"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PEDAGOGIK' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_pedagogik"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI PROFESIONAL' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_profesional"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI KEPRIBADIAN' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_kepribadian"),
                DB::raw("SUM(CASE WHEN m_kuesioner_kategori.title = 'KOMPETENSI SOSIAL' THEN t_kuesioner_detail.jawaban ELSE 0 END) AS sum_sosial")
            ])
            ->leftJoin('m_matkul', 't_kuesioner.id_matkul', 'm_matkul.id_matkul')
            ->rightJoin('t_kuesioner_detail', 't_kuesioner.id_kuesioner', 't_kuesioner_detail.id_kuesioner')
            ->leftJoin('m_kuesioner_pertanyaan', 't_kuesioner_detail.id_kuesioner_pertanyaan', 'm_kuesioner_pertanyaan.id_kuesioner_pertanyaan')
            ->leftJoin('m_kuesioner_kategori', 'm_kuesioner_pertanyaan.id_kuesioner_kategori', 'm_kuesioner_kategori.id_kuesioner_kategori')
            ->leftJoin('m_mahasiswa', 't_kuesioner.nim', 'm_mahasiswa.nim')
            ->where([
                't_kuesioner.id_dosen' => $id_dosen,
                't_kuesioner.id_matkul' => $id_matkul,
                't_kuesioner.tahun_akademik' => $tahun_akademik,
                't_kuesioner.id_semester' => $id_semester
            ])
            ->groupBy('t_kuesioner_detail.id_kuesioner')
            ->get();

        foreach ($list_detail_kuesioner as $list) {
            $list['no'] = $no++;
            $list['nim'] = $list->nim;
            $list['nama'] = $list->nama;
            $list['total_pedagogik'] = number_format(($list->sum_pedagogik / $count_pedagogik), 2);
            $list['total_profesional'] = number_format(($list->sum_profesional / $count_profesional), 2);
            $list['total_kepribadian'] = number_format(($list->sum_kepribadian / $count_kepribadian), 2);
            $list['total_sosial'] = number_format(($list->sum_sosial / $count_sosial), 2);

            $data[] = $list;
        }

        $dosen = Dosen::findOrFail($id_dosen);
        $matkul = Matkul::findOrFail($id_matkul);
        $tahun_akademik = TahunAkademik::where('tahun_akademik', $tahun_akademik)->first();
        $semester = Semester::findOrFail($id_semester);

        return view('pages.admin.angket_dosen.print', compact('dosen', 'matkul', 'tahun_akademik', 'semester', 'data'));
    }
}
