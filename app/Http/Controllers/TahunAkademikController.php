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

use App\TahunAkademik;
use App\TahunAkademikItem;
use App\Prodi;

class TahunAkademikController extends Controller
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
          $tahun = TahunAkademik::where('is_delete', 'Y')->get();
      }
      else
      {
          $tahun = TahunAkademik::where('is_delete', 'N')->get();
      }
      foreach ($tahun as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus Tahun Akademik ".$list->tahun_akademik."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen Tahun Akademik ".$list->tahun_akademik."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data Tahun Akademik ".$list->tahun_akademik."'";

          $row = array();
          $row['no'] = $no;
          $row['tahun_akademik'] = $list->tahun_akademik;
        //   $row['prodi'] = $list->prodi->nama_prodi;
          $row['semester'] = $list->semester;
          $row['keterangan'] = $list->keterangan;
          if ($list->status == 1) {
            $row['status'] = 'Aktif';
          }else{
            $row['status'] = 'Tidak Aktif';
          }
          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.tahun_akademik.restore', $list->id_tahun_akademik).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.tahun_akademik.hapus.permanent', $list->id_tahun_akademik).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.tahun_akademik.ubah', $list->id_tahun_akademik).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.tahun_akademik.hapus', $list->id_tahun_akademik).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }
  public function trash()
  {
      return view('pages.admin.tahun_akademik.trash');
  }
  public function tambah()
  {
      $lima_tahun_depan = date("Y", strtotime("+5 Year"));
      $empat_tahun_depan = date("Y", strtotime("+4 Year"));
      $tiga_tahun_depan = date("Y", strtotime("+3 Year"));
      $dua_tahun_depan = date("Y", strtotime("+2 Year"));
      $tahun_depan = date("Y", strtotime("+1 Year"));
      $tahun_ini = date("Y");
      $tahun_lalu = date("Y", strtotime("-1 Year"));
      $dua_tahun_lalu = date("Y", strtotime("-2 Year"));
      $tiga_tahun_lalu = date("Y", strtotime("-3 Year"));
      $empat_tahun_lalu = date("Y", strtotime("-4 Year"));
      $lima_tahun_lalu = date("Y", strtotime("-5 Year"));
      return view('pages.admin.tahun_akademik.tambah',
             compact('lima_tahun_depan','empat_tahun_depan',
                     'tiga_tahun_depan','dua_tahun_depan','tahun_ini',
                     'tahun_depan', 'tahun_lalu', 'dua_tahun_lalu', 
                     'tiga_tahun_lalu', 'empat_tahun_lalu', 'lima_tahun_lalu'));
  }
  public function simpan(Request $request)
  {
      $input = $request->all();
      if ($request->semester == 'Ganjil') {
        $input['tahun_akademik'] = substr($request->tahun_akademik, 0, 4).'10';
      }
      else{
        $input['tahun_akademik'] = substr($request->tahun_akademik, 0, 4).'20';
      }
      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      TahunAkademik::create($input);
      Session::flash('success', 'TahunAkademik Berhasil Ditambahkan');

      return redirect()->route('admin.tahun_akademik');
  }
  public function ubah($id)
  {
      $tahun = TahunAkademik::find($id);
      $prodi = Prodi::pluck('nama_prodi', 'id_prodi');
      return view('pages.admin.tahun_akademik.ubah', compact('tahun', 'id', 'prodi'));
  }
  public function perbarui($id, Request $request)
  {
      $tahun = TahunAkademik::find($id);
      $input = $request->all();
      if ($request->semester == 'Ganjil') {
        $input['tahun_akademik'] = substr($request->tahun_akademik, 0, 4).'10';
      }
      else{
        $input['tahun_akademik'] = substr($request->tahun_akademik, 0, 4).'20';
      }
      $input['update_by'] = Auth::guard('admin')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $tahun->update($input);
      Session::flash('success', 'Data TahunAkademik Berhasil Diperbarui.');

      return redirect()->route('admin.tahun_akademik');
  }
  public function toTrash($id)
  {
      TahunAkademik::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data TahunAkademik Berhasil Dihapus.');

      return redirect()->route('admin.tahun_akademik');
  }
  public function restore($id)
  {
      TahunAkademik::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data TahunAkademik Berhasil Dikembalikan.');

      return redirect()->route('admin.tahun_akademik.trash');
  }
  public function hapus($id)
  {
      $tahun = TahunAkademik::find($id);

      $tahun->delete();

      Session::flash('success', 'Data TahunAkademik Berhasil Dihapus');

      return redirect()->route('admin.tahun_akademik.trash');
  }
}
