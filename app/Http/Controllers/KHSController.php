<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use File;
use Auth;
use Session;
use DB;
use DataTables;

use App\KHS;
use App\KRS;
use App\Jadwal;
use App\Grade_nilai;
use App\Persentase_nilai;
use App\MatkulPindahan;

class KHSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }
    
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

    public function get_ipk($semester)
    {
        $total_sks = 0;
        $total_score = 0;
        $total_ips = 0;
            
        for ($i = 1; $i <= $semester; $i++) {
            $lists = KHS::select([
                    't_khs.id_prodi',
                    't_khs.id_semester',
                    't_khs.id_kelas',
                    't_khs.kode_matkul',
                    't_khs.tahun_akademik',
                    't_khs.nim',
                    'm_matkul.id_matkul',
                    'm_matkul.nama_matkul',
                    'm_matkul.sks',
                    't_khs.hadir',
                    't_khs.tugas',
                    't_khs.uts',
                    't_khs.uas',
                    't_khs.total',
                    'm_grade_nilai.huruf',
                    'm_grade_nilai.bobot'
                ])
                ->leftjoin('m_matkul', 't_khs.kode_matkul', '=', 'm_matkul.kode_matkul')
                ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
                ->where([
                    't_khs.id_semester' => $semester,
                    't_khs.nim' => Auth::guard('mahasiswa')->user()->nim
                ])
                ->groupBy('m_matkul.kode_matkul')
                ->get();
                
            if (Auth::guard('mahasiswa')->user()->id_status == 6) {
                $lists = KRS::select([
                    't_khs.id_prodi',
                    't_khs.id_semester',
                    't_khs.id_kelas',
                    't_khs.kode_matkul',
                    't_khs.tahun_akademik',
                    't_khs.nim',
                    'm_matkul.id_matkul',
                    'm_matkul.nama_matkul',
                    'm_matkul.sks',
                    't_khs.hadir',
                    't_khs.tugas',
                    't_khs.uts',
                    't_khs.uas',
                    't_khs.total',
                    'm_grade_nilai.huruf',
                    'm_grade_nilai.bobot'
                ])
                ->rightJoin('t_krs_item', 't_krs.id_krs', 't_krs_item.id_krs')
                ->leftjoin('m_matkul', 't_krs_item.id_matkul', 'm_matkul.id_matkul')
                ->leftJoin('t_khs', function ($join) {
                    $join->on('m_matkul.kode_matkul', '=', 't_khs.kode_matkul');
                    $join->on('t_krs.nim', '=', 't_khs.nim');
                    $join->on('t_krs_item.id_kelas', '=', 't_khs.id_kelas');
                })
                ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
                ->where([
                    't_krs.id_semester' => $semester,
                    't_krs.nim' => Auth::guard('mahasiswa')->user()->nim
                ])
                ->groupBy('m_matkul.kode_matkul')
                ->get();
            }
            
            foreach ($lists as $list) {
                $persentase_nilai = Jadwal::select([
                        't_nilai_persentase.*'
                    ])
                    ->where([
                        't_jadwal.id_prodi' => $list->id_prodi,
                        't_jadwal.id_semester' => $list->id_semester,
                        't_jadwal.id_kelas' => $list->id_kelas,
                        't_jadwal.tahun_akademik' => $list->tahun_akademik,
                        'm_matkul.kode_matkul' => $list->kode_matkul,
                    ])
                    ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
                    ->leftJoin('t_nilai_persentase', 't_jadwal.id_dosen', 't_nilai_persentase.id_dosen')
                    ->first();
    
                $jumlah_pertemuan = DB::table('t_absensi')
                    ->where([
                        'id_kelas' => $list->id_kelas,
                        'id_matkul' => $list->id_matkul
                    ])
                    ->groupBy('tanggal')
                    ->groupBy('pertemuan_ke')
                    ->get();
                
                $jumlah_pertemuan = count($jumlah_pertemuan);
    
                $kehadiran = DB::table('t_absensi')
                    ->select('t_absensi.pertemuan_ke')
                    ->leftJoin('t_jadwal', 't_absensi.id_jadwal', 't_jadwal.id_jadwal')
                    ->where([
                        't_absensi.nim' => $list->nim,
                        't_absensi.id_matkul' => $list->id_matkul,
                        't_absensi.id_kelas' => $list->id_kelas,
                        't_absensi.keterangan' => 'Hadir',
                        't_jadwal.tahun_akademik' => $list->tahun_akademik
                    ])
                    ->groupBy('t_absensi.tanggal')
                    ->groupBy('t_absensi.pertemuan_ke')
                    ->get();
                
                if (count($kehadiran) > 0) {
                    $list['hadir'] = number_format(100 / ($jumlah_pertemuan / count($kehadiran)), 0);
                } else {
                    $list['hadir'] = 0;
                }
                
                $list['total'] = 0;
    
                $list['total'] += (empty($list['hadir']) ? 0 : (empty($persentase_nilai->kehadiran) ? 0 : $persentase_nilai->kehadiran) / 100) * $list['hadir'];
                $list['total'] += (empty($list['tugas']) ? 0 : (empty($persentase_nilai->tugas) ? 0 : $persentase_nilai->tugas) / 100) * $list['tugas'];
                $list['total'] += (empty($list['uts']) ? 0 : (empty($persentase_nilai->uts) ? 0 : $persentase_nilai->uts) / 100) * $list['uts'];
                $list['total'] += (empty($list['uas']) ? 0 : (empty($persentase_nilai->uas) ? 0 : $persentase_nilai->uas) / 100) * $list['uas'];
    
                $list['huruf'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                $list['grade'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                $list['bobot'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->bobot;

                $total_sks += $list->sks;
                $total_score += ($list->sks * $list['bobot']);
                if (! empty($total_score)) $total_ips = number_format($total_score / $total_sks, 2);
            }
        }

        return number_format($total_ips / $semester, 2);
    }

    function semester($semester)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $matkul_pindahan_array = [];
        $nilai_grade_pindahan = [
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            'E' => 0
        ];

        if ($mahasiswa->id_status == 6) {
            $matkul_pindahan = MatkulPindahan::select([
                'tbl_matkul_pindahan.id_matkul_pindahan',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'tbl_detail_matkul_pindahan.sks',
                'tbl_detail_matkul_pindahan.nilai'
            ])
            ->leftjoin('tbl_detail_matkul_pindahan', 'tbl_matkul_pindahan.id_matkul_pindahan', 'tbl_detail_matkul_pindahan.id_matkul_pindahan')
            ->leftJoin('m_matkul', 'tbl_detail_matkul_pindahan.id_matkul', 'm_matkul.id_matkul')
            ->where([
                'tbl_matkul_pindahan.nim' => $mahasiswa->nim
            ])
            ->get();

            foreach ($matkul_pindahan as $mp) {
                $matkul_pindahan_array[$mp->kode_matkul] = $mp;
            }
        }

        $no = 1;
        
        $matkul = [];

        $lists = KHS::select([
                't_khs.id_prodi',
                't_khs.id_semester',
                't_khs.id_kelas',
                't_khs.kode_matkul',
                't_khs.tahun_akademik',
                't_khs.nim',
                'm_matkul.id_matkul',
                'm_matkul.nama_matkul',
                'm_matkul.sks',
                't_khs.hadir',
                't_khs.tugas',
                't_khs.uts',
                't_khs.uas',
                't_khs.total',
                'm_grade_nilai.huruf',
                'm_grade_nilai.bobot'
            ])
            ->leftjoin('m_matkul', 't_khs.kode_matkul', '=', 'm_matkul.kode_matkul')
            ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
            ->where([
                't_khs.id_semester' => $semester,
                't_khs.nim' => Auth::guard('mahasiswa')->user()->nim
            ])
            ->groupBy('m_matkul.kode_matkul')
            ->get();
            
        if (Auth::guard('mahasiswa')->user()->id_status == 6) {
            $lists = KRS::select([
                't_khs.id_prodi',
                't_khs.id_semester',
                't_khs.id_kelas',
                't_khs.kode_matkul',
                't_khs.tahun_akademik',
                't_khs.nim',
                'm_matkul.id_matkul',
                'm_matkul.nama_matkul',
                'm_matkul.sks',
                't_khs.hadir',
                't_khs.tugas',
                't_khs.uts',
                't_khs.uas',
                't_khs.total',
                'm_grade_nilai.huruf',
                'm_grade_nilai.bobot'
            ])
            ->rightJoin('t_krs_item', 't_krs.id_krs', 't_krs_item.id_krs')
            ->leftjoin('m_matkul', 't_krs_item.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('t_khs', function ($join) {
                $join->on('m_matkul.kode_matkul', '=', 't_khs.kode_matkul');
                $join->on('t_krs.nim', '=', 't_khs.nim');
                $join->on('t_krs_item.id_kelas', '=', 't_khs.id_kelas');
            })
            ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
            ->where([
                't_krs.id_semester' => $semester,
                't_krs.nim' => Auth::guard('mahasiswa')->user()->nim
            ])
            ->groupBy('m_matkul.kode_matkul')
            ->get();
        }
            
        foreach ($lists as $list) {
            $persentase_nilai = Jadwal::select([
                    't_nilai_persentase.*'
                ])
                ->where([
                    't_jadwal.id_prodi' => $list->id_prodi,
                    't_jadwal.id_semester' => $list->id_semester,
                    't_jadwal.id_kelas' => $list->id_kelas,
                    't_jadwal.tahun_akademik' => $list->tahun_akademik,
                    'm_matkul.kode_matkul' => $list->kode_matkul,
                ])
                ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
                ->leftJoin('t_nilai_persentase', 't_jadwal.id_dosen', 't_nilai_persentase.id_dosen')
                ->first();

            $jumlah_pertemuan = DB::table('t_absensi')
                ->where([
                    'id_kelas' => $list->id_kelas,
                    'id_matkul' => $list->id_matkul
                ])
                ->groupBy('tanggal')
                ->groupBy('pertemuan_ke')
                ->get();

            $jumlah_pertemuan = count($jumlah_pertemuan);


            $kehadiran = DB::table('t_absensi')
                ->select('t_absensi.pertemuan_ke')
                ->leftJoin('t_jadwal', 't_absensi.id_jadwal', 't_jadwal.id_jadwal')
                ->where([
                    't_absensi.nim' => $list->nim,
                    't_absensi.id_matkul' => $list->id_matkul,
                    't_absensi.id_kelas' => $list->id_kelas,
                    't_absensi.keterangan' => 'Hadir',
                    // 't_jadwal.tahun_akademik' => $list->tahun_akademik
                ])
                ->groupBy('t_absensi.tanggal')
                ->groupBy('t_absensi.pertemuan_ke')
                ->get();
            
            if (count($kehadiran) > 0) {
                $list['hadir'] = number_format(100 / ($jumlah_pertemuan / count($kehadiran)), 0);
                $list['jumlah_hadir'] = count($kehadiran);
            } else {
                $list['hadir'] = 0;
                $list['jumlah_hadir'] = count($kehadiran);
            }

            if ($mahasiswa->id_status != 6) {
                $list['total'] = 0;
    
                $list['total'] += (empty($list['hadir']) ? 0 : (empty($persentase_nilai->kehadiran) ? 0 : $persentase_nilai->kehadiran) / 100) * $list['hadir'];
                $list['total'] += (empty($list['tugas']) ? 0 : (empty($persentase_nilai->tugas) ? 0 : $persentase_nilai->tugas) / 100) * $list['tugas'];
                $list['total'] += (empty($list['uts']) ? 0 : (empty($persentase_nilai->uts) ? 0 : $persentase_nilai->uts) / 100) * $list['uts'];
                $list['total'] += (empty($list['uas']) ? 0 : (empty($persentase_nilai->uas) ? 0 : $persentase_nilai->uas) / 100) * $list['uas'];
                
                 $list['huruf'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                 $list['grade'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                 $list['bobot'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->bobot;
            } else {
                if (in_array($list->kode_matkul, array_keys($matkul_pindahan_array))) {
                    $mp = $matkul_pindahan_array[$list->kode_matkul];
                    $total_nilai = 0;
                    $huruf = $mp->nilai;
                    $bobot = 0;
                    
                    if (is_numeric($mp->nilai)) {
                        $huruf = $nilai_grade_pindahan[$mp->nilai];
                        $total_nilai = $mp->nilai * $mp->sks;
                    } else {
                        $total_nilai = $nilai_grade_pindahan[$mp->nilai] * $mp->sks;
                    }

                    $list['huruf'] = $huruf;
                    $list['grade'] = $total_nilai;
                    $list['bobot'] = $huruf;
                }
            }
            
            
            $matkul[] = $list;
        }
        
        // $count = KHS::where(['t_khs.id_semester' => $semester, 'nim' => Auth::guard('mahasiswa')->user()->nim])->leftjoin('m_matkul', 't_khs.kode_matkul', 'm_matkul.kode_matkul')->count();

        // $matkul = KRS::select([
        //         'm_matkul.kode_matkul',
        //         'm_matkul.nama_matkul',
        //         'm_matkul.sks',
        //         't_khs.total',
        //         'm_grade_nilai.huruf',
        //         'm_grade_nilai.bobot',
        //         't_krs_item.is_repeat'
        //     ])
        //     ->rightJoin('t_krs_item', 't_krs.id_krs', '=', 't_krs_item.id_krs')
        //     ->leftJoin('m_matkul', 't_krs_item.id_matkul', '=', 'm_matkul.id_matkul')
        //     ->leftJoin('t_khs', function ($join) {
        //         //$join->on('t_krs.tahun_akademik', 't_khs.tahun_akademik');
        //         $join->on('t_krs.nim', 't_khs.nim');
        //         $join->on('m_matkul.kode_matkul', 't_khs.kode_matkul');
        //         // $join->on('t_krs.id_semester', 't_khs.id_semester');
        //     })
        //     ->leftJoin('m_grade_nilai', 't_khs.tahun_akademik', '=', DB::raw("m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max"))
        //     ->where([
        //         't_krs.nim' => Auth::guard('mahasiswa')->user()->nim,
        //         't_krs.id_semester' => $semester
        //     ])
        //     ->orderBy('t_khs.total', 'DESC')
        //     ->groupBy('m_matkul.nama_matkul')
        //     ->get();
        
        // $count = $matkul->count();
        
        $count = count($matkul);
        $ipk = $this->get_ipk($semester);

        return view('pages.mahasiswa.khs.getNilai', compact('semester', 'matkul', 'no', 'count', 'ipk'));
    }
}
