<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\OptionsController;

use DB;
use Auth;

use App\Batas_pembayaran;
use App\Pembayaran_spp;
use App\TahunAkademik;
use App\Jadwal_ujian;
use App\KelasDetail;
use App\KelasDetailRemedial;

class CetakJadwalUjianController extends Controller
{
    protected $options;

    public function __construct()
    {
        return $this->options = new OptionsController();
    }

    public function batas_pembayaran_ujian($tahun_akademik, $jenis_ujian)
    {
        $tahun = substr($tahun_akademik, 0, 4);
        
        $batas_pembayaran_ujian = Batas_pembayaran::where([
            'jenis_pembayaran' => 'Ujian',
            'semester' => substr($tahun_akademik, -2) == '10' ? 'Ganjil' : 'Genap',
            'jenis_ujian' => $jenis_ujian
        ])
        ->first();

        $batas_pembayaran_ujian_genap = Batas_pembayaran::where([
            'jenis_pembayaran' => 'Ujian',
            'semester' => 'Genap',
            'jenis_ujian' => $jenis_ujian
        ])
        ->first();

        if ($batas_pembayaran_ujian->bulan <= $batas_pembayaran_ujian_genap->bulan)
        {
            $tahun = substr($tahun_akademik, 0, 4) + 1;
        }

        $pembayaran_spp = Pembayaran_spp::select([
            't_pembayaran_spp.bulan',
            DB::raw('IF(RIGHT(t_tahun_akademik.tahun_akademik, 2) = "10", IF(t_pembayaran_spp.bulan = 1, LEFT(t_tahun_akademik.tahun_akademik, 4) + 1, LEFT(t_tahun_akademik.tahun_akademik, 4)), LEFT(t_tahun_akademik.tahun_akademik, 4) + 1) AS tahun')
        ])
        ->leftJoin('t_tahun_akademik', 't_pembayaran_spp.id_tahun_akademik', '=', 't_tahun_akademik.id_tahun_akademik')
        ->where([
            't_pembayaran_spp.nim' => Auth::guard('mahasiswa')->user()->nim,
            't_pembayaran_spp.bulan' => $batas_pembayaran_ujian->bulan
        ])
        ->having('tahun', $tahun)
        ->orderBy('tahun', 'ASC')
        ->orderBy('t_pembayaran_spp.bulan', 'ASC')
        ->first();

        return (object) array(
            'pembayaran_spp' => $pembayaran_spp,
            'batas_pembayaran_ujian' => $batas_pembayaran_ujian
        );
    }

    public function index(Request $request)
    {
        $list_tahun_akademik = TahunAkademik::where([
            ['tahun_akademik', '>=', Auth::guard('mahasiswa')->user()->tahun_akademik]
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('keterangan', 'tahun_akademik');

        $list_jenis_ujian = array(
            'UTS' => 'UTS',
            'UAS' => 'UAS'
        );

        $cetak_jadwal_ujian = array();

        if ($request->tahun_akademik && $request->jenis_ujian)
        {
            $tahun_akademik = TahunAkademik::where('tahun_akademik', $request->tahun_akademik)->first();
            $jenis_ujian = strtolower($request->jenis_ujian);
            
            $batas_pembayaran_ujian = $this->batas_pembayaran_ujian($request->tahun_akademik, $request->jenis_ujian);
            
            if (empty($batas_pembayaran_ujian->pembayaran_spp))
            {
                $cetak_jadwal_ujian = [
                    'status' => 'error',
                    'message' => 'Anda belum membayar SPP sampai Bulan ' . $this->options->list_bulan()[$batas_pembayaran_ujian->batas_pembayaran_ujian->bulan]
                ];
            }
            else
            {
                $user = Auth::guard('mahasiswa')->user();

                if ($user->id_status != 6) {
                    $kelas_detail = KelasDetail::select([
                        'm_kelas_detail.id_kelas'
                    ])
                    ->leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->where([
                        'm_kelas_detail.nim' => $user->nim,
                        'm_kelas.tahun_akademik' => $request->tahun_akademik,
                        'm_kelas.id_prodi' => $user->id_prodi,
                    ])
                    ->pluck('m_kelas_detail.id_kelas', 'm_kelas_detail.id_kelas');
    
                    // $kelas_detail = array_merge($kelas_detail->toArray(), $kelas_detail_remedial->toArray());
                    // $kelas_detail = json_decode(json_encode($kelas_detail), FALSE);
    
                    $jadwal_ujian = Jadwal_ujian::select([
                        'm_matkul.kode_matkul',
                        'm_matkul.nama_matkul',
                        'm_kelas.kode_kelas',
                        't_jadwal_ujian_detail.tanggal',
                        't_jadwal_ujian_detail.jam_mulai',
                        't_jadwal_ujian_detail.jam_selesai',
                        'm_ruang.kode_ruang',
                        'm_ruang.nama_ruang'
                    ])
                    ->rightJoin('t_jadwal_ujian_detail', 't_jadwal_ujian.id_jadwal_ujian', 't_jadwal_ujian_detail.id_jadwal_ujian')
                    ->rightJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail')
                    ->leftJoin('m_ruang', 't_jadwal_ujian_detail.id_ruang', 'm_ruang.id_ruang')
                    ->leftJoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
                    ->leftJoin('m_kelas', 't_jadwal_ujian_detail_kelas.id_kelas', 'm_kelas.id_kelas')
                    ->where([
                        'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik,
                        'jenis_ujian' => strtolower($request->jenis_ujian)
                    ])
                    ->whereIn('t_jadwal_ujian_detail_kelas.id_kelas', $kelas_detail)
                    // ->groupBy('t_jadwal_ujian_detail.id_matkul')
                    ->orderBy('t_jadwal_ujian_detail.tanggal', 'ASC')
                    ->orderBy('t_jadwal_ujian_detail.jam_mulai', 'ASC')
                    ->get();
                } else {
                    $kelas_detail_remedial = KelasDetailRemedial::select([
                        'm_kelas_detail_remedial.id_kelas',
                        'm_kelas_detail_remedial.id_matkul'
                    ])
                    ->leftJoin('m_kelas', 'm_kelas_detail_remedial.id_kelas', 'm_kelas.id_kelas')
                    ->where([
                        'm_kelas_detail_remedial.nim' => $user->nim,
                        'm_kelas.tahun_akademik' => $request->tahun_akademik,
                        'm_kelas.id_prodi' => $user->id_prodi,
                    ])
                    ->get();

                    $jadwal_ujian = [];
                    
                    foreach ($kelas_detail_remedial as $key => $val) {
                        $jadwal = Jadwal_ujian::select([
                                'm_matkul.kode_matkul',
                                'm_matkul.nama_matkul',
                                'm_kelas.kode_kelas',
                                't_jadwal_ujian_detail.tanggal',
                                't_jadwal_ujian_detail.jam_mulai',
                                't_jadwal_ujian_detail.jam_selesai',
                                'm_ruang.kode_ruang',
                                'm_ruang.nama_ruang'
                            ])
                            ->rightJoin('t_jadwal_ujian_detail', 't_jadwal_ujian.id_jadwal_ujian', 't_jadwal_ujian_detail.id_jadwal_ujian')
                            ->rightJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail')
                            ->leftJoin('m_ruang', 't_jadwal_ujian_detail.id_ruang', 'm_ruang.id_ruang')
                            ->leftJoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
                            ->leftJoin('m_kelas', 't_jadwal_ujian_detail_kelas.id_kelas', 'm_kelas.id_kelas')
                            ->where([
                                'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik,
                                'jenis_ujian' => strtolower($request->jenis_ujian),
                                't_jadwal_ujian_detail_kelas.id_kelas' => $val->id_kelas,
                                't_jadwal_ujian_detail.id_matkul' => $val->id_matkul
                            ])
                            ->first();
                        
                        if (! empty($jadwal)) $jadwal_ujian[] = $jadwal;
                    }
                    
                    usort($jadwal_ujian, function ($a, $b) {
                        return $a['tanggal'] <=> $b['tanggal'];
                    });
                }
                
                $list_hari = [
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jum`at',
                    6 => 'Sabtu',
                    7 => 'Minggu'
                ];
                
                $cetak_jadwal_ujian = [
                    'status' => 'success',
                    'jadwal_ujian' => $jadwal_ujian,
                    'list_hari' => $list_hari
                ];
            }
        }

        return view('pages.mahasiswa.cetak_jadwal_ujian.index', compact('list_tahun_akademik', 'list_jenis_ujian', 'cetak_jadwal_ujian'));
    }
}
