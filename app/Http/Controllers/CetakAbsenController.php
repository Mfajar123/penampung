<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\Kelas;
use App\KelasDetail;
use App\Dosen;
use App\Jadwal;
use App\Matkul;
use App\Absensi;
use App\TahunAkademik;
use App\Prodi;
use App\Semester;
use App\Absensi_detail;
use App\Mahasiswa;
use App\Jadwal_ujian;

class CetakAbsenController extends Controller
{
    public function index(Request $request)
    {
        $semester = Semester::pluck('semester_ke', 'id_semester');

        $dosen = Dosen::select(['id_dosen', DB::raw("CONCAT(nip, ' - ', nama) AS nip_nama")])->pluck('nip_nama', 'id_dosen');

    	$kelas = Kelas::pluck('nama_kelas', 'id_kelas');

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        
        $absen = Kelas::leftjoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
                        ->leftjoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
                        ->where('m_kelas.id_prodi', $request->prodi)
                        ->where('m_kelas.id_semester', $request->semester)
                        ->get();
        

        return view('pages.admin.cetak_absen.index', compact('semester', 'dosen', 'kelas', 'prodi', 'absen' ));
    }

    public function submit(Request $request) 
    {
        $semester = Semester::pluck('semester_ke', 'id_semester');

        $dosen = Dosen::select(['id_dosen', DB::raw("CONCAT(nip, ' - ', nama) AS nip_nama")])->pluck('nip_nama', 'id_dosen');

    	$kelas = Kelas::pluck('nama_kelas', 'id_kelas');
    	
    	$matkul = Matkul::where('is_delete', 'N')->pluck('nama_matkul', 'id_matkul');

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        
        $absen = Kelas::leftjoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
                        ->leftjoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
                        ->where('m_kelas.id_prodi', $request->prodi)
                        ->where('m_kelas.id_semester', $request->semester)
                        ->get();

        $list_kelas = Kelas::select([
            'm_kelas.id_kelas',
            'm_kelas.nama_kelas',
        ])
        ->leftJoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
        ->leftJoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
        ->where([
            'm_kelas.id_prodi' => $request->prodi,
            'm_kelas.id_semester' => $request->semester
        ])
        ->get();

        $list = [];

        foreach ($list_kelas as $kelas)
        {
            $kelas['matkul'] = Jadwal::select([
                    'm_matkul.id_matkul',
                    'm_matkul.kode_matkul',
                    'm_matkul.nama_matkul',
                    't_jadwal.id_dosen'
                ])
                ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
                ->where([
                    't_jadwal.id_prodi' => $request->prodi,
                    't_jadwal.id_semester' => $request->semester,
                    't_jadwal.id_kelas' => $kelas->id_kelas
                ])
                ->groupBy('t_jadwal.id_matkul')
                ->get();
            
            if (count($kelas['matkul']) > 0) $list[] = $kelas;
        }

        $id_matkul = $request->matkul;
        $ju = $request->ju;

        return view('pages.admin.cetak_absen.index', compact('semester', 'list', 'dosen', 'kelas', 'prodi', 'absen', 'ju', 'matkul', 'id_matkul'));
    }

    


    public function print($id, $id_matkul, $semester)
    {
        $jadwal = Jadwal::where([
            't_jadwal.id_kelas' => $id,
            't_jadwal.id_matkul' =>$id_matkul,
            't_jadwal.id_semester' => $semester
        ])
        ->first();

        $kelas = Kelas::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_kelas.id_Waktu_kuliah')
                        ->leftjoin('tbl_prodi', 'tbl_prodi.id_prodi', 'm_kelas.id_prodi')
                        ->leftjoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
                        ->findOrFail($id);

        $dosen = Dosen::find($jadwal->id_dosen);

        $matkul = Matkul::find($id_matkul);
       
        $no = 1;
        
        //  $list = KelasDetail::select([
        //         'm_mahasiswa.nim',
        //         'm_mahasiswa.nama'
        //     ])
        //     ->join('m_mahasiswa', 'm_mahasiswa.nim', '=', 'm_kelas_detail.nim')
        //     ->where('id_kelas', $id)
        //     ->groupBy('m_mahasiswa.nim')
        //     ->get();

        // $kelas = Kelas::findOrFail($id);

        $list_kelas_detail = $kelas->kelas_detail()
            ->select([
                'm_kelas_detail.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_krs', function ($join) {
                $join->on('t_krs.tahun_akademik', 'm_kelas.tahun_akademik');
                $join->on('t_krs.nim', 'm_kelas_detail.nim');
                $join->on('t_krs.id_semester', 'm_kelas.id_semester');
            })
            ->rightJoin('t_krs_item', 't_krs.id_krs', 't_krs_item.id_krs')
            ->groupBy('m_kelas_detail.nim')
            ->orderBy('m_mahasiswa.nim', 'ASC')
            ->get();
            
        $list_kelas_detail_remedial = $kelas->kelas_detail_remedial()
            ->select([
                'm_kelas_detail_remedial.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail_remedial.nim', '=', 'm_mahasiswa.nim')
            ->where([
                'm_kelas_detail_remedial.id_matkul' => $id_matkul
            ])
            ->groupBy('m_kelas_detail_remedial.nim')
            ->orderBy('m_kelas_detail_remedial.nim', 'asc')
            ->get();
        
        // $list_kelas_detail = $list_kelas_detail->merge($list_kelas_detail_remedial);
        
        $list = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $list = json_decode(json_encode($list), FALSE);

     
        return view('pages.admin.cetak_absen.print', compact('kelas', 'list', 'dosen', 'matkul', 'no'));
    }

    public function rekap_absen($id, $id_matkul, $id_semester, $id_dosen = null)
    {
        if (empty($id_dosen)) {
            $dosen = Auth::guard('dosen')->user();
        } else {
            $dosen = Dosen::findOrFail($id_dosen);
        }

        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $absensi_detail = Absensi_detail::select([
                't_absensi_detail.catatan_dosen'
            ])
            ->where([
                't_absensi_detail.id_matkul' => $id_matkul,
                't_absensi_detail.id_kelas' => $id
            ])
            ->orderBy('t_absensi_detail.id_absensi_detail')
            ->get();

        $list_keterangan = array(
            'Hadir' => 'fa-check',
            'Alpha' => 'fa-remove'
        );

        $list_kehadiran = array();

        $tahun_akademik = DB::select(DB::raw("
            select keterangan from t_tahun_akademik
            where tahun_akademik = '".$kelas->tahun_akademik."'
        "))[0]->keterangan;

        $list_kelas_detail = $kelas->kelas_detail()
            ->select([
                'm_kelas_detail.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_krs', function ($join) {
                $join->on('t_krs.tahun_akademik', 'm_kelas.tahun_akademik');
                $join->on('t_krs.nim', 'm_kelas_detail.nim');
                $join->on('t_krs.id_semester', 'm_kelas.id_semester');
            })
            ->rightJoin('t_krs_item', 't_krs.id_krs', 't_krs_item.id_krs')
            ->where([
                't_krs_item.id_matkul' => $id_matkul
            ])
            ->groupBy('m_kelas_detail.nim')
            ->orderBy('m_mahasiswa.nim', 'ASC')
            ->get();
        
        $list_kelas_detail_remedial = $kelas->kelas_detail_remedial()
            ->select([
                'm_kelas_detail_remedial.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail_remedial.nim', '=', 'm_mahasiswa.nim')
            ->where([
                'm_kelas_detail_remedial.id_matkul' => $id_matkul
            ])
            ->groupBy('m_kelas_detail_remedial.nim')
            ->orderBy('m_kelas_detail_remedial.nim', 'asc')
            ->get();
                
        $list_kelas_detail = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $list_kelas_detail = json_decode(json_encode($list_kelas_detail), FALSE);
        
        foreach ($list_kelas_detail as $kelas_detail)
        {
            $kehadiran = Absensi::select([
                't_absensi.id_absensi',
                't_absensi.keterangan',
                't_absensi.notes',
                't_absensi.tanggal',
                't_absensi.pertemuan_ke'
            ])
            ->where([
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id,
                't_absensi.nim' => $kelas_detail->nim
            ])
            ->orderBy('t_absensi.tanggal', 'ASC')
            ->get();

            $list_temp = array();
            $kelas_detail->{'jumlah'} = 0;

            $pertemuan_ke = 1;

            foreach ($kehadiran as $list)
            {
                $list->keterangan = $list_keterangan[$list->keterangan];
                $list['pertemuan_ke'] = $list->pertemuan_ke;

                $list_temp[$list->tanggal.'.'.$list->pertemuan_ke] = $list;
            }

            $kelas_detail->{'kehadiran'} = $list_temp;

            $pertemuan_ke = 1;

            foreach ($list_temp as $list)
            {
                if ($list->keterangan == 'fa-check') $kelas_detail->{'jumlah'} += 1;
            }

            $kelas_detail->{'kehadiran'} = $list_temp;

            $list_kehadiran[] = $kelas_detail;
        }

        $pertemuan = Absensi::select([
                't_absensi.tanggal',
                't_absensi.pertemuan_ke'
            ])->where([
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id
            ])
            ->groupBy('t_absensi.pertemuan_ke')
            ->groupBy('t_absensi.tanggal')
            ->orderBy('t_absensi.tanggal', 'ASC')
            ->get();

        $list_pertemuan = [];

        foreach ($pertemuan as $key => $val)
        {
            $list_pertemuan[$val->tanggal.'.'.$val->pertemuan_ke] = 'Pertemuan ke-'.($key + 1).' ('.date('d m Y', strtotime($val->tanggal)).')';
        }

        return view('pages.dosen.absensi.rekap', compact('matkul', 'kelas', 'dosen', 'tahun_akademik', 'list_kehadiran', 'pertemuan'));
    }

    protected function kehadiran(Request $request)
    {
        $semester = Semester::pluck('semester_ke', 'id_semester');

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');

        $list = [];

        if (isset($request)) {
            $list_kelas = Kelas::select([
                'm_kelas.id_kelas',
                'm_kelas.nama_kelas',
            ])
            ->leftJoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
            ->leftJoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->where([
                'm_kelas.id_prodi' => $request->prodi,
                'm_kelas.id_semester' => $request->semester
            ])
            ->get();
    
            foreach ($list_kelas as $kelas)
            {
                $kelas['matkul'] = Jadwal::select([
                        'm_matkul.id_matkul',
                        'm_matkul.kode_matkul',
                        'm_matkul.nama_matkul',
                        't_jadwal.id_dosen'
                    ])
                    ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
                    ->where([
                        't_jadwal.id_prodi' => $request->prodi,
                        't_jadwal.id_semester' => $request->semester,
                        't_jadwal.id_kelas' => $kelas->id_kelas
                    ])
                    ->groupBy('t_jadwal.id_matkul')
                    ->get();
                
                if (count($kelas['matkul']) > 0) $list[] = $kelas;
            }
        }

        return view('pages.admin.cetak_absen.kehadiran', compact('semester', 'prodi', 'list'));
    }

    protected function detail($id, $id_matkul, $semester)
    {
        $jadwal = Jadwal::where([
                't_jadwal.id_kelas' => $id,
                't_jadwal.id_matkul' =>$id_matkul,
                't_jadwal.id_semester' => $semester
            ])
            ->first();

        $kelas = Kelas::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_kelas.id_Waktu_kuliah')
            ->leftjoin('tbl_prodi', 'tbl_prodi.id_prodi', 'm_kelas.id_prodi')
            ->leftjoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->findOrFail($id);

        $dosen = Dosen::find($jadwal->id_dosen);

        $matkul = Matkul::find($id_matkul);

        $list = [];

        $list_kelas_detail = $kelas->kelas_detail()
            ->select([
                'm_kelas_detail.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_krs', function ($join) {
                $join->on('t_krs.tahun_akademik', 'm_kelas.tahun_akademik');
                $join->on('t_krs.nim', 'm_kelas_detail.nim');
                $join->on('t_krs.id_semester', 'm_kelas.id_semester');
            })
            ->rightJoin('t_krs_item', 't_krs.id_krs', 't_krs_item.id_krs')
            ->groupBy('m_kelas_detail.nim')
            ->orderBy('m_mahasiswa.nim', 'ASC')
            ->get();
            
        $list_kelas_detail_remedial = $kelas->kelas_detail_remedial()
            ->select([
                'm_kelas_detail_remedial.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail_remedial.nim', '=', 'm_mahasiswa.nim')
            ->where([
                'm_kelas_detail_remedial.id_matkul' => $id_matkul
            ])
            ->groupBy('m_kelas_detail_remedial.nim')
            ->orderBy('m_kelas_detail_remedial.nim', 'asc')
            ->get();
        
        $list = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $list = json_decode(json_encode($list), FALSE);

        $list_temp = [];

        foreach ($list as $mahasiswa) {
            $jumlah_kehadiran = Absensi::where([
                    'id_matkul' => $id_matkul,
                    'id_kelas' => $id,
                    'nim' => $mahasiswa->nim,
                    'keterangan' => 'Hadir'
                ])
                ->count();
            
            $mahasiswa->jumlah_kehadiran = $jumlah_kehadiran;

            $list_temp[] = $mahasiswa;
        }

        $list = json_decode(json_encode($list_temp), FALSE);
        
        return view('pages.admin.cetak_absen.kehadiran_detail', compact('jadwal', 'kelas', 'dosen', 'matkul', 'list'));
    }

    public function getDateLastJadwalUjian($tahun_akademik, $jenis_ujian)
    {
        $jadwal_ujian = Jadwal_ujian::select([
                't_jadwal_ujian_detail.tanggal'
            ])
            ->where([
                't_tahun_akademik.tahun_akademik' => $tahun_akademik,
                't_jadwal_ujian.jenis_ujian' => $jenis_ujian
            ])
            ->leftJoin('t_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik', 't_tahun_akademik.id_tahun_akademik')
            ->rightJoin('t_jadwal_ujian_detail', 't_jadwal_ujian.id_jadwal_ujian', 't_jadwal_ujian_detail.id_jadwal_ujian')
            ->orderBy('t_jadwal_ujian_detail.tanggal', 'DESC')
            ->first();

        return $jadwal_ujian;
    }

    protected function alpha(Request $request)
    {
        $id_semester = $request->id_semester;
        $id_prodi = $request->id_prodi;
        $tahun_akademik = $request->tahun_akademik;

        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        $mahasiswa = [];
        $list_absensi = [];

        if (! empty($id_semester) && ! empty($id_prodi) && ! empty($tahun_akademik)) {
            $mahasiswa = Mahasiswa::pluck('nama', 'nim');
            $tanggal_terakhir_uts = $this->getDateLastJadwalUjian($tahun_akademik, 'uts')->tanggal;

            $list_absensi = Absensi::select([
                    't_absensi.nim',
                    'm_kelas.id_semester',
                    'm_kelas.kode_kelas',
                    'm_kelas.id_prodi',
                    'm_matkul.kode_matkul',
                    'm_matkul.nama_matkul',
                    DB::raw("COUNT(CASE WHEN t_absensi.keterangan = 'Hadir' THEN 1 ELSE NULL END) as kehadiran")
                ])
                ->leftJoin('m_kelas', 't_absensi.id_kelas', 'm_kelas.id_kelas')
                ->join('m_matkul', 't_absensi.id_matkul', 'm_matkul.id_matkul')
                ->where([
                    'm_kelas.id_semester' => $id_semester,
                    'm_kelas.id_prodi' => $id_prodi,
                    'm_kelas.tahun_akademik' => $tahun_akademik
                ])
                ->having('kehadiran', '<', 4);

            if (! empty($tanggal_terakhir_uts)) $list_absensi->where('t_absensi.tanggal', '>', $tanggal_terakhir_uts);

            $list_absensi = $list_absensi->groupBy('t_absensi.nim')
                ->groupBy('t_absensi.id_matkul')
                ->get();
        }

        return view('pages.admin.cetak_absen.alpha', compact('list_tahun_akademik', 'list_semester', 'list_prodi', 'mahasiswa', 'list_absensi'));
    }
}
