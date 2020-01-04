<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use DB;
use Auth;
use Response;

use App\Kelas;
use App\KelasDetail;
use App\KelasDetailRemedial;
use App\Dosen;
use App\Jadwal;
use App\Matkul;
use App\Absensi;
use App\TahunAkademik;
use App\Prodi;
use App\Semester;

class FormPesertaUjianController extends Controller
{
    
   
    
    public function index()
    {

        $semester = Semester::pluck('semester_ke', 'id_semester');

        $dosen = Dosen::select(['id_dosen', DB::raw("CONCAT(nip, ' - ', nama) AS nip_nama")])->pluck('nip_nama', 'id_dosen');

    	$kelas = Kelas::pluck('nama_kelas', 'id_kelas');
    	
    	$matkul = Matkul::where('is_delete', 'N')->pluck('nama_matkul', 'id_matkul');

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        

        return view('pages.admin.form_peserta_ujian.index', compact('semester', 'kelas', 'dosen', 'prodi', 'matkul' ));
    }
    
       public function ajax_sub (Request $request) 
    {
        
        $semester = $request->semester;
        $prodi = $request->prodi;
        $get = Jadwal::select([ 't_jadwal.id_matkul',
                                'm_matkul.nama_matkul',
                                'm_matkul.kode_matkul',
                            ])->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_jadwal.id_matkul')->where('t_jadwal.id_semester', $semester)->where('t_jadwal.id_prodi', $prodi)->get();

        return $get;    
    }

    
    
    public function submit(Request $request) 
    {
        
        $semester = Semester::pluck('semester_ke', 'id_semester');

    	$kelas = Kelas::pluck('nama_kelas', 'id_kelas');
        
        $dosen = Dosen::select(['id_dosen', DB::raw("CONCAT(nip, ' - ', nama) AS nip_nama")])->pluck('nip_nama', 'id_dosen');

    	$matkul = Matkul::where('is_delete', 'N')->pluck('nama_matkul', 'id_matkul');

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        
        $absen = Kelas::leftjoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
                        ->leftjoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
                        ->where('m_kelas.id_prodi', $request->prodi)
                        ->where('m_kelas.id_semester', $request->semester)
                        ->get();

        $list_kelas = Kelas::select([
            'm_kelas.id_kelas',
            'm_kelas.nama_kelas'
        ])
        ->leftJoin('tbl_prodi', 'm_kelas.id_prodi', 'tbl_prodi.id_prodi')
        ->leftJoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
        ->where([
            'm_kelas.id_prodi' => $request->prodi,
            'm_kelas.id_semester' => $request->semester
        ])
        ->get();

        $list = [];

        foreach ($list_kelas as $kelas) {
            // $matkul = DB::table('t_jadwal_ujian_detail_kelas')
            //     ->select([
            //         'm_matkul.id_matkul',
            //         'm_matkul.kode_matkul',
            //         'm_matkul.nama_matkul',
            //         't_jadwal.id_dosen'
            //     ])
            //     ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail')
            //     ->leftJoin('t_jadwal_ujian', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian_detail.id_jadwal_ujian')
            //     ->leftJoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
            //     ->rightJoin('t_jadwal', function ($join) {
            //         $join->on('t_jadwal_ujian_detail_kelas.id_kelas', 't_jadwal.id_kelas');
            //         $join->on('t_jadwal_ujian_detail.id_matkul', 't_jadwal.id_matkul');
            //     })
            //     ->where([
            //         't_jadwal_ujian_detail_kelas.id_kelas' => $kelas->id_kelas,
            //         't_jadwal.id_semester' => $request->semester,
            //         't_jadwal.id_prodi' => $request->prodi
            //     ])
            //     ->groupBy('t_jadwal_ujian_detail.id_matkul')
            //     ->get();
            
            $matkul = Jadwal::select([
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

            if (! empty($matkul) && count($matkul) > 0) {
                $kelas['matkul'] = $matkul;
                $list[] = $kelas;
            }
        }

        $id_matkul = $request->matkul;
        $ju = $request->ju;

        return view('pages.admin.form_peserta_ujian.index', compact('semester', 'kelas', 'dosen', 'prodi', 'absen', 'ju', 'matkul', 'id_matkul', 'list'));
    }

   

    public function print($id, $id_matkul, $ju)
    {
        $jadwal = Jadwal::where([
            't_jadwal.id_kelas' => $id,
            't_jadwal.id_matkul' =>$id_matkul,
        ])
        ->first();
        
            $kelas = Kelas::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_kelas.id_Waktu_kuliah')
                        ->leftjoin('tbl_prodi', 'tbl_prodi.id_prodi', 'm_kelas.id_prodi')
                        ->leftjoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
                        ->findOrFail($id);
       
            $no = 1;
            
            
            $matkul = Matkul::find($id_matkul);

            $dosen = Dosen::find($jadwal->id_dosen);
        
            $list = KelasDetail::select([
                'm_mahasiswa.nim',
                'm_mahasiswa.nama',
                'm_kelas_detail.no_absen'
            ])
            ->join('m_mahasiswa', 'm_mahasiswa.nim', '=', 'm_kelas_detail.nim')
            ->where('id_kelas', $id)
            ->groupBy('m_mahasiswa.nim')
            ->get();

            $count = $list->count() + 1;

            $list_pindahan = KelasDetailRemedial::select([
                'm_mahasiswa.nim',
                'm_mahasiswa.nama'
            ])
            ->join('m_mahasiswa', 'm_mahasiswa.nim', '=', 'm_kelas_detail_remedial.nim')
            ->where([
                'id_kelas' => $id,
                'id_matkul' => $id_matkul
            ])
            ->groupBy('m_mahasiswa.nim')
            ->orderBy('m_mahasiswa.nim', 'ASC')
            ->get();

            foreach ($list_pindahan as $key => $pindahan) {
                $pindahan['no_absen'] = "$count";
                $list_pindahan[$key] = $pindahan;
                $count++;
            }

            $list = array_merge($list->toArray(), $list_pindahan->toArray());

            $list = json_decode(json_encode($list), FALSE);
     
        return view('pages.admin.form_peserta_ujian.print', compact('kelas', 'list', 'no', 'dosen', 'ju', 'matkul'));
    }
}
