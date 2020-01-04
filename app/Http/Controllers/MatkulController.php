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

/*use App\Users;*/
use App\Semester;
use App\Prodi;
use App\Jenjang;
use App\Kompetensi;
use App\Matkul;

class MatkulController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $req)
    {
        $data = array();
        $no = 1;

        if(!empty($req->segment(4)))
        {
            $matkul = Matkul::where('is_delete', 'Y')->get();
        }
        else
        {
            $matkul = Matkul::where('is_delete', 'N');

            if (! empty($req->id_prodi))
            {
                $matkul = $matkul->where('m_matkul.id_prodi', $req->id_prodi);
            }
    
             $matkul = $matkul->get();
        }
        foreach ($matkul as $list)
        {
            $toTrash = "'Anda Yakin Akan Menghapus matkul ".$list->nama_matkul."'";
            $hapus = "'Anda Yakin Akan Menghapus Permanen matkul ".$list->nama_matkul."'";
            $restore = "'Anda Yakin Akan Mengembalikan Data matkul ".$list->nama_matkul."'";

            $row = array();
            $row['no'] = $no;
            $row['prodi'] = $list->prodi->nama_prodi;
            // $row['semester'] = $list->semester->semester_ke;
            // $row['jenjang'] = $list->jenjang->nama_jenjang;
            // $row['kompetensi'] = $list->kompetensi->nama_kompetensi;
            $row['kode_matkul'] = $list->kode_matkul;
            $row['nama_matkul'] = $list->nama_matkul;
            $row['sks'] = $list->sks;
            if(!empty($req->segment(4)))
            {
                $row['aksi'] =
                '<a href="'.route('admin.matkul.restore', $list->id_matkul).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
                <a href="'.route( 'admin.matkul.hapus.permanent', $list->id_matkul).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
            }
            else
            {
                $row['aksi'] =
                '
                <a href="'.route('admin.matkul.ubah', $list->id_matkul).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.matkul.hapus', $list->id_matkul).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
            }

            $data[] = $row;
            $no++;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index() {
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        $list_prodi->prepend('- Semua -', '');

        return view('pages.admin.matkul.index', compact('list_prodi'));
    }

    public function trash()
    {
        return view('pages.admin.matkul.trash');
    }

    public function tambah()
    {
        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $semester = Semester::pluck('semester_ke', 'id_semester');
        $jenjang = Jenjang::pluck('nama_jenjang', 'id_jenjang');
        $kompetensi = Kompetensi::pluck('nama_kompetensi', 'id_kompetensi');

        return view('pages.admin.matkul.tambah', compact('prodi', 'semester', 'jenjang', 'kompetensi'));
    }

    public function simpan(Request $req)
    {
        $input = $req->all();
        $b = Prodi::where('id_prodi', $req->id_prodi)->first();
        $prodi = $b->kode_prodi;
        $semester = $req->id_semester;
        $jenjang = $req->id_jenjang;
        $kompetensi = $req->id_kompetensi;
        $huruf_awal = $prodi.$semester.$jenjang.$kompetensi;
        $last_data = DB::select(DB::raw("SELECT * FROM m_matkul WHERE kode_matkul LIKE '$huruf_awal%' ORDER BY id_matkul DESC "));
        if (empty($last_data)) {
      		$next_id = "1";
      		$nol = "0";
      	}else{
      		$last_data = $last_data[0]->kode_matkul;
      		$explode = explode($huruf_awal, $last_data);
      		$next_id = $explode[1]+1;
      		$nol = substr("00", 0, 2 - strlen($next_id));
      	}
      	$ref_baru = $huruf_awal.$nol.$next_id;
        $input['kode_matkul'] = $ref_baru;
        $input['create_by'] = Auth::guard('admin')->user()->nama;
        $input['create_date'] = date('Y-m-d H:i:s');
        Matkul::create($input);
        Session::flash('success', 'Mata Kuliah Berhasil Ditambahkan');
        return redirect()->route('admin.matkul');
    }

    public function ubah($id)
    {
        $matkul = Matkul::find($id);

        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $semester = Semester::pluck('semester_ke', 'id_semester');
        $jenjang = Jenjang::pluck('nama_jenjang', 'id_jenjang');
        $kompetensi = Kompetensi::pluck('nama_kompetensi', 'id_kompetensi');

        return view('pages.admin.matkul.ubah', compact('prodi', 'semester', 'jenjang', 'kompetensi', 'id', 'matkul'));
    }

    public function perbarui($id, Request $req)
    {
        $matkul = Matkul::find($id);
        $input = $req->all();
        if($req->id_jenjang != $matkul->id_jenjang || $req->id_kompetensi != $matkul->id_kompetensi || $req->id_prodi != $matkul->id_prodi || $req->id_semester != $matkul->id_semester)
        {
          // $a = $req->id_prodi;
          $b = Prodi::where('id_prodi', $req->id_prodi)->first();
          $prodi = $b->kode_prodi;
          $semester = $req->id_semester;
          $jenjang = $req->id_jenjang;
          $kompetensi = $req->id_kompetensi;
          $huruf_awal = $prodi.$semester.$jenjang.$kompetensi;
          $last_data = DB::select(DB::raw("SELECT * FROM m_matkul WHERE kode_matkul LIKE '$huruf_awal%' ORDER BY id_matkul DESC "));
          if (empty($last_data)) {
        		$next_id = "1";
        		$nol = "0";
        	}else{
        		$last_data = $last_data[0]->kode_matkul;
        		$explode = explode($huruf_awal, $last_data);
        		$next_id = $explode[1]+1;
        		$nol = substr("00", 0, 2 - strlen($next_id));
        	}
        	$ref_baru = $huruf_awal.$nol.$next_id;
          $kode_matkul = $ref_baru;
        }else{
          $kode_matkul = $matkul->kode_matkul;
        }
        $input['kode_matkul'] = $kode_matkul;
        $input['update_by'] = Auth::guard('admin')->user()->nama;
        $input['update_date'] = date('Y-m-d H:i:s');
        $matkul->update($input);
        Session::flash('success', 'Data Mata Kuliah Berhasil Diperbarui.');
        return redirect()->route('admin.matkul');
    }

    public function toTrash($id)
    {
        Matkul::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

        Session::flash('fail', 'Data Matkul Berhasil Dihapus.');

        return redirect()->route('admin.matkul');
    }

    public function restore($id)
    {
        Matkul::find($id)->update(['is_delete' => 'N']);

        Session::flash('success', 'Data Mata Kuliah Berhasil Dikembalikan.');

        return redirect()->route('admin.matkul.trash');
    }

    public function hapus($id)
    {
        Matkul::find($id)->delete();

        Session::flash('success', 'Mata Kuliah Berhasil Dihapus');

        return redirect()->route('admin.matkul');
    }
}
