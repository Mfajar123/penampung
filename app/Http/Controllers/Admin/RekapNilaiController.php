<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Matkul;
use App\Dosen;
use App\TahunAkademik;
use App\Semester;
use App\KHS;
use App\Jadwal;
use App\Prodi;
use App\Grade_nilai;
use App\Persentase_nilai;

class RekapNilaiController extends Controller
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
        $data = [];

        $list_matkul = Matkul::select('id_matkul', DB::raw("CONCAT(kode_matkul, ' - ', nama_matkul) AS kode_nama"))->pluck('kode_nama', 'id_matkul');
        $list_dosen = Dosen::select('id_dosen', DB::raw("CONCAT(nip, ' - ', nama) AS nip_nama"))->pluck('nip_nama', 'id_dosen');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        $list_jadwal = Jadwal::select([
                't_jadwal.id_jadwal',
                't_jadwal.tahun_akademik',
                't_jadwal.id_prodi',
                't_jadwal.id_semester',
                't_jadwal.id_kelas',
                't_jadwal.id_dosen',
                't_jadwal.id_matkul',
                't_tahun_akademik.keterangan',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_dosen.nip',
                'm_dosen.nama',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_kelas.nama_kelas'
            ])
            ->leftJoin('t_tahun_akademik', 't_jadwal.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->leftJoin('m_dosen', 't_jadwal.id_dosen', 'm_dosen.id_dosen')
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas');

        // if ($request->id_matkul) $list_jadwal->where('t_jadwal.id_matkul', $request->id_matkul);
        // if ($request->id_dosen) $list_jadwal->where('t_jadwal.id_dosen', $request->id_dosen);
        if ($request->tahun_akademik) $list_jadwal->where('t_jadwal.tahun_akademik', $request->tahun_akademik);
        if ($request->id_semester) $list_jadwal->where('t_jadwal.id_semester', $request->id_semester);
        if ($request->id_prodi) $list_jadwal->where('t_jadwal.id_prodi', $request->id_prodi);

        $list_jadwal = $list_jadwal->get();

        foreach ($list_jadwal as $list) {
            $nilai = KHS::where([
                    't_khs.tahun_akademik' => $list->tahun_akademik,
                    't_khs.kode_matkul' => $list->kode_matkul,
                    't_khs.id_prodi' => $list->id_prodi,
                    't_khs.id_semester' => $list->id_semester,
                    't_khs.id_kelas' => $list->id_kelas
                ])
                ->get();

            $list['status'] = count($nilai) == 0 ? 'WAITING' : 'DONE';
            
            $data[] = $list;
        }

        return view('pages.admin.rekap_nilai.index', compact('list_matkul', 'list_dosen', 'list_semester', 'list_tahun_akademik', 'list_prodi', 'data'));
    }

    public function print(Request $request)
    {
        $dosen = Dosen::findOrFail($request->id_dosen);
        
        $persentase_nilai = Persentase_nilai::where([
                'id_dosen' => $request->id_dosen
            ])
            ->first();

        $jumlah_pertemuan = DB::table('t_absensi')
            ->where([
                'id_kelas' => $request->id_kelas,
                'id_matkul' => $request->id_matkul
            ])
            ->groupBy('tanggal')
            ->groupBy('pertemuan_ke')
            ->get();
        
        $jumlah_pertemuan = count($jumlah_pertemuan);
        
        $jadwal = Jadwal::select([
                't_jadwal.id_jadwal',
                't_jadwal.tahun_akademik',
                't_jadwal.id_semester',
                't_jadwal.id_kelas',
                't_jadwal.id_matkul',
                't_tahun_akademik.keterangan',
                'm_dosen.gelar_depan',
                'm_dosen.gelar_belakang',
                'm_dosen.nip',
                'm_dosen.nama',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_kelas.nama_kelas',
                'tbl_prodi.id_prodi',
                'tbl_prodi.nama_prodi',
                'tbl_waktu_kuliah.nama_waktu_kuliah',
            ])
            ->leftJoin('t_tahun_akademik', 't_jadwal.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->leftJoin('m_dosen', 't_jadwal.id_dosen', 'm_dosen.id_dosen')
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('tbl_prodi', 't_jadwal.id_prodi', 'tbl_prodi.id_prodi')
            ->leftJoin('tbl_waktu_kuliah', 't_jadwal.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->where([
                't_jadwal.id_matkul' => $request->id_matkul,
                't_jadwal.id_dosen' => $request->id_dosen,
                't_jadwal.tahun_akademik' => $request->tahun_akademik,
                't_jadwal.id_semester' => $request->id_semester,
                't_jadwal.id_kelas' => $request->id_kelas
            ])
            ->first();

        $list_kelas_detail = $jadwal->kelas
            ->kelas_detail()
            ->select([
                'm_kelas_detail.nim',
                'm_mahasiswa.nama',
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', 'm_mahasiswa.nim')
            ->orderBy('m_kelas_detail.nim', 'ASC')
            ->get();

        $list_kelas_detail_remedial = $jadwal->kelas
            ->kelas_detail_remedial()
            ->select([
                'm_kelas_detail_remedial.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail_remedial.nim', '=', 'm_mahasiswa.nim')
            ->where([
                'm_kelas_detail_remedial.id_matkul' => $request->id_matkul
            ])
            ->groupBy('m_kelas_detail_remedial.nim')
            ->orderBy('m_kelas_detail_remedial.nim', 'asc')
            ->get();

        $kelas_detail = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $kelas_detail = json_decode(json_encode($kelas_detail), FALSE);
        
        $list_nilai = [];
        
        foreach ($kelas_detail as $kelas) {
            $hadir = 0;
            $jumlah_hadir = 0;

            $khs = KHS::where([
                    't_khs.nim' => $kelas->nim,
                    't_khs.tahun_akademik' => $jadwal->tahun_akademik,
                    't_khs.kode_matkul' => $jadwal->kode_matkul,
                    't_khs.id_prodi' => $jadwal->id_prodi,
                    't_khs.id_semester' => $jadwal->id_semester,
                    't_khs.id_kelas' => $jadwal->id_kelas
                ])
                ->leftJoin('m_mahasiswa', 't_khs.nim', 'm_mahasiswa.nim')
                ->first();

            $kehadiran = DB::table('t_absensi')
                ->select('t_absensi.pertemuan_ke')
                ->leftJoin('t_jadwal', 't_absensi.id_jadwal', 't_jadwal.id_jadwal')
                ->where([
                    't_absensi.nim' => $kelas->nim,
                    't_absensi.id_matkul' => $jadwal->id_matkul,
                    't_absensi.id_kelas' => $jadwal->id_kelas,
                    't_absensi.keterangan' => 'Hadir',
                    // 't_jadwal.tahun_akademik' => $jadwal->tahun_akademik
                ])
                ->groupBy('t_absensi.tanggal')
                ->groupBy('t_absensi.pertemuan_ke')
                ->get();

            if (count($kehadiran) > 0) {
                $hadir = number_format(100 / ($jumlah_pertemuan / count($kehadiran)), 0);
                $jumlah_hadir = count($kehadiran);
            } else {
                $hadir = 0;
                $jumlah_hadir = 0;
            }

            if (! empty($khs)) {
                $khs['total'] = 0;

                $khs['hadir'] = $hadir;
                $khs['jumlah_hadir'] = $jumlah_hadir;

                $khs['total'] += (empty($khs['hadir']) ? 0 : (empty($persentase_nilai->kehadiran) ? 0 : $persentase_nilai->kehadiran) / 100) * $khs['hadir'];
                $khs['total'] += (empty($khs['tugas']) ? 0 : (empty($persentase_nilai->tugas) ? 0 : $persentase_nilai->tugas) / 100) * $khs['tugas'];
                $khs['total'] += (empty($khs['uts']) ? 0 : (empty($persentase_nilai->uts) ? 0 : $persentase_nilai->uts) / 100) * $khs['uts'];
                $khs['total'] += (empty($khs['uas']) ? 0 : (empty($persentase_nilai->uas) ? 0 : $persentase_nilai->uas) / 100) * $khs['uas'];
                
                $khs['huruf'] = @$this->get_grade_nilai($request->tahun_akademik, $khs['total'])->huruf;
                $khs['grade'] = @$this->get_grade_nilai($request->tahun_akademik, $khs['total'])->huruf;
                $khs['bobot'] = @$this->get_grade_nilai($request->tahun_akademik, $khs['total'])->bobot;
            } else {
                $khs['nim'] = $kelas->nim;
                $khs['nama'] = $kelas->nama;
                
                $khs['hadir'] = $hadir;
                $khs['jumlah_hadir'] = $jumlah_hadir;
                $khs['tugas'] = 0;
                $khs['uts'] = 0;
                $khs['uas'] = 0;
                
                $khs['total'] = 0;
                $khs['huruf'] = '-';
                $khs['grade'] = '-';
                $khs['bobot'] = 0;
            }

            $list_nilai[] = $khs;
        }

        return view('pages.admin.rekap_nilai.print', compact('dosen', 'jadwal', 'list_nilai'));
    }
}
