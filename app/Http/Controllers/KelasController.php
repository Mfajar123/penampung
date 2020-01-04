<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Session;
use DataTables;

/*use App\Users;*/

use App\Semester;
use App\Prodi;
use App\Jenjang;
use App\Kompetensi;
use App\Kelas;
use App\TahunAkademik;
use App\WaktuKuliah;
use App\KelasDetail;
use App\KelasDetailRemedial;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $request)
    {
        $data = array();
        $no = 1;

        $kelas = Kelas::select([
            'm_kelas.id_kelas',
            'm_kelas.kode_kelas',
            'm_kelas.nama_kelas',
            'm_kelas.kapasitas',
            'tbl_prodi.nama_prodi',
            't_tahun_akademik.keterangan AS tahun_akademik',
            'tbl_waktu_kuliah.nama_waktu_kuliah',
            DB::raw("((SELECT COUNT(DISTINCT nim) FROM m_kelas_detail AS mkd WHERE mkd.id_kelas = m_kelas.id_kelas and m_kelas.is_delete = 'N' GROUP BY m_kelas_detail.nim ) + COUNT(DISTINCT m_kelas_detail_remedial.nim)) AS terisi")
        ])
        ->leftJoin('tbl_prodi', 'm_kelas.id_prodi', '=', 'tbl_prodi.id_prodi')
        ->leftJoin('t_tahun_akademik', 'm_kelas.tahun_akademik', 't_tahun_akademik.tahun_akademik')
        ->leftJoin('tbl_waktu_kuliah', 'm_kelas.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
        ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
        ->leftJoin('m_kelas_detail_remedial', 'm_kelas.id_kelas', '=', 'm_kelas_detail_remedial.id_kelas')
        ->groupBy('m_kelas.id_kelas');

        if (! empty($request->id_prodi))
        {
            $kelas = $kelas->where('m_kelas.id_prodi', $request->id_prodi);
        }

        if (! empty($request->id_tahun_akademik))
        {
            $kelas = $kelas->where('t_tahun_akademik.id_tahun_akademik', $request->id_tahun_akademik);
        }
        
        $kelas = $kelas->orderBy('m_kelas.id_kelas', 'DESC')->get();

        foreach ($kelas as $list)
        {
            $data[] = array(
                'no' => $no++,
                'id_kelas' => $list->id_kelas,
                'kode_kelas' => $list->kode_kelas,
                'nama_kelas' => $list->nama_kelas,
                'kapasitas' => $list->kapasitas,
                'nama_prodi' => $list->nama_prodi,
                'tahun_akademik' => $list->tahun_akademik,
                'nama_waktu_kuliah' => $list->nama_waktu_kuliah,
                'terisi' => $list->terisi,
                'actions' => ''
            );
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }


    public function index()
    {
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $list_tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'id_tahun_akademik');

        $list_prodi = $list_prodi->prepend('Semua Program Studi', '');
        $list_tahun_akademik = $list_tahun_akademik->prepend('Semua Tahun Akademik', '');
        return view('pages.admin.kelas.index', compact('list_prodi', 'list_tahun_akademik'));
    }



    public function tambah()

    {

        $waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        $semester = Semester::pluck('semester_ke', 'id_semester');

        $tahun_akademik = TahunAkademik::orderBy('tahun_akademik','DESC')->pluck('keterangan', 'tahun_akademik');

        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        return view('pages.admin.kelas.tambah', compact('semester', 'tahun_akademik', 'waktu_kuliah', 'prodi'));

    }



    public function simpan(Request $req)

    {

        $input = $req->all();

        $input['kode_kelas'] = $req->id_semester.$req->kelas;
        
        $input['created_date'] = date('Y-m-d H:i:s') ;
        
        $input['created_by'] = Auth::guard('admin')->user()->nama;
        
        // cek apakah kelas tersebut sudah terdaftar atau tidak
        $cek_kelas = Kelas::where([
            'nama_kelas' => $req->nama_kelas,
            'id_waktu_kuliah' => $req->id_waktu_kuliah,
            'tahun_akademik' => $req->id_tahun_akademik,
            'id_prodi' => $req->id_prodi
        ])
        ->count();
        

        if($cek_kelas > 0)

        {

            Session::flash('fail', 'Nama Kelas Sudah Ada !');



            return redirect()->back()->withInput($req->all());

        }

        else

        {

            Kelas::create($input);

            Session::flash('success', 'Data Kelas Berhasil Diinput');



            return redirect()->route('admin.kelas');

        }

    }



    public function ubah($id)

    {

        $kelas = Kelas::find($id);

        $waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        $semester = Semester::pluck('semester_ke', 'id_semester');

        $tahun_akademik = TahunAkademik::pluck('keterangan', 'tahun_akademik');

        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        return view('pages.admin.kelas.ubah', compact('kelas', 'id', 'waktu_kuliah', 'semester', 'tahun_akademik', 'prodi'));

    }



    public function perbarui($id, Request $req)

    {

        $kelas = Kelas::find($id);

        $input = $req->all();

        $input['kode_kelas'] = $req->id_semester.$req->kelas;
        
        // cek apakah kelas tersebut sudah terdaftar atau tidak
        $cek_kelas = Kelas::where([
            'nama_kelas' => $req->nama_kelas,
            'id_waktu_kuliah' => $req->id_waktu_kuliah,
            'tahun_akademik' => $req->id_tahun_akademik,
            'id_prodi' => $req->id_prodi
        ])
        ->count();

        if($cek_kelas > 0)

        {

            Session::flash('fail', 'Nama Kelas Sudah Ada !');



            return redirect()->back()->withInput($req->all());

        }

        else

        {

            $kelas->update($input);

            Session::flash('success', 'Data Kelas Berhasil Diubah');



            return redirect()->route('admin.kelas');

        }

    }

    public function hapus($id)
    {
        $kelas = Kelas::find($id);

        $kelas->kelas_detail()->delete();
        $kelas->delete();

        return response()->json(['status' => 'success']);
    }



    public function detail($id)
    {
        $kelas = KelasDetail::select([
                'm_mahasiswa.nim',
                'm_mahasiswa.nama'
            ])
            ->join('m_mahasiswa', 'm_mahasiswa.nim', '=', 'm_kelas_detail.nim')
            ->where('id_kelas', $id)
            ->groupBy('m_kelas_detail.nim')
            ->get();
        
        $kelas_remedial = KelasDetailRemedial::select([
                'm_mahasiswa.nim',
                'm_mahasiswa.nama'
            ])
            ->join('m_mahasiswa', 'm_mahasiswa.nim', '=', 'm_kelas_detail_remedial.nim')
            ->where('id_kelas', $id)
            ->get();

        // $kelas = $kelas->merge($kelas_remedial);
        
        $kelas = array_merge($kelas->toArray(), $kelas_remedial->toArray());
        
        $kelas = json_decode (json_encode ($kelas), FALSE);

        $nama = Kelas::where('id_kelas', $id)->get();

        foreach ($nama as $p);

        return view('pages.admin.kelas.detail', compact('kelas', 'kode', 'p'));
    }
    
    
    public function no_absen($id) {
        
        $kelas          = Kelas::find($id);
        
        $detail_kelas   = KelasDetail::where('id_kelas', $id)->orderBy('nim', 'ASC')->get();
        
        $i = 1;
        
       foreach ($detail_kelas as $dd) { 
        	
        	$input = KelasDetail::where('id_kelas', $id)->where('id_kelas_detail', $dd->id_kelas_detail)->update([ 'no_absen' => $i ]);
        	$i++;
        }

          return redirect()->route('admin.kelas');
    }

}

