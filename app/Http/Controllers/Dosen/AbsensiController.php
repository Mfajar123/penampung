<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;

use App\Kelas;
use App\Dosen;
use App\Jadwal;
use App\Matkul;
use App\Absensi;
use App\Absensi_detail;

class AbsensiController extends Controller
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
        $list_jadwal = array();
        $list_hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

        foreach ($jadwal_akademik as $jadwal)
        {
            $list_tahun_akademik[$jadwal->tahun_akademik] = $jadwal->keterangan;
        }

        if ($request->tahun_akademik)
        {
            $list_jadwal = Jadwal::where([
                'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
                'tahun_akademik' => $request->tahun_akademik
            ])->orderBy('jam_mulai', 'asc')->get();
        }

        return view('pages.dosen.absensi.index', compact('list_tahun_akademik', 'list_hari', 'list_jadwal'));
    }

    public function detail($id, $id_matkul, $id_jadwal)
    {
        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $jadwal = Jadwal::findOrFail($id_jadwal);
        $absensi_detail = Absensi_detail::select([
                't_absensi_detail.catatan_dosen'
            ])
            ->where([
                // 't_absensi_detail.id_jadwal' => $id_jadwal,
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
        
        // $list_kelas_detail = $list_kelas_detail->merge($list_kelas_detail_remedial);
        
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
                // 't_absensi.id_jadwal' => $id_jadwal,
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

                //$pertemuan_ke++;
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
        
        return view('pages.dosen.absensi.detail', compact('kelas', 'matkul', 'absensi_detail', 'tahun_akademik', 'list_kehadiran', 'jadwal', 'pertemuan', 'list_pertemuan'));
    }

    public function form_absensi($id, $id_matkul, $id_jadwal)
    {
        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $jadwal = Jadwal::findOrFail($id_jadwal);

        $list_mahasiswa = array();

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
            ->orderBy('nama', 'asc')
            ->get();
            
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
        
        // $list_kelas_detail = $list_kelas_detail->merge($list_kelas_detail_remedial);
        
        $list_kelas_detail = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $list_kelas_detail = json_decode(json_encode($list_kelas_detail), FALSE);

        foreach ($list_kelas_detail as $kelas_detail)
        {
            $list_mahasiswa[] = (object) array(
                'nim' => $kelas_detail->nim,
                'nama' => $kelas_detail->nama
            );
        }

        return view('pages.dosen.absensi.absensi', compact('kelas', 'matkul', 'jadwal', 'tahun_akademik', 'list_mahasiswa'));
    }

    public function form_edit($id, $id_matkul, $id_jadwal, $tanggal, $pertemuan_ke)
    {
        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $jadwal = Jadwal::findOrFail($id_jadwal);
        $absensi_detail = Absensi_detail::select([
                't_absensi_detail.catatan_dosen'
            ])
            ->where([
                // 't_absensi_detail.id_jadwal' => $id_jadwal,
                't_absensi_detail.id_matkul' => $id_matkul,
                't_absensi_detail.id_kelas' => $id
            ])
            ->orderBy('t_absensi_detail.id_absensi_detail')
            ->get();

        $list_pertemuan = Absensi::select([
                't_absensi.tanggal',
                't_absensi.pertemuan_ke'
            ])->where([
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id
            ])
            ->groupBy('t_absensi.tanggal')
            ->groupBy('t_absensi.pertemuan_ke')
            ->get();

        $pertemuan = [];

        foreach ($list_pertemuan as $i => $list) {
            $pertemuan[$list->tanggal.'.'.$list->pertemuan_ke] = $i;
        }

        $list_mahasiswa = array();

        $tahun_akademik = DB::select(DB::raw("
            select keterangan from t_tahun_akademik
            where tahun_akademik = '".$kelas->tahun_akademik."'
        "))[0]->keterangan;

        $absensi = Absensi::select([
            't_absensi.id_absensi',
            't_absensi.keterangan',
            't_absensi.nim',
            't_absensi.tanggal'
        ])
        ->where([
            // 't_absensi.id_jadwal' => $id_jadwal,
            't_absensi.id_matkul' => $id_matkul,
            't_absensi.id_kelas' => $id,
            't_absensi.tanggal' => $tanggal,
            't_absensi.pertemuan_ke' => $pertemuan_ke
        ])
        ->orderBy('t_absensi.tanggal', 'ASC')
        ->get();

        $kehadiran = [];

        foreach ($absensi as $list) {
            $kehadiran[$list->nim] = $list;
        }
        
        $list_kelas_detail = $kelas->kelas_detail()
            ->select([
                'm_kelas_detail.nim',
                'm_mahasiswa.nama'
            ])
            ->leftJoin('m_mahasiswa', 'm_kelas_detail.nim', '=', 'm_mahasiswa.nim')
            ->orderBy('nama', 'asc')
            ->get();
            
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
        
        // $list_kelas_detail = $list_kelas_detail->merge($list_kelas_detail_remedial);
        
        $list_kelas_detail = array_merge($list_kelas_detail->toArray(), $list_kelas_detail_remedial->toArray());

        $list_kelas_detail = json_decode(json_encode($list_kelas_detail), FALSE);

        foreach ($list_kelas_detail as $kelas_detail)
        {
            $list_mahasiswa[] = (object) array(
                'nim' => $kelas_detail->nim,
                'nama' => $kelas_detail->nama,
                'keterangan' => @$kehadiran[$kelas_detail->nim]->keterangan
            );
        }

        return view('pages.dosen.absensi.edit', compact('kelas', 'matkul', 'jadwal', 'absensi_detail', 'pertemuan', 'tahun_akademik', 'list_mahasiswa', 'tanggal', 'pertemuan_ke'));
    }

    public function absensi($id, $id_matkul, $id_jadwal, Request $request)
    {
        $data = array();

        $pertemuan_ke = Absensi_detail::where([
                // 't_absensi_detail.id_jadwal' => $id_jadwal,
                't_absensi_detail.id_kelas' => $id,
                't_absensi_detail.id_matkul' => $id_matkul
            ])
            ->count();

        foreach ($request->keterangan as $key => $val)
        {
            $data[] = array(
                // 'id_jadwal' => $id_jadwal,
                'id_kelas' => $id,
                'id_matkul' => $id_matkul,
                'tanggal' =>  date('Y-m-d', strtotime($request->tanggal)),
                'id_semester' => $request->semester,
                'nim' => $key,
                'keterangan' => $val,
                'notes' => $request->notes[$key],
                'pertemuan_ke' => $pertemuan_ke + 1,
            );
        }

        $absensi = Absensi::insert($data);

        $absensi_detail = Absensi_detail::insert([
            // 'id_jadwal' => $id_jadwal,
            'id_kelas' => $id,
            'id_matkul' => $id_matkul,
            'tanggal' =>  date('Y-m-d', strtotime($request->tanggal)),
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return redirect()->route('dosen.absensi.detail', ['id' =>$id, 'id_matkul' => $id_matkul, 'id_jadwal' => $id_jadwal]);
    }

    public function absensi_edit($id, $id_matkul, $id_jadwal, $tanggal, $pertemuan_ke, Request $request)
    {
        $list_absensi_detail = Absensi_detail::where([
                // 't_absensi_detail.id_jadwal' => $id_jadwal,
                't_absensi_detail.id_matkul' => $id_matkul,
                't_absensi_detail.id_kelas' => $id,
            ])
            ->orderBy('t_absensi_detail.id_absensi_detail')
            ->get();

        $list_pertemuan = Absensi::select([
                't_absensi.tanggal',
                't_absensi.pertemuan_ke'
            ])->where([
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id
            ])
            ->groupBy('t_absensi.tanggal')
            ->groupBy('t_absensi.pertemuan_ke')
            ->get();

        $pertemuan = [];

        foreach ($list_pertemuan as $i => $list) {
            $pertemuan[$list->tanggal.'.'.$list->pertemuan_ke] = $i;
        }

        $absensi_detail = [];

        foreach ($list_absensi_detail as $i => $list) {
            $absensi_detail[$i] = $list;
        }

        if (! empty($absensi_detail[$pertemuan[$tanggal.'.'.$pertemuan_ke]]->id_absensi_detail)) {
            $update_absensi_detail = Absensi_detail::where([
                    'id_absensi_detail' => $absensi_detail[$pertemuan[$tanggal.'.'.$pertemuan_ke]]->id_absensi_detail
                ])
                ->update([
                    'tanggal' =>  date('Y-m-d', strtotime($request->tanggal)),
                    'catatan_dosen' => $request->catatan_dosen
                ]);
        }
        
        foreach ($request->keterangan as $key => $val)
        {
            $count = Absensi::where([
                // 't_absensi.id_jadwal' => $id_jadwal,
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id,
                't_absensi.tanggal' => $tanggal,
                't_absensi.pertemuan_ke' => $pertemuan_ke,
                't_absensi.nim' => $key
            ])->count();

            if (! empty($count)) {
                Absensi::where([
                    // 't_absensi.id_jadwal' => $id_jadwal,
                    't_absensi.id_matkul' => $id_matkul,
                    't_absensi.id_kelas' => $id,
                    't_absensi.tanggal' => $tanggal,
                    't_absensi.pertemuan_ke' => $pertemuan_ke,
                    't_absensi.nim' => $key
                ])->update([
                    't_absensi.keterangan' => $val,
                    't_absensi.tanggal' => date('Y-m-d', strtotime($request->tanggal))
                ]);
            } else {
                Absensi::insert([
                    // 't_absensi.id_jadwal' => $id_jadwal,
                    't_absensi.id_matkul' => $id_matkul,
                    't_absensi.id_kelas' => $id,
                    't_absensi.tanggal' => $tanggal,
                    't_absensi.pertemuan_ke' => $pertemuan_ke,
                    't_absensi.nim' => $key,
                    't_absensi.keterangan' => $val,
                    't_absensi.tanggal' => date('Y-m-d', strtotime($request->tanggal))
                ]);
            }
        }

        return redirect()->route('dosen.absensi.detail', ['id' =>$id, 'id_matkul' => $id_matkul, 'id_jadwal' => $id_jadwal]);
    }

    public function edit_absensi($id, $id_matkul, $id_jadwal, Request $request)
    {
        $id_dosen = Auth::guard('dosen')->user()->id_dosen;
        $tanggal = explode('.', $request->pertemuan_ke)[0];
        $pertemuan = explode('.', $request->pertemuan_ke)[1];

        // $absensi = Absensi::where([
        //     'id_kelas' => $id,
        //     'id_matkul' => $id_matkul,
        //     'id_dosen' => Auth::guard('dosen')->user()->id_dosen,
        //     'nim' => $request->nim,
        //     'tanggal' => $request->pertemuan_ke
        // ])->update([
        //     'keterangan' => $request->keterangan
        // ]);
        
        $pertemuan_ke = Absensi::where([
            'id_kelas' => $id,
            'id_matkul' => $id_matkul,
            'tanggal' => $tanggal,
            'pertemuan_ke' => $pertemuan
        ])->first();
        
        $absensi = Absensi::where([
            'id_kelas' => $id,
            'id_matkul' => $id_matkul,
            'nim' => $request->nim,
            'tanggal' => $tanggal,
            'pertemuan_ke' => $pertemuan
        ])->first();
        
        if (! empty($absensi)) {
            $absensi->update([
                'keterangan' => $request->keterangan
            ]);
        } else {
            Absensi::create([
                // 'id_jadwal' => $id_jadwal,
                'id_kelas' => $id,
                'id_matkul' => $id_matkul,
                'nim' => $request->nim,
                'tanggal' => $tanggal,
                'keterangan' => $request->keterangan,
                'pertemuan_ke' => $pertemuan_ke->pertemuan_ke
            ]);
        }

        Session::flash('success', 'Absensi berhasil diedit.');

        return redirect()->back();
    }

    public function kehadiran($id, $id_matkul, Request $request)
    {
        /*$list_semester  = array();*/
        $list_mahasiswa = array();
        $list_pertemuan = array();
        $notes = "";
        $no = 1;

   
        /*select petermuan*/
        $pertemuan = Absensi::select('tanggal')
            ->where([
                'id_kelas' => $id,
                'id_matkul' => $id_matkul
            ])
            ->orderBy('tanggal', 'ASC')
            ->groupBy('tanggal')
            ->get();

        foreach ($pertemuan as $list)
        {
            $list_pertemuan[$list->tanggal] = "Pertemuan ke-".$no++." (".date('d M Y', strtotime($list->tanggal)).")";
        }

      

        if ($request->tanggal)
        {
            $pertemuan = $pertemuan->first();

            $list_mahasiswa = Absensi::select([
                    't_absensi.nim',
                    'm_mahasiswa.nama',
                    't_absensi.keterangan'
                ])
                ->leftJoin('m_mahasiswa', 't_absensi.nim', '=', 'm_mahasiswa.nim')
                ->where([
                    't_absensi.id_kelas' => $id,
                    't_absensi.id_matkul' => $id_matkul,
                    't_absensi.tanggal' =>$request->tanggal
                ])
                ->orderBy('t_absensi.tanggal', 'ASC')
                ->get();
        
            
            if ($list_mahasiswa->count() > 0) $notes = $list_mahasiswa->first()->pluck('notes')[0];   
        
        }

        return view('pages.dosen.absensi.kehadiran', compact('pertemuan', 'notes', /*'list_semester', */'list_mahasiswa', 'list_pertemuan'));
    }






    public function print($id, $id_matkul, Request $request)
    {
        $list_semester  = array();
        $list_keterangan  = array();
        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $notes = "";
        $no = 1;
        $dosen = Dosen::leftJoin('t_jadwal', 'm_dosen.id_dosen', '=', 't_jadwal.id_dosen')
        		->leftJoin('tbl_waktu_kuliah', 't_jadwal.id_waktu_kuliah', '=', 'tbl_waktu_kuliah.id_waktu_kuliah')
        		->where('nip', Auth::guard('dosen')->user()->nip)
        		->groupBy('m_dosen.id_dosen')
        		->get();

     



        /*select petermuan*/
        $pertemuan = Absensi::select('tanggal')
            ->where([
                'id_kelas' => $id,
                'id_matkul' => $id_matkul
            ])
            ->orderBy('tanggal', 'ASC')
            ->groupBy('tanggal')
            ->get();
         foreach ($pertemuan as $list)
        {
            $list_pertemuan[$list->tanggal] = $list->tanggal;
        }

        

        if ($id)
        {
            /*$semester = $semester->first();
*/
            $mahasiswa = Absensi::select([
                    't_absensi.nim',
                    'm_mahasiswa.nama',
                    't_absensi.keterangan',
                    't_absensi.tanggal'
                ])
                ->leftJoin('m_mahasiswa', 't_absensi.nim', '=', 'm_mahasiswa.nim')
                ->where([
                    't_absensi.id_kelas' => $id,
                    't_absensi.id_matkul' => $id_matkul,
                    't_absensi.id_semester' => $kelas->id_semester
                ])
                ->orderBy('t_absensi.tanggal', 'ASC')
                ->groupBy('t_absensi.nim')
                ->get();

           
            $list_keterangan = Absensi::select([
                        't_absensi.nim',
                        'm_mahasiswa.nama',
                        't_absensi.keterangan',
                        't_absensi.pertemuan_ke'
                    ])
                    ->leftJoin('m_mahasiswa', 't_absensi.nim', '=', 'm_mahasiswa.nim')
                    ->where([
                        't_absensi.id_kelas' => $id,
                        't_absensi.id_matkul' => $id_matkul,
                        't_absensi.id_semester' => $kelas->id_semester
                    ])
                    ->orderBy('t_absensi.tanggal', 'ASC')

                    ->get();

            $bancet = array();
            foreach ($list_keterangan as $bancet_kecebur) {

                $bancet[$bancet_kecebur->nim][$bancet_kecebur->pertemuan_ke] = $bancet_kecebur->keterangan;

            }
                 
         
            if ($mahasiswa->count() > 0) $notes = $mahasiswa->first()->pluck('notes')[0];

        }



        return view('pages.dosen.absensi.print', compact('kelas', 'matkul', 'bancet', 'pertemuan', 'notes', 'list_semester', 'mahasiswa', 'list_pertemuan', 'dosen', 'list_keterangan'));
    }

    public function hapus_absensi($id, $id_matkul, $id_jadwal, $tanggal, $pertemuan_ke)
    {
        $id_dosen = Auth::guard('dosen')->user()->id_dosen;

        $kelas = Kelas::findOrFail($id);
        $matkul = Matkul::findOrFail($id_matkul);
        $dosen = Dosen::findOrFail($id_dosen);
        $jadwal = Jadwal::findOrFail($id_jadwal);
        $absensi_detail = Absensi_detail::select([
                't_absensi_detail.id_absensi_detail',
                't_absensi_detail.catatan_dosen'
            ])
            ->where([
                // 't_absensi_detail.id_jadwal' => $id_jadwal,
                't_absensi_detail.id_matkul' => $id_matkul,
                't_absensi_detail.id_kelas' => $id,
                // 't_absensi_detail.id_dosen' => $id_dosen
            ])
            ->orderBy('t_absensi_detail.id_absensi_detail')
            ->get();

        $list_pertemuan = Absensi::select([
            't_absensi.tanggal',
            't_absensi.pertemuan_ke'
            ])->where([
                't_absensi.id_matkul' => $id_matkul,
                't_absensi.id_kelas' => $id,
                // 't_absensi.id_dosen' => $id_dosen
            ])
            ->groupBy('t_absensi.tanggal')
            ->groupBy('t_absensi.pertemuan_ke')
            ->get();

        $pertemuan = [];

        foreach ($list_pertemuan as $i => $list) {
            $pertemuan[$list->tanggal.'.'.$list->pertemuan_ke] = $i;
        }

        $list_mahasiswa = array();

        $tahun_akademik = DB::select(DB::raw("
            select keterangan from t_tahun_akademik
            where tahun_akademik = '".$kelas->tahun_akademik."'
        "))[0]->keterangan;

        $absensi = Absensi::select([
            't_absensi.id_absensi',
            't_absensi.keterangan',
            't_absensi.nim',
            't_absensi.tanggal'
        ])
        ->where([
            // 't_absensi.id_jadwal' => $id_jadwal,
            't_absensi.id_matkul' => $id_matkul,
            't_absensi.id_kelas' => $id,
            // 't_absensi.id_dosen' => $id_dosen,
            't_absensi.tanggal' => $tanggal,
            't_absensi.pertemuan_ke' => $pertemuan_ke
        ])
        ->orderBy('t_absensi.tanggal', 'ASC')
        ->delete();

        $id_absensi_detail = @$absensi_detail[$pertemuan[$tanggal.'.'.$pertemuan_ke]]->id_absensi_detail;

        if (! empty($id_absensi_detail)) Absensi_detail::where('id_absensi_detail', $id_absensi_detail)->delete();
        
        Session::flash('flash_success', 'Absensi berhasil dihapus.');

        return redirect()->back();
    }
}
