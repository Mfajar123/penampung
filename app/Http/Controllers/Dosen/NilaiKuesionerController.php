<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\TahunAkademik;
use App\Kuesioner;
use App\Kuesioner_detail;
use App\Kuesioner_kategori;

class NilaiKuesionerController extends Controller
{
    public function index(Request $request)
    {
        $no = 1;
        $data = [];

        $dosen = Auth::guard('dosen')->user();
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        if ($request->tahun_akademik) {
            $list_kuesioner = Kuesioner::select([
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
                ->where([
                    't_kuesioner.id_dosen' => $dosen->id_dosen,
                    't_kuesioner.tahun_akademik' => $request->tahun_akademik
                ])
                ->groupBy('t_kuesioner.id_matkul')
                ->get();

            $count_pedagogik = Kuesioner_kategori::where('title', 'KOMPETENSI PEDAGOGIK')->first()->kuesioner_pertanyaan()->count();
            $count_profesional = Kuesioner_kategori::where('title', 'KOMPETENSI PROFESIONAL')->first()->kuesioner_pertanyaan()->count();
            $count_kepribadian = Kuesioner_kategori::where('title', 'KOMPETENSI KEPRIBADIAN')->first()->kuesioner_pertanyaan()->count();
            $count_sosial = Kuesioner_kategori::where('title', 'KOMPETENSI SOSIAL')->first()->kuesioner_pertanyaan()->count();

            foreach ($list_kuesioner as $list) {
                $list['no'] = $no++;
                $list['total_pedagogik'] = number_format((($list->sum_pedagogik / $list->count_penilai) / $count_pedagogik), 2);
                $list['total_profesional'] = number_format((($list->sum_profesional / $list->count_penilai) / $count_profesional), 2);
                $list['total_kepribadian'] = number_format((($list->sum_kepribadian / $list->count_penilai) / $count_kepribadian), 2);
                $list['total_sosial'] = number_format((($list->sum_sosial / $list->count_penilai) / $count_sosial), 2);

                $data[] = $list;
            }
        }
        
        return view('pages.dosen.kuesioner.nilai.index', compact('list_tahun_akademik', 'data'));
    }
}
