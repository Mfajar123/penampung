<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Excel;
use Session;
use DataTables;

use App\TahunAkademik;
use App\Ruang;
use App\KRS;
use App\Matkul;
use App\Batas_pembayaran;
use App\Pembayaran_spp;
use App\Mahasiswa;
use App\Kelas;
use App\KelasDetail;
use App\Jadwal_ujian;
use App\Jadwal_ujian_detail;
use App\Jadwal_ujian_detail_kelas;

use App\Imports\ExcelImport;

class JadwalUjianController extends Controller
{
    private $data_jadwal_ujian_detail;
    private $data_jadwal_ujian_detail_kelas;
    private $tanggal_ujian;
    private $list_matkul;
    private $list_ruang;
    private $list_kelas;
    private $id_jadwal_ujian_detail;
    private $id_jadwal_ujian;

    public function datatables()
    {
        $data = array();
        $arr_jenis_ujian = [
            'uts' => 'Ujian Tengah Semester (UTS)',
            'uas' => 'Ujian Akhir Semester (UAS)',
            'remedial' => 'Remedial'
        ];
        $no = 1;

        $jadwal_ujian = Jadwal_ujian::orderBy('t_jadwal_ujian.id_jadwal_ujian', 'DESC')->get();

        foreach ($jadwal_ujian as $list) {
            $data[] = [
                'no' => $no,
                'id_jadwal_ujian' => $list->id_jadwal_ujian,
                'tahun_akademik' => $list->tahun_akademik->keterangan,
                'jenis_ujian' =>$arr_jenis_ujian[$list->jenis_ujian],
                'aksi' => "
                    <a href='".route('jadwal_ujian.detail', [$list->tahun_akademik->tahun_akademik, $list->jenis_ujian, 'pagi'])."' target='_blank' class='btn btn-info btn-sm'><i class='fa fa-eye'></i> Jadwal Pagi</a>
                    <a href='".route('jadwal_ujian.detail', [$list->tahun_akademik->tahun_akademik, $list->jenis_ujian, 'malam'])."' target='_blank' class='btn btn-info btn-sm'><i class='fa fa-eye'></i> Jadwal Malam</a>
                    <a href='".route('admin.jadwal_ujian.edit', $list->id_jadwal_ujian)."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> Edit</a>
                    <a href='".route('admin.jadwal_ujian.destroy', $list->id_jadwal_ujian)."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> Hapus</a>
                "
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.admin.jadwal_ujian.index');
    }

    public function buat()
    {
        $list_tahun_akademik = TahunAkademik::select('id_tahun_akademik', 'keterangan')->orderBy('keterangan', 'DESC')->pluck('keterangan', 'id_tahun_akademik');
        $list_ruang = Ruang::select('id_ruang', 'kode_ruang')->pluck('kode_ruang', 'id_ruang');
        $list_matkul = Matkul::select('id_matkul', DB::raw("CONCAT(kode_matkul, ' - ', nama_matkul, ' ( ', sks, ' sks )') AS kode_nama"))->pluck('kode_nama', 'id_matkul');
        $list_kelas = Kelas::select('id_kelas', DB::raw("CONCAT(id_prodi, kode_kelas) AS prodi_kode"))->pluck('prodi_kode', 'id_kelas');

        return view('pages.admin.jadwal_ujian.buat', compact('list_tahun_akademik', 'list_ruang', 'list_matkul', 'list_kelas'));
    }

    public function simpan(Request $request)
    {
        $tahun_akademik = TahunAkademik::findOrFail($request->id_tahun_akademik);

        $data_jadwal_ujian = [
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'jenis_ujian' => $request->jenis_ujian
        ];
        
        $jadwal_ujian = Jadwal_ujian::create($data_jadwal_ujian);

        if (! empty($request->tanggal)) {
            foreach ($request->tanggal as $key => $val) {
                for ($i = 0; $i < count($val['jam_mulai']); $i++) {
                    $data_jadwal_ujian_detail = [
                        'id_jadwal_ujian' => $jadwal_ujian->id_jadwal_ujian,
                        'tanggal' => $key,
                        'jam_mulai' => $val['jam_mulai'][$i],
                        'jam_selesai' => $val['jam_selesai'][$i],
                        'id_ruang' => $val['id_ruang'][$i],
                        'id_matkul' => $val['id_matkul'][$i]
                    ];
    
                    $jadwal_ujian_detail = Jadwal_ujian_detail::create($data_jadwal_ujian_detail);
    
                    $data_kelas = [];
    
                    $new_kelas = [];
    
                    $no_kelas = 0;
    
                    foreach ($val['kelas'] as $kelas) {
                        $new_kelas[$no_kelas] = $kelas;
                        $no_kelas++;
                    }
    
                    foreach ($new_kelas[$i] as $kelas) {
                        $data_kelas[] = [
                            'id_jadwal_ujian_detail' => $jadwal_ujian_detail->id_jadwal_ujian_detail,
                            'id_kelas' => $kelas
                        ];
                    }
    
                    $jadwal_ujian_detail_kelas = Jadwal_ujian_detail_kelas::insert($data_kelas);
                }
            }
        } else {
            if ($request->hasFile('file_excel')) {
                Excel::import(new ExcelImport($jadwal_ujian->id_jadwal_ujian, $tahun_akademik->tahun_akademik), $request->file('file_excel')); //IMPORT FILE 
            }

        }

        Session::flash('flash_message', 'Jadwal Ujian berhasil disimpan.');

        return json_encode(array('status' => 'success'));
    }

    public function edit($id)
    {
        $jadwal_ujian = Jadwal_ujian::findOrFail($id);
        $jadwal_ujian_detail = Jadwal_ujian_detail::select('tanggal')
            ->where('id_jadwal_ujian', '=', $id)
            ->groupBy('tanggal')
            ->get();

        $list_tahun_akademik = TahunAkademik::select('id_tahun_akademik', 'keterangan')->orderBy('keterangan', 'DESC')->pluck('keterangan', 'id_tahun_akademik');
        $list_ruang = Ruang::select('id_ruang', 'kode_ruang')->pluck('kode_ruang', 'id_ruang');
        $list_matkul = Matkul::select('id_matkul', DB::raw("CONCAT(kode_matkul, ' - ', nama_matkul, ' ( ', sks, ' sks )') AS kode_nama"))->pluck('kode_nama', 'id_matkul');
        $list_kelas = Kelas::select('id_kelas', DB::raw("CONCAT(id_prodi, kode_kelas) AS prodi_kode"))->pluck('prodi_kode', 'id_kelas');

        return view('pages.admin.jadwal_ujian.edit', compact('jadwal_ujian', 'jadwal_ujian_detail', 'list_tahun_akademik', 'list_ruang', 'list_matkul', 'list_kelas'));
    }

    public function update($id, Request $request)
    {
        $tahun_akademik = TahunAkademik::findOrFail($request->id_tahun_akademik);

        $data_jadwal_ujian = [
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'jenis_ujian' => $request->jenis_ujian
        ];
        
        $jadwal_ujian = Jadwal_ujian::find($id);
        $jadwal_ujian->update($data_jadwal_ujian);

        foreach ($jadwal_ujian->jadwal_ujian_detail as $jadwal_ujian_detail) {
            $delete_jadwal_ujian_detail_kelas = Jadwal_ujian_detail_kelas::where('id_jadwal_ujian_detail', $jadwal_ujian_detail->id_jadwal_ujian_detail)->delete();
        }

        $delete_jadwal_ujian_detail = Jadwal_ujian_detail::where('id_jadwal_ujian', $id)->delete();

        $data_kelas = [];

        if (! empty($request->tanggal)) {
            foreach ($request->tanggal as $key => $val) {
                for ($i = 0; $i < count($val['jam_mulai']); $i++) {
                    $data_jadwal_ujian_detail = [
                        'id_jadwal_ujian' => $jadwal_ujian->id_jadwal_ujian,
                        'tanggal' => $key,
                        'jam_mulai' => $val['jam_mulai'][$i],
                        'jam_selesai' => $val['jam_selesai'][$i],
                        'id_ruang' => $val['id_ruang'][$i],
                        'id_matkul' => $val['id_matkul'][$i]
                    ];
    
                    $jadwal_ujian_detail = Jadwal_ujian_detail::create($data_jadwal_ujian_detail);
    
                    $new_kelas = [];
    
                    $no_kelas = 0;
    
                    foreach ($val['kelas'] as $kelas) {
                        $new_kelas[$no_kelas] = $kelas;
                        $no_kelas++;
                    }
    
                    if (! empty($new_kelas[$i])) {
                        foreach ($new_kelas[$i] as $kelas) {
                            $data_kelas[] = [
                                'id_jadwal_ujian_detail' => $jadwal_ujian_detail->id_jadwal_ujian_detail,
                                'id_kelas' => $kelas
                            ];
                        }
                    }
    
                    $jadwal_ujian_detail_kelas = Jadwal_ujian_detail_kelas::insert($data_kelas);
                }
            }
        } else {
            if ($request->hasFile('file_excel')) {
                $this->id_jadwal_ujian = $id;
                $this->data_import = [];
                $this->list_matkul = Matkul::pluck('id_matkul', 'kode_matkul');
                $list_ruang = Ruang::pluck('id_ruang', 'kode_ruang');
                $this->list_kelas = Kelas::select('id_kelas', DB::raw("CONCAT(id_prodi, kode_kelas) AS prodi_kode"))
                    ->where('tahun_akademik', $tahun_akademik->tahun_akademik)
                    ->pluck('id_kelas', 'prodi_kode');
    
                foreach ($list_ruang as $key => $val) {
                    if (is_numeric($key)) $key = intval($key);
                    $this->list_ruang[$key] = $val;
                }
    
                $this->id_jadwal_ujian_detail = Jadwal_ujian_detail::orderBy('id_jadwal_ujian_detail', 'DESC')->first();
    
                if (empty($this->id_jadwal_ujian_detail)) {
                    $this->id_jadwal_ujian_detail = 1;
                } else {
                    $this->id_jadwal_ujian_detail = $this->id_jadwal_ujian_detail->id_jadwal_ujian_detail + 1;
                }
    
    
                Excel::selectSheetsByIndex(0)->load($request->file('file_excel'), function($reader)
                {
                    $results = $reader->noHeading()->toArray();
    
                    foreach ($results as $row)
                    {
                        if (! empty($row[0])) {
                            if (!empty($row[0]) && empty($row[1])) {
                                $this->tanggal_ujian = $row[0];
                            } else {
                                $jam = str_replace('WIB', '', $row[0]);
    
                                foreach (explode('/', $row[5]) as $kelas) {
                                    $this->data_jadwal_ujian_detail_kelas[] = [
                                        'id_jadwal_ujian_detail' => $this->id_jadwal_ujian_detail,
                                        'id_kelas' => $this->list_kelas[trim($kelas)]
                                    ];
                                }
    
                                $this->data_jadwal_ujian_detail[] = [
                                    'id_jadwal_ujian_detail' => $this->id_jadwal_ujian_detail++,
                                    'id_jadwal_ujian' => $this->id_jadwal_ujian,
                                    'tanggal' => date('Y-m-d', strtotime($this->tanggal_ujian)),
                                    'jam_mulai' => str_replace('.', ':', trim(explode('-', $jam)[0])),
                                    'jam_selesai' => str_replace('.', ':', trim(explode('-', $jam)[1])),
                                    'id_ruang' => $this->list_ruang[$row[1]],
                                    'id_matkul' => $this->list_matkul[$row[2]]
                                ];
                            }
                        }
                    }
    
                }, 'UTF-8');

                Jadwal_ujian_detail::insert($this->data_jadwal_ujian_detail);
                Jadwal_ujian_detail_kelas::insert($this->data_jadwal_ujian_detail_kelas);
            }
        }

        Session::flash('flash_message', 'Jadwal Ujian berhasil diperbarui.');

        return json_encode(array('status' => 'success', 'data_kelas' => $data_kelas));
    }

    public function destroy($id)
    {
        $jadwal_ujian = Jadwal_ujian::find($id);
        $jadwal_ujian->delete();

        foreach ($jadwal_ujian->jadwal_ujian_detail as $jadwal_ujian_detail) {
            $delete_jadwal_ujian_detail_kelas = Jadwal_ujian_detail_kelas::where('id_jadwal_ujian_detail', $jadwal_ujian_detail->id_jadwal_ujian_detail)->delete();
        }

        $delete_jadwal_ujian_detail = Jadwal_ujian_detail::where('id_jadwal_ujian', $id)->delete();

        Session::flash('flash_message', 'Jadwal Ujian berhasil dihapus.');

        return redirect()->route('admin.jadwal_ujian');
    }
    
    public function cetak(Request $request)
    {
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik' , 'DESC')->pluck('keterangan', 'id_tahun_akademik');

        $rta    = @$request->tahun_akademik;
        $ju  = @$request->ujian; 
        
        $ta = TahunAkademik::find($rta);
        
        foreach( @$batas  = Batas_pembayaran::where('jenis_ujian', @$ju)
                                    ->where('semester', $ta->semester ) 
                                    ->get() as $bts );
        $bulan = @$bts->bulan;
        
        foreach( @$list_spp    = Pembayaran_spp::where('nim', Auth::guard('mahasiswa')->user()->nim)
                                ->where('id_tahun_akademik', $rta)
                                ->where('bulan', $bulan)
                                ->get() as $spp );
        $spp_terbayar = @$spp->bulan;
        

    if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
    
    {
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }else{
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }
            
        $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta,
                't_krs.status' => 'Y'
            ])
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->first();
        
        if (!empty($krs)) {
            $krs_item = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->groupBy('t_krs_item.id_matkul')->get();
        } else {
            $krs_item = [];
        }
        
        
        $ujian = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
                            ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
                            ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
                            ->where('jenis_ujian', $ju)
                            ->first();

        // $jadwal = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              
        //                     ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
        //                     ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
        //                     ->leftJoin('m_kelas', 't_jadwal_ujian_detail_kelas.id_kelas', 'm_kelas.id_kelas')
        //                     ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', 'm_kelas_detail.id_kelas')
        //                     ->leftjoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
        //                     ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
        //                     ->where('jenis_ujian', $ju)
        //                     ->where('t_jadwal_ujian_detail_kelas.id_kelas', $mahasiswa->id_kelas)
        //                     ->groupBy('t_jadwal_ujian_detail.id_matkul')
        //                     ->get();
        
        $m_kelas = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->where([
                'm_kelas_detail.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta
            ])
            ->first();
        

        return view('pages.mahasiswa.cetak.cetak',compact('mahasiswa', 'bulan', 'spp_terbayar', 'list_tahun_akademik', 'ujian', 'krs_item', 'm_kelas' ));
    }

    public function cetak_uts_front($id, $id_ta)
    {

        $rta    = @$id_ta;
        $ju     = @$id;   
        
    if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
    
    {
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }else{
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }    


        $ujian = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              
                            ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
                            ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
                            ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
                            ->where('jenis_ujian', $ju)
                            ->first();
                            
        $m_kelas = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->where([
                'm_kelas_detail.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta
            ])
            ->first();


        return view('pages.mahasiswa.cetak.uts_front', compact('mahasiswa', 'ujian', 'jadwal', 'm_kelas'));
    }

     public function cetak_uts_back($id, $id_ta)
    {

        $rta    = @$id_ta;
        $ju     = @$id;     
        
        
        
        
    if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
    
    {
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }else{
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }    


        $ujian = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
                            ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
                            ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
                            ->where('jenis_ujian', $ju)
                            ->first();
                            
         $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta,
                't_krs.status' => 'Y'
            ])
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->first();
            
        $krs_item = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->groupBy('t_krs_item.id_matkul')->get();
        
        // $jadwal = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              
        //                     ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
        //                     ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
        //                     ->leftJoin('m_kelas', 't_jadwal_ujian_detail_kelas.id_kelas', 'm_kelas.id_kelas')
        //                     ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', 'm_kelas_detail.id_kelas')
        //                     ->leftjoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
        //                     ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
        //                     ->where('jenis_ujian', $ju)
        //                     ->where('t_jadwal_ujian_detail_kelas.id_kelas', $mahasiswa->id_kelas)
        //                     ->groupBy('t_jadwal_ujian_detail.id_matkul')
        //                     ->get();


        return view('pages.mahasiswa.cetak.uts_back', compact('mahasiswa',  'ujian', 'jadwal', 'krs_item'));
    }


    public function cetak_uas_front($id, $id_ta)
    {

        $rta    = @$id_ta;
        $ju     = @$id; 
        
    if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
    
    {
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }else{
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }    


        $ujian = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
                            ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
                            ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
                            ->where('jenis_ujian', $ju)
                            ->first();

        $m_kelas = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->where([
                'm_kelas_detail.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta
            ])
            ->first();


        return view('pages.mahasiswa.cetak.uas_front', compact('mahasiswa', 'ujian', 'jadwal', 'm_kelas'));
    }

     public function cetak_uas_back($id, $id_ta)
    {

        $rta    = @$id_ta;
        $ju     = @$id;    
        
    if( Auth::guard('mahasiswa')->user()->id_status == '6' )    
    
    {
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            // ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            // ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            // ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }else{
        $mahasiswa = Mahasiswa::leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah' )
            ->leftjoin('tbl_semester', 'tbl_semester.id_semester', 'm_mahasiswa.id_semester')
            ->leftJoin('m_kelas_detail', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_kelas', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->leftJoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', '=', 'm_kelas.tahun_akademik')
            ->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);
    }    


        $ujian = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
                            ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
                            ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
                            ->where('jenis_ujian', $ju)
                            ->first();
                            
        $krs = KRS::where([
                't_krs.nim' => $mahasiswa->nim,
                't_tahun_akademik.id_tahun_akademik' => $rta,
                't_krs.status' => 'Y'
            ])
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->first();
            
        $krs_item = $krs->krs_item()->leftjoin('m_matkul', 'm_matkul.id_matkul', 't_krs_item.id_matkul')->groupBy('t_krs_item.id_matkul')->get();                    

        // $jadwal = Jadwal_ujian::leftjoin('t_tahun_akademik', 't_tahun_akademik.id_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik')              
        //                     ->leftJoin('t_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian', 't_jadwal_ujian.id_jadwal_ujian')
        //                     ->leftJoin('t_jadwal_ujian_detail_kelas', 't_jadwal_ujian_detail_kelas.id_jadwal_ujian_detail', 't_jadwal_ujian_detail.id_jadwal_ujian_detail')
        //                     ->leftJoin('m_kelas', 't_jadwal_ujian_detail_kelas.id_kelas', 'm_kelas.id_kelas')
        //                     ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', 'm_kelas_detail.id_kelas')
        //                     ->leftjoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
        //                     ->where('t_jadwal_ujian.id_tahun_akademik', $rta)
        //                     ->where('jenis_ujian', $ju)
        //                     ->where('t_jadwal_ujian_detail_kelas.id_kelas', $mahasiswa->id_kelas)
        //                     ->groupBy('t_jadwal_ujian_detail.id_matkul')
        //                     ->get();


        return view('pages.mahasiswa.cetak.uas_back', compact('mahasiswa', 'ujian', 'jadwal', 'krs_item'));
    }

    protected function detail($tahun_akademik, $jenis_ujian, $waktu)
    {
        $data = [];

        $list_waktu = [
            'pagi' => ['00:00:00', '18:00:00'],
            'malam' => ['18:00:00', '24:00:00']
        ];

        $jadwal_ujian = Jadwal_ujian::leftJoin('t_tahun_akademik', 't_jadwal_ujian.id_tahun_akademik', 't_tahun_akademik.id_tahun_akademik')
            ->where([
                't_tahun_akademik.tahun_akademik' => $tahun_akademik,
                't_jadwal_ujian.jenis_ujian' => $jenis_ujian
            ])
            ->first();

        $jadwal_ujian_detail = $jadwal_ujian->jadwal_ujian_detail()
            ->leftJoin('m_matkul', 't_jadwal_ujian_detail.id_matkul', 'm_matkul.id_matkul')
            ->whereBetween('t_jadwal_ujian_detail.jam_mulai', $list_waktu[$waktu])
            ->get();

        foreach ($jadwal_ujian_detail as $list) {
            $data[$list->tanggal][] = $list;
        }

        return view('pages.admin.jadwal_ujian.detail', compact('tahun_akademik', 'jenis_ujian', 'waktu', 'data'));
    }
}
