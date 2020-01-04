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

use App\InfoWeb;
use App\FotoPendukung;
use App\KategoriInfo;

class InfoWebController extends Controller
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
          $info = InfoWeb::where('is_delete', 'Y')->get();
      }
      else
      {
          $info = InfoWeb::where('is_delete', 'N')->get();
      }
      foreach ($info as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus Informasi ".$list->judul_info."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen Informasi ".$list->judul_info."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data Informasi ".$list->judul_info."'";

          $row 						= array();
          $row['no'] 			 	= $no;
          $row['id_info'] 		 	= $list->id_info;
          $row['judul_info'] 	 	= $list->judul_info;
          $row['waktu_info'] 	 	= $list->waktu_info;
          $row['ringkasan_info'] 	= $list->ringkasan_info;
          $row['isi_info'] 		 	= $list->isi_info;
          $row['foto_info'] 		= $list->foto_info;
          $row['sumber_info'] 	 	= $list->sumber_info;
          $row['id_kategori_info'] 	= $list->id_kategori_info;

          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.info.restore', $list->id_info).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.info.hapus.permanent', $list->id_info).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.info.detail', $list->id_info).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>
              <a href="'.route('admin.info.ubah', $list->id_info).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.info.hapus', $list->id_info).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }

  public function trash()
  {
      return view('pages.admin.info.trash');
  }


  public function tambah()
  {
  	 $kategori = KategoriInfo::pluck('kategori_info', 'id_kategori_info');
      return view('pages.admin.info.tambah', compact('kategori'));
  }

  public function simpan(Request $request)
  {
      $input = $request->all();

      $foto_info = count($request->foto_info);
      
    //cek foto dan upload
    if ($request->hasFile('foto_utama')) {
        $files = $request->foto_utama;
        $input['foto_utama'] = $this->uploadFoto($files);
    }

      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      $input['waktu_info'] = NOW();
      $info = InfoWeb::create($input);
      $data_files = array();
      //cek foto dan upload
    if ($request->hasFile('foto_info')) {

       foreach( $request->foto_info as $fileS)
       {
            $data_files[] = [
                'id_info' => $info->id_info,
                'nama_foto' => $this->uploadFoto($fileS),
                'tanggal_upload' => date('Y-m-d H:i:s')
            ];
       }

    }

    $upload = FotoPendukung::insert($data_files);

      Session::flash('success', 'Info Berhasil Ditambahkan');

      return redirect()->route('admin.info');
  }


    public function detail($id)
    {

        $info = InfoWeb::find($id);

        return view('pages.admin.info.detail', compact('info'));

    }

    

  public function toTrash($id)
  {
      InfoWeb::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data Informasi Berhasil Dihapus.');

      return redirect()->route('admin.info');
  }

  public function restore($id)
  {
      InfoWeb::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data Informasi Berhasil Dikembalikan.');

      return redirect()->route('admin.info.trash');
  }

  public function hapus($id)
  {
      $info = InfoWeb::find($id);
      $info->delete();

      Session::flash('success', 'Data Informasi Berhasil Dihapus');

      return redirect()->route('admin.info.trash');
  }

  public function ubah($id)
  {
      $info = InfoWeb::find($id);
      $kategori = KategoriInfo::pluck('kategori_info', 'id_kategori_info');
      return view('pages.admin.info.ubah', compact('info', 'kategori', 'id'));
  }

  public function perbarui($id, Request $request)
  {
      $info = InfoWeb::find($id);
      $input = $request->all();

      //cek foto baru yg di lempar dari form
      if ($request->hasFile('foto_info')) {
      //Hapus Fto Lama jika ada foto baru
        
      
      //Upload Foto Baru
        $input['foto_info'] = $this->uploadFoto($request);
      }

      $input['update_by'] = Auth::guard('admin')->user()->nama;
      $input['update_date'] = date('Y-m-d H:i:s');
      $info->update($input);
      Session::flash('success', 'Data Informasi Berhasil Diperbarui.');

      return redirect()->route('admin.info');
  }

  private function uploadFoto($files) 
    {
        $foto = $files;
        $filename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
        $ext  = $foto->getClientOriginalExtension();

        if($foto->isValid()) {
                $foto_name      = $filename.'-'.date('YmdHis').'.'.$ext;
                $upload_path    = 'images/info';
                $foto->move($upload_path, $foto_name);
                

            return $foto_name;
        }else{
            return false;
        }

    }
}
