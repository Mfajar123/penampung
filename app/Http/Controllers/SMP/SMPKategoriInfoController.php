<?php

namespace App\Http\Controllers\SMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use File;
use Auth;
use Session;
use DB;
use DataTables;

use App\SMPKategoriInfo;

class SMPKategoriInfoController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin_smp');
  }
  public function datatable(Request $req)
  {
      $data = array();
      $no = 1;

      if(!empty($req->segment(4)))
      {
          $kategori_info = SMPKategoriInfo::where('is_delete', 'Y')->get();
      }
      else
      {
          $kategori_info = SMPKategoriInfo::where('is_delete', 'N')->get();
      }
      foreach ($kategori_info as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus Kategori ".$list->kategori_info."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen Kategori ".$list->kategori_info."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data Kategori ".$list->kategori_info."'";

          $row = array();
          $row['no'] = $no;
          $row['id_kategori_info'] = $list->id_kategori_info;
          $row['kategori_info'] = $list->kategori_info;
          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('smp.admin.kategori_info.restore', $list->id_kategori_info).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'smp.admin.kategori_info.hapus.permanent', $list->id_kategori_info).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('smp.admin.kategori_info.ubah', $list->id_kategori_info).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('smp.admin.kategori_info.hapus', $list->id_kategori_info).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }
  public function trash()
  {
      return view('pages.smp.admin.kategori_info.trash');
  }
  public function tambah()
  {
      return view('pages.smp.admin.kategori_info.tambah');
  }
  public function simpan(Request $request)
  {
      $input = $request->all();
      $input['create_by'] = Auth::guard('admin_smp')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      SMPKategoriInfo::create($input);
      Session::flash('success', 'Kategori Informasi Berhasil Ditambahkan');

      return redirect()->route('smp.admin.kategori_info');
  }
  public function toTrash($id)
  {
      SMPKategoriInfo::find($id)->update(['delete_by' => Auth::guard('admin_smp')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data Kategori Informasi Berhasil Dihapus.');

      return redirect()->route('smp.admin.kategori_info');
  }
  public function restore($id)
  {
      SMPKategoriInfo::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data Kategori Informasi Berhasil Dikembalikan.');

      return redirect()->route('smp.admin.kategori_info.trash');
  }
  public function hapus($id)
  {
      $kategori_info = SMPKategoriInfo::find($id);

      $kategori_info->delete();

      Session::flash('success', 'Data Kategori Informasi Berhasil Dihapus');

      return redirect()->route('smp.admin.kategori_info.trash');
  }
  public function ubah($id)
  {
      $kategori_info = SMPKategoriInfo::find($id);
      return view('pages.smp.admin.kategori_info.ubah', compact('kategori_info', 'id'));
  }
  public function perbarui($id, Request $request)
  {
      $kategori_info = SMPKategoriInfo::find($id);
      $input = $request->all();
      $input['update_by'] = Auth::guard('admin_smp')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $kategori_info->update($input);
      Session::flash('success', 'Data Kategori Informasi Berhasil Diperbarui.');

      return redirect()->route('smp.admin.kategori_info');
  }
}
