<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\Jadwal;
use App\Matkul;
use App\Nilai;
use App\Nilai_mahasiswa;
use App\TahunAkademik;
use App\KHS;

class NilaiController extends Controller
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
        $list_kelas = array();

        foreach ($jadwal_akademik as $jadwal)
        {
            $list_tahun_akademik[$jadwal->tahun_akademik] = $jadwal->keterangan;
        }

        if ($request->tahun_akademik)
        {
            $list_kelas = DB::select(DB::raw("
                select ta.id_tahun_akademik, j.id_matkul, j.id_kelas, m.kode_matkul, m.nama_matkul, m.sks, k.id_prodi, k.kode_kelas
                from t_jadwal j
                left join m_kelas k on j.id_kelas = k.id_kelas
                left join m_matkul m on j.id_matkul = m.id_matkul
                left join t_tahun_akademik ta on j.tahun_akademik = ta.tahun_akademik
                where
                j.id_dosen = '".Auth::guard('dosen')->user()->id_dosen."' and j.tahun_akademik = '".$request->tahun_akademik."'
                group by j.id_kelas, j.id_matkul
                order by j.id_kelas asc, j.id_matkul asc
            "));
        }

        return view('pages.dosen.nilai.index', compact('list_tahun_akademik', 'list_kelas'));
    }

    public function input($id_tahun_akademik, $id_kelas, $id_matkul)
    {
        $nilai = Nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
            'id_tahun_akademik' => $id_tahun_akademik,
            'id_kelas' => $id_kelas,
            'id_matkul' => $id_matkul
        ])->get();

        if (empty($nilai) || count($nilai) < 1)
        {
            $nilai = array();
        }

        $tahun_akademik = TahunAkademik::findOrFail($id_tahun_akademik);

        $jadwal = Jadwal::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
            'tahun_akademik' => $tahun_akademik->tahun_akademik,
            'id_kelas' => $id_kelas,
            'id_matkul' => $id_matkul
        ])->first();

        $matkul = $jadwal->matkul;

        $kelas_detail = $jadwal->kelas->kelas_detail->pluck('nim');

        $kelas_detail = substr(substr(str_replace('"', "'", $kelas_detail), 0, -1), 1);

        if (empty($nilai) || count($nilai) < 1)
        {
            $list_mahasiswa = DB::select(DB::raw("
                select m.nim, m.nama
                from m_kelas_detail kd
                left join m_mahasiswa m on kd.nim = m.nim
                where kd.nim in(".$kelas_detail.")
                order by m.nama asc
            "));
        }
        else
        {
            $list_mahasiswa = DB::select(DB::raw("
                select m.nim, m.nama, nm.tugas, nm.uts, nm.uas
                from m_kelas_detail kd
                left join m_mahasiswa m on kd.nim = m.nim
                right join t_nilai_mahasiswa nm on kd.nim = nm.nim
                where kd.nim in(".$kelas_detail.")
                order by m.nama asc
            "));
        }

        return view('pages.dosen.nilai.input', compact('matkul', 'list_mahasiswa', 'id_tahun_akademik', 'id_kelas', 'nilai'));
    }

    public function input_simpan($id_tahun_akademik, $id_kelas, $id_matkul, Request $request)
    {
        $input = array();
        $input['id_tahun_akademik'] = $id_tahun_akademik;
        $input['id_kelas'] = $id_kelas;
        $input['id_matkul'] = $id_matkul;
        $input['id_dosen'] = Auth::guard('dosen')->user()->id_dosen;

        $list_nilai_mahasiswa = array();

        $nilai = Nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
            'id_tahun_akademik' => $id_tahun_akademik,
            'id_kelas' => $id_kelas,
            'id_matkul' => $id_matkul
        ])->get();

        if (empty($nilai) || count($nilai) < 1)
        {
            $nilai = Nilai::create($input);

            foreach ($request->nim as $key => $val)
            {
                $list_nilai_mahasiswa[] = array(
                    'id_nilai' => $nilai->id_nilai,
                    'nim' => $key,
                    'tugas' => $val['tugas'],
                    'uts' => $val['uts'],
                    'uas' => $val['uas']
                );
            }
            
            $nilai->nilai_mahasiswa()->insert($list_nilai_mahasiswa);
        }
        else
        {
            $nilai = $nilai->first();
            
            $nilai->update($input);

            foreach ($request->nim as $key => $val)
            {
                $list_nilai_mahasiswa[] = array(
                    'id_nilai' => $nilai->id_nilai,
                    'nim' => $key,
                    'tugas' => $val['tugas'],
                    'uts' => $val['uts'],
                    'uas' => $val['uas']
                );
            }

            $nilai->nilai_mahasiswa()->delete();
            $nilai->nilai_mahasiswa()->insert($list_nilai_mahasiswa);            
        }

        return redirect()->route('dosen.nilai.index');
    }
}
