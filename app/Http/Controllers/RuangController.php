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

use App\Ruang;

class RuangController extends Controller
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
          $ruang = Ruang::where('is_delete', 'Y')->get();
      }
      else
      {
          $ruang = Ruang::where('is_delete', 'N')->get();
      }
      foreach ($ruang as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus ruang ".$list->nama_ruang."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen ruang ".$list->nama_ruang."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data ruang ".$list->nama_ruang."'";

          $row = array();
          $row['no'] = $no;
          $row['kode_ruang'] = $list->kode_ruang;
          $row['nama_ruang'] = $list->nama_ruang;
          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.ruang.restore', $list->id_ruang).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.ruang.hapus.permanent', $list->id_ruang).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.ruang.ubah', $list->id_ruang).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.ruang.hapus', $list->id_ruang).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }
  public function trash()
  {
      return view('pages.admin.ruang.trash');
  }
  public function tambah()
  {
      return view('pages.admin.ruang.tambah');
  }
  public function simpan(Request $request)
  {
      $input = $request->all();
      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      Ruang::create($input);
      Session::flash('success', 'Ruang Berhasil Ditambahkan');

      return redirect()->route('admin.ruang');
  }
  public function toTrash($id)
  {
      Ruang::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data Ruang Berhasil Dihapus.');

      return redirect()->route('admin.ruang');
  }
  public function restore($id)
  {
      Ruang::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data Ruang Berhasil Dikembalikan.');

      return redirect()->route('admin.ruang.trash');
  }
  public function hapus($id)
  {
      $ruang = Ruang::find($id);

      $ruang->delete();

      Session::flash('success', 'Data Ruang Berhasil Dihapus');

      return redirect()->route('admin.ruang.trash');
  }
  public function ubah($id)
  {
      $ruang = Ruang::find($id);
      return view('pages.admin.ruang.ubah', compact('ruang', 'id'));
  }
  public function perbarui($id, Request $request)
  {
      $ruang = Ruang::find($id);
      $input = $request->all();
      $input['update_by'] = Auth::guard('admin')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $ruang->update($input);
      Session::flash('success', 'Data Ruang Berhasil Diperbarui.');

      return redirect()->route('admin.ruang');
  }
}
