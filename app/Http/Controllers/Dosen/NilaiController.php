<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Jadwal;
use App\Matkul;
use App\Nilai;
use App\Persentase_nilai;
use App\Nilai_mahasiswa;
use App\TahunAkademik;
use App\KHS;
use App\PembukaanInputNilai;
use App\Grade_nilai;

class NilaiController extends Controller
{
    public function get_grade_nilai($tahun_akademik, $nilai)
    {
        $grade_nilai = Grade_nilai::where('tahun_akademik', '=', $tahun_akademik)
            ->orderBy('huruf', 'ASC')
            ->get();
            
        foreach ($grade_nilai as $list) {
            if ($nilai >= $list->nilai_min && $nilai <= $list->nilai_max) {
                return $list;
            }
        }
    }
    
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
                select j.tahun_akademik, j.id_matkul, j.id_semester, m.kode_matkul, j.id_kelas, m.kode_matkul, m.nama_matkul, m.sks, k.id_prodi, k.kode_kelas
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

        $pembukaan_input_nilai = PembukaanInputNilai::where([
            ['tanggal_mulai', '<=', Date('Y-m-d')],
            ['tanggal_selesai', '>=', Date('Y-m-d')]
        ])->count();

        return view('pages.dosen.nilai.index', compact('list_tahun_akademik', 'list_kelas', 'pembukaan_input_nilai'));
    }

    public function input($tahun_akademik, $id_kelas, $kode_matkul)
    {
        $khs = KHS::where([
            'tahun_akademik' => $tahun_akademik,
            'id_kelas' => $id_kelas,
            'kode_matkul' => $kode_matkul
        ])->get();

        if ($khs->count() < 1)
        {
            $nilai = array();
        }

        $jadwal = Jadwal::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
            'tahun_akademik' => $tahun_akademik,
            'id_kelas' => $id_kelas,
            'kode_matkul' => $kode_matkul
        ])
        ->leftJoin('m_matkul', 't_jadwal.id_matkul', '=', 'm_matkul.id_matkul')
        ->first();
        
        $matkul = $jadwal->matkul;

        $persentase_nilai = Persentase_nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen
        ])->first();

        // $kelas_detail = $jadwal->kelas->kelas_detail->pluck('nim');
        // $kelas_detail_remedial = $jadwal->kelas->kelas_detail_remedial()->where('m_kelas_detail_remedial.id_matkul', $matkul->id_matkul)->pluck('nim');
        
        // $kelas_detail = array_merge($kelas_detail->toArray(), $kelas_detail_remedial->toArray());
        // $kelas_detail = json_encode($kelas_detail);
        
        // $kelas_detail = substr(substr(str_replace('"', "'", $kelas_detail), 0, -1), 1);
            
        $jumlah_pertemuan = DB::table('t_absensi')
            ->where([
                'id_kelas' => $id_kelas,
                'id_matkul' => $matkul->id_matkul
            ])
            ->groupBy('tanggal') 
            ->groupBy('pertemuan_ke') 
            ->get();
        
        $jumlah_pertemuan = count($jumlah_pertemuan);
        
        $grade_nilai = Grade_nilai::where('tahun_akademik', '=', $tahun_akademik)
            ->orderBy('huruf', 'ASC')
            ->get();

        // if ($khs->count() < 1)
        // {
        //     if (empty($kelas_detail))
        //     {
        //         $list_mahasiswa = array();
        //     }
        //     else
        //     {
        //         $list_mahasiswa = DB::select(DB::raw("
        //             select m.nim, m.nama, (100 / ((select count(distinct tanggal) from t_absensi where id_matkul = mk.id_matkul and id_kelas = k.id_kelas) / count(distinct a.tanggal))) as hadir
        //             from m_kelas_detail kd
        //             left join m_mahasiswa m on kd.nim = m.nim
        //             left join t_absensi a on kd.nim = a.nim and a.keterangan = 'Hadir'
        //             left join m_kelas k on a.id_kelas = k.id_kelas
        //             left join m_matkul mk on a.id_matkul = mk.id_matkul
        //             where kd.nim in(".$kelas_detail.") and k.id_kelas = '".$id_kelas."' and mk.kode_matkul = '".$kode_matkul."'
        //             group by m.nim
        //             order by m.nim asc
        //         "));
        //     }
        // }
        // else
        // {
            $kelas_detail = $jadwal->kelas->kelas_detail->pluck('nim');
            $kelas_detail_remedial = $jadwal->kelas->kelas_detail_remedial()->where('m_kelas_detail_remedial.id_matkul', $matkul->id_matkul)->pluck('nim');
            
            $kelas_detail = array_merge($kelas_detail->toArray(), $kelas_detail_remedial->toArray());

            $list_mahasiswa = [];
            
            $list_kelas_detail = DB::table('m_kelas_detail')
                ->select([
                    'm_kelas_detail.nim',
                    'm_mahasiswa.nama',
                ])
                ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', 'm_mahasiswa.nim')
                ->whereIn('m_kelas_detail.nim', $kelas_detail)
                ->groupBy('m_kelas_detail.nim')
                ->get();
                
            $list_kelas_detail_remedial = DB::table('m_kelas_detail_remedial')
                ->select([
                    'm_kelas_detail_remedial.nim',
                    'm_mahasiswa.nama',
                ])
                ->leftJoin('m_mahasiswa', 'm_kelas_detail_remedial.nim', 'm_mahasiswa.nim')
                ->whereIn('m_kelas_detail_remedial.nim', $kelas_detail)
                ->groupBy('m_kelas_detail_remedial.nim')
                ->get();
                
            $lists = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

            $lists = json_decode(json_encode($lists), FALSE);
            
            foreach ($lists as $list) {
                $khs = DB::table('t_khs')
                    ->select([
                        't_khs.tugas',
                        't_khs.uts',
                        't_khs.uas',
                        't_khs.total',
                    ])
                    ->where([
                        't_khs.nim' => $list->nim,
                        't_khs.id_kelas' => $id_kelas,
                        't_khs.kode_matkul' => $kode_matkul,
                        't_khs.tahun_akademik' => $tahun_akademik
                    ])
                    ->first();
                    
                if (! empty($khs)) {
                    $list->{'tugas'} = $khs->tugas;
                    $list->{'uts'} = $khs->uts;
                    $list->{'uas'} = $khs->uas;
                } else {
                    $list->{'tugas'} = 0;
                    $list->{'uts'} = 0;
                    $list->{'uas'} = 0;
                }
                
                $kehadiran = DB::table('t_absensi')
                    ->select('t_absensi.pertemuan_ke')
                    ->leftJoin('t_jadwal', 't_absensi.id_jadwal', 't_jadwal.id_jadwal')
                    ->where([
                        't_absensi.nim' => $list->nim,
                        't_absensi.id_matkul' => $matkul->id_matkul,
                        't_absensi.id_kelas' => $id_kelas,
                        't_absensi.keterangan' => 'Hadir',
                        't_jadwal.tahun_akademik' => $tahun_akademik
                    ])
                    ->groupBy('t_absensi.tanggal')
                    ->groupBy('t_absensi.pertemuan_ke')
                    ->get();
                
                if (count($kehadiran) > 0) {
                    $list->{'hadir'} = 100 / ($jumlah_pertemuan / count($kehadiran));
                } else {
                    $list->{'hadir'} = 0;
                }
                
                $list->{'total'} = 0;

                $list->{'total'} += (empty($list->{'hadir'}) ? 0 : (empty($persentase_nilai->kehadiran) ? 0 : $persentase_nilai->kehadiran) / 100) * $list->{'hadir'};
                $list->{'total'} += (empty($list->{'tugas'}) ? 0 : (empty($persentase_nilai->tugas) ? 0 : $persentase_nilai->tugas) / 100) * $list->{'tugas'};
                $list->{'total'} += (empty($list->{'uts'}) ? 0 : (empty($persentase_nilai->uts) ? 0 : $persentase_nilai->uts) / 100) * $list->{'uts'};
                $list->{'total'} += (empty($list->{'uas'}) ? 0 : (empty($persentase_nilai->uas) ? 0 : $persentase_nilai->uas) / 100) * $list->{'uas'};
                
                $list->{'huruf'} = @$this->get_grade_nilai($tahun_akademik, $list->{'total'})->huruf;
                $list->{'grade'} = @$this->get_grade_nilai($tahun_akademik, $list->{'total'})->huruf;
                $list->{'bobot'} = @$this->get_grade_nilai($tahun_akademik, $list->{'total'})->bobot;

                $list_mahasiswa[] = $list;
            // }
        }

        return view('pages.dosen.nilai.input', compact('matkul', 'list_mahasiswa', 'tahun_akademik', 'id_kelas', 'nilai', 'persentase_nilai', 'jumlah_pertemuan', 'grade_nilai'));
    }

    public function input_simpan($tahun_akademik, $id_kelas, $kode_matkul, Request $request)
    {
        $list_nilai_mahasiswa = array();

        $m_matkul = Matkul::where('kode_matkul', $kode_matkul)->first();

        $khs = KHS::where([
            'tahun_akademik' => $tahun_akademik,
            'id_kelas' => $id_kelas,
            'kode_matkul' => $kode_matkul
        ])->get();

        $jadwal = Jadwal::where([
            'tahun_akademik' => $tahun_akademik,
            'id_kelas' => $id_kelas,
            'id_matkul' => $m_matkul->id_matkul
        ])->first();

        $persentase_nilai = Persentase_nilai::where([
            'id_dosen' => Auth::guard('dosen')->user()->id_dosen
        ])->first();

        if ($khs->count() < 1)
        {
            foreach ($request->nim as $key => $val)
            {
                $list_nilai_mahasiswa[] = array(
                    'tahun_akademik' => $tahun_akademik,
                    'nim' => $key,
                    'kode_matkul' => $kode_matkul,
                    'id_prodi' => $jadwal->id_prodi,
                    'id_semester' => $jadwal->id_semester,
                    'id_kelas' => $id_kelas,
                    'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                    'hadir' => $val['hadir'],
                    'tugas' => $val['tugas'],
                    'uts' => $val['uts'],
                    'uas' => $val['uas'],
                    'total' => $val['total'],
                    'bobot' => $val['bobot']
                );
            }
            
            $create = KHS::insert($list_nilai_mahasiswa);
        }
        else
        {
            foreach ($request->nim as $key => $val)
            {
                $mahasiswa_khs = KHS::where([
                        'nim' => $key,
                        'tahun_akademik' => $tahun_akademik,
                        'id_kelas' => $id_kelas,
                        'kode_matkul' => $kode_matkul
                    ])
                    ->first();

                if ($mahasiswa_khs->total <= $val['total']) {
                    $list_nilai_mahasiswa[] = array(
                        'tahun_akademik' => $tahun_akademik,
                        'nim' => $key,
                        'kode_matkul' => $kode_matkul,
                        'id_prodi' => $jadwal->id_prodi,
                        'id_semester' => $jadwal->id_semester,
                        'id_kelas' => $id_kelas,
                        'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                        'hadir' => $val['hadir'],
                        'tugas' => $val['tugas'],
                        'uts' => $val['uts'],
                        'uas' => $val['uas'],
                        'total' => $val['total'],
                        'bobot' => $val['bobot']
                    );
                } else {
                    $list_nilai_mahasiswa[] = array(
                        'tahun_akademik' => $tahun_akademik,
                        'nim' => $key,
                        'kode_matkul' => $kode_matkul,
                        'id_prodi' => $jadwal->id_prodi,
                        'id_semester' => $jadwal->id_semester,
                        'id_kelas' => $id_kelas,
                        'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                        'hadir' => $mahasiswa_khs['hadir'],
                        'tugas' => $mahasiswa_khs['tugas'],
                        'uts' => $mahasiswa_khs['uts'],
                        'uas' => $mahasiswa_khs['uas'],
                        'total' => $mahasiswa_khs['total'],
                        'bobot' => $mahasiswa_khs['bobot']
                    );
                }
            }

            $delete = KHS::where([
                'tahun_akademik' => $tahun_akademik,
                'id_kelas' => $id_kelas,
                'kode_matkul' => $kode_matkul
            ])->delete();

            $create = KHS::insert($list_nilai_mahasiswa);
        }

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return redirect()->route('dosen.nilai.index');
    }
}
