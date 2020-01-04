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

use App\Promo;

class PromoController extends Controller
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
          $promo = Promo::where('is_delete', 'Y')->get();
      }
      else
      {
          $promo = Promo::where('is_delete', 'N')->get();
      }
      foreach ($promo as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus promo ".$list->nama_promo."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen promo ".$list->nama_promo."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data promo ".$list->nama_promo."'";

          $row = array();
          $row['no'] = $no;
          $row['nama_promo'] = $list->nama_promo;
          $row['diskon'] = $list->diskon;
          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.promo.restore', $list->id_promo).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.promo.hapus.permanent', $list->id_promo).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.promo.ubah', $list->id_promo).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.promo.hapus', $list->id_promo).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }

  public function trash()
  {
      return view('pages.admin.promo.trash');
  }

  public function tambah()
  {
      return view('pages.admin.promo.tambah');
  }

  public function simpan(Request $req)
  {
      $input = $req->all();
      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      Promo::create($input);
      Session::flash('success', 'Promo Berhasil Ditambahkan');
      return redirect()->route('admin.promo');
  }

  public function ubah($id)
  {
      $promo = Promo::find($id);

      return view('pages.admin.promo.ubah', compact('id', 'promo'));
  }

  public function perbarui($id, Request $req)
  {
      $promo = Promo::find($id);
      $input = $req->all();
      $input['update_by'] = Auth::guard('admin')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $promo->update($input);
      Session::flash('success', 'Data Promo Berhasil Diperbarui.');
      return redirect()->route('admin.promo');
  }

  public function toTrash($id)
  {
      Promo::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data Promo Berhasil Dihapus.');

      return redirect()->route('admin.promo');
  }

  public function restore($id)
  {
      Promo::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data Promo Berhasil Dikembalikan.');

      return redirect()->route('admin.promo.trash');
  }

  public function hapus($id)
  {
      Promo::find($id)->delete();

      Session::flash('success', 'Mata Promo Berhasil Dihapus');

      return redirect()->route('admin.promo');
  }


}
