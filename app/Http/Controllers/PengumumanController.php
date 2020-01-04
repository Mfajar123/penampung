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

use App\Pengumuman;

class PengumumanController extends Controller
{
 

   public function mahasiswa($pengumuman = null, Request $req)
  {
    if(!empty($req->search))
    {
        $pengumuman = Pengumuman::where('is_delete', 'N')
                    ->where('umumkan_ke', '!=', 'Dosen')
                    ->where('judul_pengumuman', 'LIKE', '%'.$req->search.'%')
                    ->orderBy('waktu_pengumuman', 'DESC')
                    ->get();
    }
    else
    {

      $pengumuman = Pengumuman::where('is_delete', 'N')->where('umumkan_ke', '!=', 'Dosen')->orderBy('waktu_pengumuman', 'DESC')->get();

    }
    
    return view('pages.mahasiswa.pengumuman.pengumuman', compact('pengumuman'));
  }

   public function dosen($pengumuman = null, Request $req)
  {
    if(!empty($req->search))
    {
      $pengumuman = Pengumuman::where('is_delete', 'N')
                    ->where('umumkan_ke', '!=', 'Mahasiswa')
                    ->where('judul_pengumuman', 'LIKE', '%'.$req->search.'%')
                    ->orderBy('waktu_pengumuman', 'DESC')
                    ->get();
      $search = $req->search;
    }
    else{ 
      $pengumuman = Pengumuman::where('is_delete', 'N')->where('umumkan_ke', '!=', 'Mahasiswa')->orderBy('waktu_pengumuman', 'DESC')->get();
    }

    return view('pages.dosen.pengumuman.pengumuman', compact('pengumuman'));
  }


  public function datatable(Request $req)
  {
      $data = array();
      $no = 1;

      if(!empty($req->segment(4)))
      {
          $pengumuman = Pengumuman::where('is_delete', 'Y')->get();
      }
      else
      {
          $pengumuman = Pengumuman::where('is_delete', 'N')->get();
      }
      foreach ($pengumuman as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus pengumuman ".$list->judul_pengumuman."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen pengumuman ".$list->judul_pengumuman."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data pengumuman ".$list->judul_pengumuman."'";

          $row 						= array();
          $row['no'] 			 	= $no;
          $row['id_pengumuman'] 		 	= $list->id_pengumuman;
          $row['judul_pengumuman'] 	 	= $list->judul_pengumuman;
          $row['waktu_pengumuman'] 	 	= $list->waktu_pengumuman;
          $row['ringkasan_pengumuman']= $list->ringkasan_pengumaman;
          $row['isi_pengumuman'] 		 	= $list->isi_pengumuman;
          $row['foto_pengumuman'] 		= $list->foto_pengumuman;
          $row['sumber_pengumuman'] 	= $list->sumber_pengumuman;
          $row['umumkan_ke']          = $list->umumkan_ke;


          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.pengumuman.restore', $list->id_pengumuman).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.pengumuman.hapus.permanent', $list->id_pengumuman).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.pengumuman.detail', $list->id_pengumuman).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>
              <a href="'.route('admin.pengumuman.ubah', $list->id_pengumuman).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.pengumuman.hapus', $list->id_pengumuman).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }

  public function trash()
  {
      return view('pages.admin.pengumuman.trash');
  }


  public function tambah()
  {
  	 
      return view('pages.admin.pengumuman.tambah');
  }

  public function simpan(Request $request)
  {
      $input = $request->all();

      //cek foto dan upload
    if ($request->hasFile('foto_pengumuman')) {
      $input['foto_pengumuman'] = $this->uploadFoto($request);
    }

      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      $input['waktu_pengumuman'] = NOW();
      Pengumuman::create($input);
      Session::flash('success', 'pengumuman Berhasil Ditambahkan');

      return redirect()->route('admin.pengumuman');
  }


    public function detail($id)
    {

        $pengumuman = Pengumuman::find($id);

        return view('pages.admin.pengumuman.detail', compact('pengumuman'));

    }

    

  public function toTrash($id)
  {
      Pengumuman::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data pengumumanrmasi Berhasil Dihapus.');

      return redirect()->route('admin.pengumuman');
  }

  public function restore($id)
  {
      Pengumuman::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data pengumumanrmasi Berhasil Dikembalikan.');

      return redirect()->route('admin.pengumuman.trash');
  }

  public function hapus($id)
  {
      $pengumuman = Pengumuman::find($id);
      $pengumuman->delete();

      Session::flash('success', 'Data pengumumanrmasi Berhasil Dihapus');

      return redirect()->route('admin.pengumuman.trash');
  }

  public function ubah($id)
  {
      $pengumuman = Pengumuman::find($id);
      return view('pages.admin.pengumuman.ubah', compact('pengumuman','id'));
  }

  public function perbarui($id, Request $request)
  {
      $pengumuman = Pengumuman::find($id);
      $input = $request->all();

      //cek foto baru yg di lempar dari form
      if ($request->hasFile('foto_pengumuman')) {
      //Hapus Fto Lama jika ada foto baru
        
      
      //Upload Foto Baru
        $input['foto_pengumuman'] = $this->uploadFoto($request);
      }

      $input['update_by'] = Auth::guard('admin')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $pengumuman->update($input);
      Session::flash('success', 'Data pengumumanrmasi Berhasil Diperbarui.');

      return redirect()->route('admin.pengumuman');
  }

  private function uploadFoto(Request $request) 
    {
        $foto = $request->file('foto_pengumuman');
        $ext  = $foto ->getClientOriginalExtension();

        if($request->file('foto_pengumuman')->isValid()) {
                $foto_name      = date('YmdHis').'_pengumuman'.".$ext";
                $upload_path    = 'images/pengumuman';
                $request->file('foto_pengumuman')->move($upload_path, $foto_name);
                $input['foto']  = $foto_name;

            return $foto_name;
        }

        return false;
    }
}
