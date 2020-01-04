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

use App\Jadwal;
use App\TahunAkademik;
use App\Prodi;
use App\Semester;
use App\Kelas;
use App\Matkul;
use App\Dosen;
use App\Ruang;
use App\WaktuKuliah;
use App\Hari;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $request)
    {
        $data = array();
        $no = 1;

        $jadwal = Jadwal::select([
            't_jadwal.id_jadwal',
            't_jadwal.jam_mulai',
            't_jadwal.jam_selesai',
            't_jadwal.hari',
            'm_ruang.kode_ruang',
            'm_ruang.nama_ruang',
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            'm_matkul.sks',
            'm_kelas.id_prodi',
            'm_kelas.kode_kelas',
            'm_dosen.nip',
            'm_dosen.nama AS nama_dosen'
        ])
        ->leftJoin('m_ruang', 't_jadwal.id_ruang', '=', 'm_ruang.id_ruang')
        ->leftJoin('m_matkul','t_jadwal.id_matkul', '=', 'm_matkul.id_matkul')
        ->leftJoin('m_kelas', 't_jadwal.id_kelas', '=', 'm_kelas.id_kelas')
        ->leftJoin('m_dosen', 't_jadwal.id_dosen', '=', 'm_dosen.id_dosen');

        if (! empty($request->tahun_akademik))
        {
            $jadwal = $jadwal->where('t_jadwal.tahun_akademik', $request->tahun_akademik);
        }

        if (! empty($request->id_prodi))
        {
            $jadwal = $jadwal->where('t_jadwal.id_prodi', $request->id_prodi);
        }

        if (! empty($request->id_waktu_kuliah))
        {
            $jadwal = $jadwal->where('t_jadwal.id_waktu_kuliah', $request->id_waktu_kuliah);
        }

        if (! empty($request->id_semester))
        {
            $jadwal = $jadwal->where('t_jadwal.id_semester', $request->id_semester);
        }

        if (! empty($request->id_kelas))
        {
            $jadwal = $jadwal->where('m_kelas.id_kelas', $request->id_kelas);
        }
        
        $jadwal = $jadwal->orderBy('t_jadwal.id_jadwal', 'DESC')->get();

        foreach ($jadwal as $list)
        {
            $data[] = array(
                'no' => $no++,
                'id_jadwal' => $list->id_jadwal,
                'hari_jam' => $list->hari.'<br />'.date('H:i', strtotime($list->jam_mulai)).' - '.date('H:i', strtotime($list->jam_selesai)),
                'ruang' => $list->kode_ruang,
                'matkul' => $list->kode_matkul.' - '.$list->nama_matkul.'<br />'.$list->sks.' sks',
                'kelas' => $list->id_prodi.' - '.$list->kode_kelas,
                'dosen' => $list->nama_dosen.'<br />'.$list->nip
            );
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        $list_tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $list_waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');
        $list_semester = Semester::pluck('semester_ke', 'id_semester');

        $list_tahun_akademik->prepend('- Semua -', '');
        $list_prodi->prepend('- Semua -', '');
        $list_waktu_kuliah->prepend('- Semua -', '');
        $list_semester->prepend('- Semua -', '');
        
        return view('pages.admin.jadwal.index', compact('list_tahun_akademik', 'list_prodi', 'list_waktu_kuliah', 'list_semester'));
    }

    public function tambah()
    {
        $tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->get();
        $prodi = Prodi::all();
        $semester = Semester::all();
        $kelas = Kelas::all();
        $matkul = Matkul::where('is_delete', 'N')->get();
        $ruang = Ruang::where('is_delete', 'N')->get();
        $dosen = Dosen::where('is_delete', 'N')->get();
        $waktu = WaktuKuliah::all();
        $hari = Hari::pluck('nama_hari', 'nama_hari');

        return view('pages.admin.jadwal.tambah', compact('tahun_akademik', 'prodi', 'semester', 'kelas', 'matkul', 'dosen', 'ruang', 'waktu', 'hari'));
    }

    public function simpan(Request $req)
    {
        $input = $req->all();
        $input['create_by'] = Auth::guard('admin')->user()->nama;
        $input['create_date'] = date('Y-m-d H:i:s');

        $cek_jadwal = Jadwal::where([
            'tahun_akademik' => $req->tahun_akademik,
            'hari' => $req->hari,
            'id_ruang' => $req->id_ruang,
            'jam_mulai' => $req->jam_mulai,
            'jam_selesai' => $req->jam_selesai
        ])->get();

        // if ($cek_jadwal->count() > 0) {
        //     return response()->json(array(
        //         'status' => 'error',
        //         'message' => $cek_jadwal->first()->ruang->nama_ruang." pada jam ".$req->jam_mulai." s.d ".$req->jam_selesai." untuk hari ".$req->hari." sudah terpakai untuk perkuliahan !"
        //     ));
        // } else {
            Jadwal::create($input);
            Session::flash('success', 'Jadwal berhasil disimpan.');

            return response()->json(array('status' => 'success', 'input' => $req->all()));
        // }
    }

    public function ubah($id)
    {
        $jadwal = Jadwal::find($id);
        $tahun_akademik = TahunAkademik::where('is_delete', 'N')->get();
        $prodi = Prodi::all();
        $semester = Semester::all();
        $kelas = Kelas::all();
        $matkul = Matkul::where('is_delete', 'N')->get();
        $ruang = Ruang::where('is_delete', 'N')->get();
        $dosen = Dosen::where('is_delete', 'N')->get();
        $waktu = WaktuKuliah::all();
        $hari = Hari::pluck('nama_hari', 'nama_hari');
        return view('pages.admin.jadwal.ubah', compact('jadwal', 'id','tahun_akademik', 'prodi', 'semester', 'kelas', 'matkul', 'dosen', 'ruang', 'waktu', 'hari'));
    }

    public function perbarui($id, Request $req)
    {
        $jadwal = Jadwal::find($id);
        $input = $req->all();
        $input['update_by'] = Auth::guard('admin')->user()->nama;
        $input['update_date'] = date('Y-m-d H:i:s');

        $cek_jadwal = Jadwal::where([
            'tahun_akademik' => $req->tahun_akademik,
            'hari' => $req->hari,
            'id_ruang' => $req->id_ruang,
            'jam_mulai' => $req->jam_mulai,
            'jam_selesai' => $req->jam_selesai
        ])->get();

        // if ($cek_jadwal->count() > 0) {
        //     if ($cek_jadwal->first()->id_jadwal != $id) {
        //         return response()->json(array(
        //             'status' => 'error',
        //             'message' => $cek_jadwal->first()->ruang->nama_ruang." pada jam ".$req->jam_mulai." s.d ".$req->jam_selesai." untuk hari ".$req->hari." sudah terpakai untuk perkuliahan !"
        //         ));
        //     }
        // }
        
        $jadwal->update($input);
        Session::flash('success', 'Jadwal berhasil diperbarui.');

        return response()->json(array('status' => 'success'));
    }

    public function hapus($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function get_kelas(Request $request)
    {
        $data = Kelas::select([
            'm_kelas.id_kelas',
            'm_kelas.kode_kelas'
        ])
        ->where([
            'm_kelas.tahun_akademik' => $request->tahun_akademik,
            'm_kelas.id_prodi' => $request->id_prodi,
            'm_kelas.id_waktu_kuliah' => $request->id_waktu_kuliah,
            'm_kelas.id_semester' => $request->id_semester
        ])
        ->get();

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
