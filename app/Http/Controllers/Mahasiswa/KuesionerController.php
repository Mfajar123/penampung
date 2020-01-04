<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;

use DB;
use Auth;

use App\Kuesioner_form;
use App\Kuesioner;
use App\Kuesioner_detail;
use App\Jadwal;
use App\KRS;

class KuesionerController extends Controller
{
    private $options;

    public function __construct()
    {
        $this->options = new OptionsController();
    }

    public function index()
    {
        $kuesioner_form = Kuesioner_form::findOrFail(1);
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tahun_akademik = $this->options->get_now_tahun_akademik();
        $id_semester = $this->options->get_now_semester($mahasiswa->nim, $tahun_akademik);

        $krs = KRS::where([
                'tahun_akademik' => $tahun_akademik,
                'nim' => $mahasiswa->nim
            ])
            ->first();

        $krs_item = (! empty($krs) && $krs->krs_item()->count() > 0) ? $krs->krs_item()->pluck('id_matkul') : [];

        $jadwal = DB::table('t_jadwal AS j')
            ->select([
                'j.id_kelas',
                'j.id_matkul',
                'j.id_dosen',
                'j.id_semester',
                'j.tahun_akademik',
                'kd.nim',
                'k.kode_kelas',
                'k.nama_kelas',
                'm.kode_matkul',
                'm.nama_matkul',
                's.semester_ke',
                'd.gelar_depan',
                'd.gelar_belakang',
                'd.nama',
                'd.nip'
            ])
            ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
            ->leftJoin('m_kelas AS k', 'j.id_kelas', '=', 'k.id_kelas')
            ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
            ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
            ->rightJoin('m_kelas_detail AS kd', 'k.id_kelas', '=', 'kd.id_kelas')
            ->leftJoin('t_kuesioner', function ($join) {
                $join->on('j.id_dosen', '=', 't_kuesioner.id_dosen');
                $join->on('kd.nim', '=', 't_kuesioner.nim');
                $join->on('j.id_semester', '=', 't_kuesioner.id_semester');
                $join->on('j.id_matkul', '=', 't_kuesioner.id_matkul');
                $join->on('j.id_kelas', '=', 't_kuesioner.id_kelas');
            })
            ->where([
                'j.tahun_akademik' => $tahun_akademik,
                'kd.nim' => $mahasiswa->nim
            ])
            ->whereIn('m.id_matkul', $krs_item)
            ->whereNull('t_kuesioner.id_kuesioner')
            ->groupBy('j.id_matkul')
            ->groupBy('j.id_dosen')
            ->groupBy('j.id_kelas')
            ->groupBy('j.id_semester')
            ->first();

        if (! empty($jadwal)) return view('pages.mahasiswa.kuesioner.index', compact('kuesioner_form', 'jadwal'));

        return redirect()->route('mahasiswa.khs');
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        $input['id_kuesioner_form'] = 1;
        $input['tanggal'] = date('Y-m-d H:i:s');

        $data_kuesioner_detail = [];

        $kuesioner = Kuesioner::create($input);

        foreach ($request->kuesioner_detail as $key => $value) {
            $data_kuesioner_detail[] = [
                'id_kuesioner' => $kuesioner->id_kuesioner,
                'id_kuesioner_pertanyaan' => $key,
                'jawaban' => $value
            ];
        }

        $kuesioner_detail = Kuesioner_detail::insert($data_kuesioner_detail);

        return redirect()->back();
    }
}
