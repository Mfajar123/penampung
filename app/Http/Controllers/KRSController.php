<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\OptionsController;

use File;
use Auth;
use Session;
use DB;
use DataTables;

use App\KRS;
use App\KRSItem;
use App\Semester;
use App\Mahasiswa;
use App\Matkul;
use App\Pembukaan_krs;
use App\TahunAkademik;
use App\Jadwal;
use App\Kelas;
use App\WaktuKuliah;
use App\KelasDetail;
use App\Batas_pembayaran;
use App\Pembayaran_spp;
use App\KHS;

class KRSController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
        $this->options = new OptionsController();
    }

    public function upload_file(Request $request)
    {
        $file = $request->file('file_surat');
        $ext = $file->getClientOriginalExtension();

        if ($file->isValid())
        {
            $file_name = date('YmdHis').'.'.$ext;
            $upload_path = 'files/surat';
            $file->move($upload_path, $file_name);

            return $file_name;
        }

        return false;
    }

	public function pembukaan_krs()
    {
        return Pembukaan_krs::where([
                ['id_prodi', '=', Auth::guard('mahasiswa')->user()->id_prodi],
                ['tanggal_mulai', '<=', date('Y-m-d')],
                ['tanggal_selesai', '>=', date('Y-m-d')]
            ])
            ->first();
    }
    
    public function batas_pembayaran_krs($tahun_akademik)
    {
        $tahun = substr($tahun_akademik, 0, 4);

        $batas_pembayaran_krs = Batas_pembayaran::where([
                'jenis_pembayaran' => 'KRS',
                'semester' => substr($tahun_akademik, -2) == '10' ? 'Ganjil' : 'Genap'
            ])
            ->first();
        
        $batas_pembayaran_krs_genap = Batas_pembayaran::where([
                'jenis_pembayaran' => 'KRS',
                'semester' => 'Genap'
            ])
            ->first();
        
        if ($batas_pembayaran_krs->bulan <= $batas_pembayaran_krs_genap->bulan)
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
            't_pembayaran_spp.bulan' => $batas_pembayaran_krs->bulan
        ])
        ->having('tahun', $tahun)
        ->orderBy('tahun', 'ASC')
        ->orderBy('t_pembayaran_spp.bulan', 'ASC')
        ->first();

        return (object) array(
            'pembayaran_spp' => $pembayaran_spp,
            'batas_pembayaran_krs' => $batas_pembayaran_krs
        );
    }
    

    public function index()
    {
	    $pembukaan_krs = $this->pembukaan_krs();

        // $ulang_ = KRS::where('nim', Auth::guard('mahasiswa')->user()->nim)
        //     ->where('ulang', 'Y')->count();
        $max_thn = KRS::where(['t_krs.nim' => Auth::guard('mahasiswa')->user()->nim])->max('id_krs');

        $ulang = KRS::where([
                't_krs.id_krs' => $max_thn,
            ])
        	->whereNull('t_krs.ulang')->count();

        $thn_skdmk = Auth::guard('mahasiswa')->user()->tahun_akademik;

        $list_tahun_akademik = TahunAkademik::where([
            ['tahun_akademik', '>=', Auth::guard('mahasiswa')->user()->tahun_akademik]
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('keterangan', 'tahun_akademik');

        $tahun_akademik = DB::table('t_tahun_akademik')
                ->where('t_tahun_akademik.tahun_akademik', Auth::guard('mahasiswa')->user()->tahun_akademik)
                ->first();
        
        if ($tahun_akademik->semester == 'Ganjil') {
            $list_bulan = array(
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
                1 => 'Januari'
            );
        } else {
            $list_bulan = array(
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
            );
        }

        $count_pembayaran = 0;

        foreach ($list_bulan as $key => $val)
        {
            $count_pembayaran += 1;

            if ($key == date('m'))
            {
                break;
            }
        }

        $pembayaran_spp = DB::table('t_pembayaran_spp')
            ->where([
                'nim' => Auth::guard('mahasiswa')->user()->nim,
                'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik
            ])
            ->whereIn('bulan', array_keys($list_bulan))
            ->count();

        $sudah_bayar = ($count_pembayaran == $pembayaran_spp);

    	return view('pages.mahasiswa.krs.index', compact('ulang', 'list_tahun_akademik', 'pembukaan_krs', 'thn_skdmk'));
    }

    public function ulang()
    {
	    $pembukaan_krs = $this->pembukaan_krs();

        // $ulang_ = KRS::where('nim', Auth::guard('mahasiswa')->user()->nim)
        //     ->where('ulang', 'Y')->count();
        $max_thn = KRS::where(['t_krs.nim' => Auth::guard('mahasiswa')->user()->nim])->max('id_krs');

        $ulang = KRS::where([
                't_krs.id_krs' => $max_thn,
            ])
        	->whereNull('t_krs.ulang')->count();

        $thn_akad_diambil = KRS::where([
                't_krs.id_krs' => $max_thn,
            ])
        	->whereNull('t_krs.ulang')->first();

        $ulang_diambil = DB::table("t_ulang_mk")->where('id_krs', $max_thn)->sum('sks');
        $tot_sks_ulang = $ulang_diambil;

        $total_sks_ = $thn_akad_diambil->total_sks;

        $semester_ = DB::table('t_tahun_akademik')
        				->where('tahun_akademik', $thn_akad_diambil->tahun_akademik)
        				->first();

        $ulang_mk = DB::select("select t_tahun_akademik.semester,
								`t_khs`.`id_prodi`, `t_khs`.`id_semester`, `t_khs`.`id_kelas`, `t_khs`.`kode_matkul`, 
								`t_khs`.`tahun_akademik`, `t_khs`.`nim`, `m_matkul`.`id_matkul`, `m_matkul`.`nama_matkul`, 
								`m_matkul`.`sks`, `t_khs`.`hadir`, `t_khs`.`tugas`, `t_khs`.`uts`, `t_khs`.`uas`, `t_khs`.`total`, 
								`m_grade_nilai`.`huruf`, `m_grade_nilai`.`bobot`, t_ulang_mk.sks AS sks_ulang, t_ulang_mk.id_ulang_mk
								from `t_khs` 
								left join `m_matkul` on `t_khs`.`kode_matkul` = `m_matkul`.`kode_matkul` 
								left join t_tahun_akademik on t_khs.tahun_akademik = t_tahun_akademik.tahun_akademik
                                left join t_ulang_mk on `m_matkul`.`id_matkul` = t_ulang_mk.id_matkul
								left join `m_grade_nilai` on `t_khs`.`tahun_akademik` = m_grade_nilai.tahun_akademik AND t_khs.total >= m_grade_nilai.nilai_min AND t_khs.total <= m_grade_nilai.nilai_max 
								where (t_tahun_akademik.semester = '".$semester_->semester."' and `t_khs`.`nim` = ".Auth::guard('mahasiswa')->user()->nim." and `m_grade_nilai`.`huruf` in ('C','D','E')) 
								group by `m_matkul`.`kode_matkul`");

        $thn_skdmk = Auth::guard('mahasiswa')->user()->tahun_akademik;

        $list_tahun_akademik = TahunAkademik::where([
            ['tahun_akademik', '>=', Auth::guard('mahasiswa')->user()->tahun_akademik]
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('keterangan', 'tahun_akademik');

        $tahun_akademik = DB::table('t_tahun_akademik')
                ->where('t_tahun_akademik.tahun_akademik', Auth::guard('mahasiswa')->user()->tahun_akademik)
                ->first();
        
        if ($tahun_akademik->semester == 'Ganjil') {
            $list_bulan = array(
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
                1 => 'Januari'
            );
        } else {
            $list_bulan = array(
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
            );
        }

        $count_pembayaran = 0;

        foreach ($list_bulan as $key => $val)
        {
            $count_pembayaran += 1;

            if ($key == date('m'))
            {
                break;
            }
        }

        $pembayaran_spp = DB::table('t_pembayaran_spp')
            ->where([
                'nim' => Auth::guard('mahasiswa')->user()->nim,
                'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik
            ])
            ->whereIn('bulan', array_keys($list_bulan))
            ->count();

        $sudah_bayar = ($count_pembayaran == $pembayaran_spp);

    	return view('pages.mahasiswa.krs.ulang', compact('ulang', 'list_tahun_akademik', 'pembukaan_krs', 'thn_skdmk', 'ulang_mk', 'total_sks_', 'tot_sks_ulang', 'max_thn'));
    }

    public function tambah(Request $request)
    {
	    if (empty($this->pembukaan_krs())) abort(404);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        $list_tahun_akademik = TahunAkademik::where([
            ['tahun_akademik', '>=', $mahasiswa->tahun_akademik]
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('keterangan', 'tahun_akademik');
        
        $list_waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');
        
        $list_matkul = Matkul::select([
            'id_matkul',
            DB::raw("CONCAT(kode_matkul, ' - ', nama_matkul) AS kode_nama")
        ])
        ->pluck('kode_nama', 'id_matkul');
        
        return view('pages.mahasiswa.krs.tambah', compact('mahasiswa', 'list_tahun_akademik', 'list_waktu_kuliah', 'list_matkul'));
    }

    public function edit($id)
    {
        if (empty($this->pembukaan_krs())) abort(404);

        $krs = KRS::findOrFail($id);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($krs->nim !== $mahasiswa->nim || $krs->status !== 'N') abort(404);

        $list_tahun_akademik = TahunAkademik::where([
            ['tahun_akademik', '>=', $mahasiswa->tahun_akademik]
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('keterangan', 'tahun_akademik');
        
        $list_waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        $list_matkul = Matkul::select([
            'id_matkul',
            DB::raw("CONCAT(kode_matkul, ' - ', nama_matkul) AS kode_nama")
        ])
        ->pluck('kode_nama', 'id_matkul');

        return view('pages.mahasiswa.krs.edit', compact('krs', 'mahasiswa', 'list_tahun_akademik', 'list_waktu_kuliah', 'list_matkul'));
    }
    
    public function get_krs(Request $request)
    {
        $tahun_akademik = $request->tahun_akademik;
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $data = array();
        $no = 1;

        $krs = KRS::select([
            't_krs.id_krs',
            't_krs.status',
            't_krs.total_sks',
            't_krs.keterangan',
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            'm_matkul.sks',
        ])
        ->rightJoin('t_krs_item', 't_krs.id_krs', '=', 't_krs_item.id_krs')
        ->leftJoin('m_matkul', 't_krs_item.id_matkul', '=', 'm_matkul.id_matkul')
        ->where([
            't_krs.nim' => $mahasiswa->nim,
            't_krs.tahun_akademik' => $tahun_akademik,
        ])
        ->groupBy('t_krs_item.id_matkul')
        ->get();

        if (! empty($krs->first()))
        {
            $data['id_krs'] = $krs->first()->id_krs;
            $data['status'] = $krs->first()->status;
            $data['total_sks'] = $krs->first()->total_sks;
            $data['keterangan'] = $krs->first()->keterangan;

            foreach ($krs as $list)
            {
                $list['no'] = $no++;
                
                $data['krs_item'][] = $list;
            }

            return response()->json(['status' => 'success', 'data' => $data]);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada krs.']);
        }
    }

    function get_matkul(Request $request)
    {
        $tahun_akademik = $request->tahun_akademik;
        $id_waktu_kuliah = $request->id_waktu_kuliah;
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($mahasiswa->id_status == 6) return response()->json(['status' => 'success', 'id_status' => 6, 'jadwal' => []], 200);

        $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_krs.tahun_akademik' => $tahun_akademik
            ]);

        if ($request->from == 'edit') $krs = $krs->where('t_krs.status', 'Y');

        $krs = $krs->count();

        if ($krs > 0)
        {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah mengisi KRS untuk tahun akademik ini.'], 200);
        }
        else
        {
            $semester_ke = $mahasiswa->id_semester;

            if (empty($semester_ke))
            {
                $semester_ke = 1;
            }
            else
            {
                $batas_pembayaran_krs = $this->batas_pembayaran_krs($tahun_akademik);

                if (empty($batas_pembayaran_krs->pembayaran_spp))
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda belum membayar SPP sampai Bulan ' . $this->options->list_bulan()[$batas_pembayaran_krs->batas_pembayaran_krs->bulan]
                    ]);
                }
                
                $semester_ke += 1;
            }

            $jadwal = Jadwal::select([
                    't_jadwal.id_jadwal',
                    'm_matkul.id_matkul',
                    'm_matkul.kode_matkul',
                    'm_matkul.nama_matkul',
                    'm_matkul.sks'
                ])
                ->leftJoin('m_matkul', 't_jadwal.id_matkul', '=', 'm_matkul.id_matkul')
                ->where([
                    't_jadwal.tahun_akademik' => $tahun_akademik,
                    't_jadwal.id_prodi' => $mahasiswa->id_prodi,
                    't_jadwal.id_waktu_kuliah' => $id_waktu_kuliah,
                    't_jadwal.id_semester' => $semester_ke,
                    't_jadwal.is_delete' => 'N'
                ])
                ->groupBy('m_matkul.id_matkul')
                ->get();
            
            return response()->json(['status' => 'success', 'jadwal' => $jadwal, 'semester' => $semester_ke], 200);
        }
    }

    public function get_jadwal(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $jadwal = Jadwal::select([
                't_jadwal.id_jadwal',
                't_jadwal.hari',
                't_jadwal.jam_mulai',
                't_jadwal.jam_selesai'
            ])
            ->leftJoin('m_hari', 't_jadwal.hari', 'm_hari.nama_hari')
            ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
            ->where([
                't_jadwal.id_waktu_kuliah' => $request->id_waktu_kuliah,
                't_jadwal.id_prodi' => $mahasiswa->id_prodi,
            ])
            ->orderBy('m_hari.id_hari', 'ASC')
            ->orderBy('t_jadwal.jam_mulai', 'ASC')
            ->orderBy('m_kelas.kode_kelas', 'ASC');
        
        if ($request->id_matkul)
        {
            $jadwal = $jadwal->where('t_jadwal.id_matkul', $request->id_matkul);

            if (empty($request->hari))
            {
                $jadwal = $jadwal->groupBy('t_jadwal.hari');
            }
            else
            {
                $jadwal = $jadwal->where([
                    't_jadwal.hari' => $request->hari
                ])
                ->groupBy('t_jadwal.jam_mulai');
            }
        }
        
        $jadwal = $jadwal->get();

        return response()->json(['status' => 'success', 'jadwal' => $jadwal, 'id_status' => $mahasiswa->id_status], 200);
    }

    public function simpan(Request $request)
    {
        $file_surat = null;

	    if (empty($this->pembukaan_krs())) abort(404);

        if (empty($request->id_matkul))
        {
            Session::flash('flash_message', 'Anda belum mengambil Mata Kuliah.');

            return redirect()->back();
        }
        else if ($request->id_waktu_kuliah == 4 && !$request->hasFile('file_surat'))
        {
            Session::flash('flash_message', 'Anda harus mengupload surat shift.');

            return redirect()->back();
        }
        else
        {
            $mahasiswa = Auth::guard('mahasiswa')->user();

            $semester_ke = $mahasiswa->id_semester;

            if (empty($semester_ke))
            {
                $semester_ke = 1;
            }
            else
            {
                $semester_ke += 1;
            }

            if ($request->hasFile('file_surat'))
            {
                $file_surat = $this->upload_file($request);
            }

            $krs = KRS::create([
                'nim' => $mahasiswa->nim,
                'tahun_akademik' => $request->tahun_akademik,
                'id_semester' => $semester_ke,
                'id_waktu_kuliah' => $request->id_waktu_kuliah,
                'total_sks' => $request->total_sks,
                'file_surat' => $file_surat,
                'is_delete' => 'N'
            ]);
    
            $data_krs_item = array();

            if ($mahasiswa->id_status != 6)
            {
                foreach ($request->id_matkul as $matkul)
                {
                    $data_krs_item[] = [
                        'id_krs' => $krs->id_krs,
                        'id_matkul' => $matkul
                    //    'id_kelas'=>$jadwal->id_kelas
                    ];
                }
            }
            else
            {
                foreach ($request->id_matkul as $key => $matkul)
                {
                    // return [
                    //     't_jadwal.tahun_akademik' => $krs->tahun_akademik,
                    //     't_jadwal.id_waktu_kuliah' => $krs->id_waktu_kuliah,
                    //     't_jadwal.id_prodi' => $mahasiswa->id_prodi,
                    //     't_jadwal.id_matkul' => $matkul,
                    //     't_jadwal.hari' => $request->hari[$key],
                    //     't_jadwal.jam_mulai' => explode('-', $request->jam[$key])[0],
                    //     't_jadwal.jam_selesai' => explode('-', $request->jam[$key])[1]
                    // ];

                    $jadwal = Jadwal::where([
                            't_jadwal.tahun_akademik' => $krs->tahun_akademik,
                            't_jadwal.id_waktu_kuliah' => $krs->id_waktu_kuliah,
                            't_jadwal.id_prodi' => $mahasiswa->id_prodi,
                            't_jadwal.id_matkul' => $matkul,
                            't_jadwal.hari' => $request->hari[$key],
                            't_jadwal.jam_mulai' => explode('-', $request->jam[$key])[0],
                            't_jadwal.jam_selesai' => explode('-', $request->jam[$key])[1]
                        ])
                        ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
                        ->orderBy('m_kelas.kode_kelas', 'DESC')
                        ->first();

                    $data_krs_item[] = [
                        'id_krs' => $krs->id_krs,
                        'id_matkul' => $matkul,
                        'id_kelas' => $jadwal->id_kelas
                    ];
                }
            }
    
            $krs_item = KRSItem::insert($data_krs_item);

            Session::flash('flash_message', 'KRS berhasil disimpan.');

            return redirect()->route('mahasiswa.krs');
        }
    }

    public function perbarui($id, Request $request)
    {
        if (empty($this->pembukaan_krs())) abort(404);

        $krs = KRS::findOrFail($id);
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($krs->nim !== $mahasiswa->nim) abort(404);

        if (empty($request->id_matkul))
        {
            Session::flash('flash_message', 'Anda belum mengambil Mata Kuliah.');

            return redirect()->back();
        }
        else if ($request->id_waktu_kuliah == 4 && !$request->hasFile('file_surat'))
        {
            Session::flash('flash_message', 'Anda harus mengupload surat shift.');

            return redirect()->back();
        }
        else
        {
            $input = [
                'status' => null
            ];

            if ($request->hasFile('file_surat'))
            {
                $input['file_surat'] = $this->upload_file($request);
            }

            $krs->update($input);

            $krs->krs_item()->delete();
    
            $data_krs_item = array();
            
            if ($mahasiswa->id_status != 6)
            {
                foreach ($request->id_matkul as $matkul)
                {
                    $data_krs_item[] = [
                        'id_krs' => $krs->id_krs,
                        'id_matkul' => $matkul
                    ];
                }
            }
            else
            {
                foreach ($request->id_matkul as $key => $matkul)
                {
                    $jadwal = Jadwal::where([
                        't_jadwal.tahun_akademik' => $krs->tahun_akademik,
                        't_jadwal.id_waktu_kuliah' => $krs->id_waktu_kuliah,
                        't_jadwal.id_prodi' => $mahasiswa->id_prodi,
                        'id_matkul' => $matkul,
                        'hari' => $request->hari[$key],
                        'jam_mulai' => explode('-', $request->jam[$key])[0],
                        'jam_selesai' => explode('-', $request->jam[$key])[1]
                    ])
                    ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
                    ->orderBy('m_kelas.kode_kelas', 'ASC')
                    ->first();

                    $data_krs_item[] = [
                        'id_krs' => $krs->id_krs,
                        'id_matkul' => $matkul,
                        'id_kelas' => $jadwal->id_kelas
                    ];
                }
            }
    
            $krs_item = KRSItem::insert($data_krs_item);

            Session::flash('success', 'KRS berhasil diperbarui.');

            return redirect()->route('mahasiswa.krs');
        }
    }

    public function get_matkul_pindahan(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tahun_akademik = $request->tahun_akademik;
        $id_waktu_kuliah = $request->id_waktu_kuliah;

        $jadwal = Jadwal::select([
                'm_matkul.id_matkul',
                DB::raw("CONCAT(m_matkul.kode_matkul, ' - ', m_matkul.nama_matkul) AS kode_nama")
            ])
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
            ->where([
                't_jadwal.tahun_akademik' => $request->tahun_akademik,
                't_jadwal.id_prodi' => $mahasiswa->id_prodi
            ])
            ->groupBy('t_jadwal.id_matkul')
            ->get();

        return response()->json(['status' => 'success', 'jadwal' => $jadwal], 200);
    }

    public function ulang_mk($id_matkul)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $jadwal = Jadwal::select([DB::raw("CONCAT(t_jadwal.hari, ' ', ' ', t_jadwal.jam_mulai, ' - ', t_jadwal.jam_selesai, ' ', tbl_prodi.id_prodi, ' ', m_kelas.kode_kelas) AS keterangan", "id_jadwal AS tahun_akademik"), 'id_jadwal AS tahun_akademik'])
            ->leftJoin('m_hari', 't_jadwal.hari', 'm_hari.nama_hari')
            ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('tbl_prodi', 't_jadwal.id_prodi', 'tbl_prodi.id_prodi')
            ->where([
                't_jadwal.id_matkul' => $id_matkul,
                't_jadwal.id_prodi' => $mahasiswa->id_prodi,
            ])
            ->orderBy('m_hari.id_hari', 'ASC')
            ->orderBy('t_jadwal.jam_mulai', 'ASC')
            ->orderBy('m_kelas.kode_kelas', 'ASC')
            ->pluck('keterangan', 'tahun_akademik');
        $matkul = Matkul::where('id_matkul', $id_matkul)->first();
        $nama_matkul = $matkul->nama_matkul;
        $id_matkul = $matkul->id_matkul;

        return view('pages.mahasiswa.krs._form_ulang', compact('jadwal', 'nama_matkul', 'id_matkul'));
    }

    public function add_ulang_mk(Request $request)
    {
        $get_krs_id = KRS::where(['t_krs.nim' => Auth::guard('mahasiswa')->user()->nim])->max('id_krs');
        $matkul = Matkul::where('id_matkul', $request->id_matkul)->first();


            //         $data_krs_item[] = [
            //             'id_krs' => $krs->id_krs,
            //             'id_matkul' => $matkul,
            //             'id_kelas' => $jadwal->id_kelas
            //         ];

            // $krs_item = KRSItem::insert($data_krs_item);
        
        DB::table('t_ulang_mk')->insert(
            [
             'nim' => Auth::guard('mahasiswa')->user()->nim,
             'id_krs' => $get_krs_id,
             'id_matkul' => $request->id_matkul,
             'sks' => $matkul->sks,
             'id_jadwal' => $request->jadwal,
            ]

        );
        
        // $matkul = $request->id_matkul;

        // echo $request->id_matkul;

            Session::flash('flash_message', 'Berhasil Menambah Mata Kuliah Mengulang');

            return redirect()->route('mahasiswa.krs.ulang');
    }

    public function batal_ulang($id_ulang_mk)
    {
        DB::table('t_ulang_mk')->where('id_ulang_mk', $id_ulang_mk)->delete();
        Session::flash('flash_message', 'Berhasil Melakukan Pembatalan');
        return redirect()->route('mahasiswa.krs.ulang');
    }

    public function ajukan($id_krs)
    {
        // $krs = KRS::find($id_krs);
        // DB::table('t_ulang_mk')->where('id_ulang_mk', $id_ulang_mk)->delete();
        // $krs->update(['ulang_' => 'Y']);
        DB::table('t_krs')
            ->where('id_krs', $id_krs)
            ->update(['ulang' => 'Y']);
        // DB::update('t_krs')->where('id_ulang_mk', $id_ulang_mk)->delete();
        Session::flash('flash_message', 'Berhasil Menyimpan Pengulangan Mata Kuliah');
        return redirect()->route('mahasiswa.krs');
    }

    public function print($id_krs)
    {
        $krs = KRS::findOrFail($id_krs);
        $krs_item = $krs->krs_item()->get();
        $total_sks = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->sum('sks');

        if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
        {  
            $mahasiswa = Mahasiswa::leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                ->where('m_mahasiswa.nim', Auth::guard('mahasiswa')->user()->nim)->first();
        }
        else
        {
            $mahasiswa = Mahasiswa::select('*', 'm_mahasiswa.nama AS nama_mhs', 'm_dosen.nama AS nama_dosen')
                // ->select('m_dosen.nama_ AS nama_dosen')
                ->leftJoin('tbl_mahasiswa_status', 'm_mahasiswa.id_status', '=', 'tbl_mahasiswa_status.id_status')
                ->leftjoin('m_dosen', 'm_mahasiswa.nip', 'm_dosen.nip' )
                ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
                ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
                ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
                ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
                ->where([
                    'm_mahasiswa.nim' => Auth::guard('mahasiswa')->user()->nim,
                    'm_kelas.tahun_akademik' => $krs->tahun_akademik,
                ])
                ->first();
        }

        return view('pages.mahasiswa.krs.print', compact('mahasiswa', 'krs', 'krs_item', 'total_sks'));
    }

	public function update_profile(Request $request)
    {
        $input = $request->all();
        $input['is_updated_information'] = 'T';

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $mahasiswa->update($input);

        return redirect()->back();
    }
}
