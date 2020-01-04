<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OptionsController;

use Auth;
use DB;
use PDF;

use App\Mahasiswa;
use App\Pengumuman;
use App\Jadwal;
use App\TahunAkademik;
use App\KRS;
use App\KRSItem;
use App\Kuesioner_form;
use App\Kuesioner;
use App\Kuesioner_detail;
use App\KHS;
use App\Grade_nilai;
use App\KelasDetail;
use App\Jadwal_ujian;

class MahasiswaController extends Controller
{
    private $options;
    
    function __construct(Request $req)
    {
    	$this->middleware('auth:mahasiswa,wali');
    	$this->options = new OptionsController();
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
                $total_ips = number_format($total_score / $total_sks, 2);
            }
        }

        return [
            'ipk' => number_format($total_ips / $semester, 2),
            'total_sks' => $total_sks
        ];
    }

    function index()
    {
        $list_pengumuman = Pengumuman::where([
                ['umumkan_ke', '!=', 'Dosen'],
                'is_delete' => 'N'
            ])
            ->orderBy('waktu_pengumuman', 'DESC')
            ->take(5)
            ->skip(0)
            ->get();
        
        return view('pages.mahasiswa.dashboard.index', compact('list_pengumuman'));
    }
    
    function password(Request $req)
    {
        $system = New SystemController();
        $route = 'mahasiswa.password.ubah';

        $id = Auth::guard('mahasiswa')->user()->id_mahasiswa;
        $profil = Mahasiswa::find($id);

        $password = $system->decrypt($profil->password, $profil->nim, $profil->nim);

        return view('pages.profil.password', compact('system', 'route', 'id', 'profil', 'password'));
    }
    
    public function jadwal()
    {
        $tahun_akademik = @$_GET['tahun_akademik'];
        $list_jadwal = array();
        $no = 1;
        $t = @$_GET['tahun_akademik'];
        // $jadwal = KRSItem::join('t_krs', 't_krs.id_krs', '=', 't_krs_item.id_krs')->where('nim', Auth::guard('mahasiswa')->user()->nim)->where('tahun_akademik', $t)->get();
        if (Auth::guard('mahasiswa')->check()) {
            $krs = KRS::where([
                    'tahun_akademik' => $t,
                    'nim' => Auth::guard('mahasiswa')->user()->nim,
                    'status' => 'Y'
                ])
                ->first();
        } elseif (Auth::guard('wali')->check()) {
            $krs = KRS::where([
                    'tahun_akademik' => $t,
                    'nim' => Auth::guard('wali')->user()->nim,
                    'status' => 'Y'                    
                ])
                ->first();   
        }

        $jadwal = Jadwal::where(['tahun_akademik' => $t, 'id_semester' => ! empty($krs->id_semester) ? $krs->id_semester : '-'])->get();
        $tahun_akademik = TahunAkademik::where('is_delete','N')->orderBy('tahun_akademik', 'DESC')->get();

        $krs_item = (! empty($krs) && $krs->krs_item()->count() > 0) ? $krs->krs_item()->pluck('id_matkul') : [];

        if ($t) {
            if (Auth::guard('mahasiswa')->check()) {
                $auth = Auth::guard('mahasiswa')->user()->nim;
            } else {
                $auth = Auth::guard('wali')->user()->nim;
            }

            $list_jadwal = DB::table('t_jadwal AS j')
                ->select([
                    'h.nama_hari',
                    'j.jam_mulai',
                    'j.jam_selesai',
                    'r.kode_ruang',
                    'k.kode_kelas',
                    'k.nama_kelas',
                    'm.kode_matkul',
                    'm.nama_matkul',
                    'm.sks',
                    'k.id_prodi',
                    'k.kode_kelas',
                    'd.nama',
                    'd.nip'
                ])
                ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
                ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
                ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
                ->leftJoin('m_kelas AS k', 'j.id_kelas', '=', 'k.id_kelas')
                ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
                ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
                ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
                ->rightJoin('m_kelas_detail AS kd', 'k.id_kelas', '=', 'kd.id_kelas')
                ->where([
                    'j.tahun_akademik' => $t,
                    'kd.nim' => $auth,
                    'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah
                ])
                ->whereIn('m.id_matkul', $krs_item)
                ->orderBy('h.id_hari', 'ASC')
                ->orderBy('j.jam_mulai', 'ASC')
                ->groupBy('m.kode_matkul')
                ->groupBy('j.jam_mulai')
                ->get();

            $list_jadwal_remedial = DB::table('m_kelas_detail_remedial AS kd')
                ->select([
                    'h.nama_hari',
                    'j.jam_mulai',
                    'j.jam_selesai',
                    'r.kode_ruang',
                    'k.kode_kelas',
                    'k.nama_kelas',
                    'm.kode_matkul',
                    'm.nama_matkul',
                    'm.sks',
                    'k.id_prodi',
                    'k.kode_kelas',
                    'd.nama',
                    'd.nip'
                ])
                ->leftJoin('m_kelas AS k', 'kd.id_kelas', 'k.id_kelas')
                ->leftJoin('t_jadwal AS j', function ($join) {
                    $join->on('j.id_kelas', 'kd.id_kelas');
                    $join->on('j.id_matkul', 'kd.id_matkul');
                })
                ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
                ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
                ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
                ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
                ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
                ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
                ->where([
                    'j.tahun_akademik' => $t,
                    'kd.nim' => $auth,
                    'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah
                ])
                ->whereIn('kd.id_matkul', $krs_item)
                ->orderBy('h.id_hari', 'ASC')
                ->orderBy('j.jam_mulai', 'ASC')
                ->groupBy('kode_matkul')
                ->get();

            $list_jadwal = array_merge($list_jadwal->toArray(), $list_jadwal_remedial->toArray());
            $list_jadwal = json_decode(json_encode($list_jadwal), FALSE);
        }

        return view('pages/mahasiswa/jadwal/index', compact('krs', 'jadwal', 'no', 'tahun_akademik', 't', 'list_jadwal'));
    }
    
    function khs()
    {
        $akademik = TahunAkademik::pluck('keterangan', 'tahun_akademik');
        $no = 1;
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

        if (empty($jadwal)) {
            return view('pages.mahasiswa.khs.index', compact('akademik', 'no'));
        }
        
        // cpenk edit
/*
        $jadwal_ujian = Jadwal_ujian::leftJoin('t_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik', 't_tahun_akademik.id_tahun_akademik')
            ->where([
                't_tahun_akademik.tahun_akademik' => $tahun_akademik
            ])
            ->orderBy('t_jadwal_ujian.id_jadwal_ujian', 'DESC')
            ->first();

        $tanggal = $jadwal_ujian->jadwal_ujian_detail()->orderBy('t_jadwal_ujian_detail.tanggal', 'DESC')->first()->tanggal;

        if (strtotime(date('Y-m-d H:i:s')) >= strtotime($tanggal)) {
            return redirect()->route('mahasiswa.kuesioner.index');
        }
*/
        return view('pages.mahasiswa.khs.index', compact('akademik', 'no'));
    }
/* KHS lama
    public function print_khs($semester)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if ($semester > $mahasiswa->id_semester) return abort(404);
        
        $kelas = null;

        if ($mahasiswa->id_status != 6) {
            $kelas = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                ->where([
                    'm_kelas.id_semester' => $semester,
                    'm_kelas_detail.nim' => $mahasiswa->nim
                ])
                ->first();
        }

        $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_krs.id_semester' => $semester,
                't_krs.status' => 'Y'
            ])
            ->first();

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
                't_khs.nim' => $mahasiswa->nim
            ])
            ->groupBy('m_matkul.kode_matkul')
            ->get();
            
        if ($mahasiswa->id_status == 6) {
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
                't_krs.nim' => $mahasiswa->nim
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
                
                // $list['huruf'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                // $list['grade'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->huruf;
                // $list['bobot'] = @$this->get_grade_nilai($list->tahun_akademik, $list['total'])->bobot;
            
            $matkul[] = $list;
        }

        $ipk = $this->get_ipk($semester);

        $pdf = PDF::loadView('pages.mahasiswa.khs.print', compact('semester', 'mahasiswa', 'kelas', 'krs', 'matkul', 'ipk'));
        
        return $pdf->stream();
    }
*/

// KHS Cpenk
    function print_khs($semester)
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
        
        $kelas = null;

        if ($mahasiswa->id_status != 6) {
            $kelas = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                ->where([
                    'm_kelas.id_semester' => $semester,
                    'm_kelas_detail.nim' => $mahasiswa->nim
                ])
                ->first();
        }

        $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_krs.id_semester' => $semester,
                't_krs.status' => 'Y'
            ])
            ->first();


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
        
        $count = count($matkul);
        $ipk = $this->get_ipk($semester);
        
        $ipk = $this->get_ipk($semester);

        $pdf = PDF::loadView('pages.mahasiswa.khs.print', compact('semester', 'mahasiswa', 'kelas', 'krs', 'matkul', 'ipk'));
        
        return $pdf->stream();

    //    return view('pages.mahasiswa.khs.getNilai', compact('semester', 'matkul', 'no', 'count', 'ipk'));
    }

    
    public function print($id)
    {
        $tahun_akademik = @$_GET['tahun_akademik'];
        $list_jadwal = array();
        $no = 1;
        $t  = $id;
        
        // $jadwal = KRSItem::join('t_krs', 't_krs.id_krs', '=', 't_krs_item.id_krs')->where('nim', Auth::guard('mahasiswa')->user()->nim)->where('tahun_akademik', $t)->get();
        if (Auth::guard('mahasiswa')->check()) {
            $krs = KRS::where(['tahun_akademik' => $id, 'nim' => Auth::guard('mahasiswa')->user()->nim])->first();
        } elseif (Auth::guard('wali')->check()) {
            $krs = KRS::where(['tahun_akademik' => $id, 'nim' => Auth::guard('wali')->user()->nim])->first();            
        }

        $jadwal = Jadwal::where(['tahun_akademik' => $id, 'id_semester' => ! empty($krs->id_semester) ? $krs->id_semester : '-'])->get();
    
        if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
        
        {  
            $mahasiswa = Mahasiswa::leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                    ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                    // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
                    // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
                    // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
                    ->where('m_mahasiswa.nim', Auth::guard('mahasiswa')->user()->nim)->first();
        }
        else
        {
            $mahasiswa = Mahasiswa::leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                    ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                    ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
                    ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
                    ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
                    ->where([
                        'm_mahasiswa.nim' => Auth::guard('mahasiswa')->user()->nim,
                        'm_kelas.tahun_akademik' => $krs->tahun_akademik
                    ])
                    ->first();
        }
    
        
        $jadwal = Jadwal::where(['tahun_akademik' => $t, 'id_semester' => ! empty($krs->id_semester) ? $krs->id_semester : '-'])->get();
        $tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->get();

        $krs_item = (! empty($krs) && $krs->krs_item()->count() > 0) ? $krs->krs_item()->pluck('id_matkul') : [];

        if ($t) {
            if (Auth::guard('mahasiswa')->check()) {
                $auth = Auth::guard('mahasiswa')->user()->nim;
            } else {
                $auth = Auth::guard('wali')->user()->nim;
            }

            $list_jadwal = DB::table('t_jadwal AS j')
                ->select([
                    'h.nama_hari',
                    'j.jam_mulai',
                    'j.jam_selesai',
                    'r.kode_ruang',
                    'k.kode_kelas',
                    'k.nama_kelas',
                    'm.kode_matkul',
                    'm.nama_matkul',
                    'm.sks',
                    'k.id_prodi',
                    'k.kode_kelas',
                    'd.nama',
                    'd.nip'
                ])
                ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
                ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
                ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
                ->leftJoin('m_kelas AS k', 'j.id_kelas', '=', 'k.id_kelas')
                ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
                ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
                ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
                ->rightJoin('m_kelas_detail AS kd', 'k.id_kelas', '=', 'kd.id_kelas')
                ->where([
                    'j.tahun_akademik' => $t,
                    'kd.nim' => $auth,
                    'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah
                ])
                ->whereIn('m.id_matkul', $krs_item)
                ->orderBy('h.id_hari', 'ASC')
                ->orderBy('j.jam_mulai', 'ASC')
                ->groupBy('m.kode_matkul')
                ->groupBy('j.jam_mulai')
                ->get();

            $list_jadwal_remedial = DB::table('m_kelas_detail_remedial AS kd')
                ->select([
                    'h.nama_hari',
                    'j.jam_mulai',
                    'j.jam_selesai',
                    'r.kode_ruang',
                    'k.kode_kelas',
                    'k.nama_kelas',
                    'm.kode_matkul',
                    'm.nama_matkul',
                    'm.sks',
                    'k.id_prodi',
                    'k.kode_kelas',
                    'd.nama',
                    'd.nip'
                ])
                ->leftJoin('m_kelas AS k', 'kd.id_kelas', 'k.id_kelas')
                ->leftJoin('t_jadwal AS j', function ($join) {
                    $join->on('j.id_kelas', 'kd.id_kelas');
                    $join->on('j.id_matkul', 'kd.id_matkul');
                })
                ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
                ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
                ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
                ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
                ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
                ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
                ->where([
                    'j.tahun_akademik' => $t,
                    'kd.nim' => $auth,
                    'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah
                ])
                ->whereIn('kd.id_matkul', $krs_item)
                ->orderBy('h.id_hari', 'ASC')
                ->orderBy('j.jam_mulai', 'ASC')
                ->groupBy('kode_matkul')
                ->get();

            $list_jadwal = array_merge($list_jadwal->toArray(), $list_jadwal_remedial->toArray());
            $list_jadwal = json_decode(json_encode($list_jadwal), FALSE);
        }

        return view('pages/mahasiswa/jadwal/print', compact('krs', 'jadwal', 'mahasiswa', 'no', 'tahun_akademik', 'list_jadwal'));
    }
    
    public function genpass(Request $req){
        
        $system = new SystemController();
        
        $pass =  $system->encrypt('123', $req->nim, $req->nim);
        
        $update['password'] = $pass;
        $x = Mahasiswa::where("nim", $req->nim)->update($update);
        
        echo "Password reset to 123, encrypt code : ".$pass;
        
    }
}
