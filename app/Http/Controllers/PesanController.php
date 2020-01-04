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
use Storage;

use App\Pesan;

class PesanController extends Controller
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
          $pesan = Pesan::where('is_delete', 'Y')->get();
      }
      else
      {
          $pesan = Pesan::where('is_delete', 'N')->get();
      }
      foreach ($pesan as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus Pesan Dari ".$list->nama."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen Pesan Dari ".$list->nama."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data Pesan Dari ".$list->nama."'";

          $row 						= array();
          $row['no'] 			 	= $no;
          $row['id_pesan'] 		 	= $list->id_pesan;
          $row['nama'] 	 			= $list->nama;
          $row['email'] 	 		= $list->email;
          $row['no_telp'] 			= $list->no_telp;
          $row['subjek'] 		 	= $list->subjek;
          $row['pesan'] 			= $list->pesan;

          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.pesan.restore', $list->id_pesan).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.pesan.hapus.permanent', $list->id_pesan).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.pesan.detail', $list->id_pesan).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>
            
              <a href="'.route('admin.pesan.hapus', $list->id_pesan).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }

  public function trash()
  {
      return view('pages.admin.pesan.trash');
  }


 


    public function detail($id)
    {

        $pesan = Pesan::find($id);

        return view('pages.admin.pesan.detail', compact('pesan'));

    }

    

  public function toTrash($id)
  {
      Pesan::find($id)->update(['deleted_by' => Auth::guard('admin')->user()->nama, 'deleted_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data Pesan Berhasil Dihapus.');

      return redirect()->route('admin.pesan');
  }

  public function restore($id)
  {
      Pesan::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data Pesan Berhasil Dikembalikan.');

      return redirect()->route('admin.pesan.trash');
  }

  public function hapus($id)
  {
      $pesan = Pesan::find($id);
      $pesan->delete();

      Session::flash('success', 'Data Pesan Berhasil Dihapus');

      return redirect()->route('admin.pesan.trash');
  }

}
