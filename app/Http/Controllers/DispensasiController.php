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


use App\Dispensasi;
use App\Pendaftaran;
use App\PendaftaranPembayaran;
use App\KategoriPembayaran;
use App\tahun_akademik;

class DispensasiController extends Controller
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
          $dispensasi = Dispensasi::leftjoin('tbl_daftar', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')->where('tbl_dispensasi.jenis_pembayaran', 'Pembayaran Kelulusan')->where('tbl_dispensasi.is_delete', 'Y')
                                    ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar.id_daftar', 'tbl_daftar_pembayaran.id_daftar')->get();
      }
      else
      {
          $dispensasi = Dispensasi::leftjoin('tbl_daftar', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')->where('tbl_dispensasi.jenis_pembayaran', 'Pembayaran Kelulusan')->where('tbl_dispensasi.is_delete', 'N')
                                    ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar.id_daftar', 'tbl_daftar_pembayaran.id_daftar')->get();
      }

      foreach ($dispensasi as $list)
      {
          $toTrash = "'Anda Yakin Akan Menghapus Dispensasi ".$list->nama."'";
          $hapus = "'Anda Yakin Akan Menghapus Permanen Dispensasi ".$list->nama."'";
          $restore = "'Anda Yakin Akan Mengembalikan Data Dispensasi ".$list->nama."'";

          $row 						    = array();
          $row['no'] 			 	    = $no;
          $row['id_daftar'] 		 	= $list->id_daftar;
          $row['nama'] 		 	        = $list->nama;
          $row['jenis_pembayaran']  	= $list->jenis_pembayaran;
          $row['tanggal_akan_bayar']    = date('d-M-Y', strtotime($list->tanggal_akan_bayar));
          $row['nominal_akan_bayar']    = $list->nominal_akan_bayar;
          $row['status']    = $list->status;

          if(!empty($req->segment(4)))
          {
              $row['aksi'] =
              '<a href="'.route('admin.dispensasi.restore', $list->id_dispensasi).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
              <a href="'.route( 'admin.dispensasi.hapus.permanent', $list->id_dispensasi).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
          }
          else
          {
              $row['aksi'] =
              '
              <a href="'.route('admin.dispensasi.detail', $list->id_dispensasi).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>
              <a href="'.route('admin.dispensasi.print', $list->id_dispensasi).'" target="_blank"  class="btn btn-primary btn-sm" title="Print"><i class="fa fa-print"  ></i></a>
              <a href="'.route('admin.dispensasi.ubah', [$list->id_daftar, $list->id_daftar_pembayaran]).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
              <a href="'.route('admin.dispensasi.hapus', $list->id_dispensasi).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
          }

          $data[] = $row;
          $no++;
      }
      return DataTables::of($data)->escapeColumns([])->make(true);
  }

   public function index()
  {
      return view('pages.admin.dispensasi.index');
  }

    public function print_all()
  {

    $dispensasi = Dispensasi::leftjoin('tbl_daftar', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')->where('tbl_dispensasi.is_delete', 'N')->get();

      return view('pages.admin.dispensasi.print.all_print', compact('dispensasi'));
  }



  public function trash()
  {
      return view('pages.admin.dispensasi.trash');
  }


  public function tambah()
  {
  	 $kategori = Kategoridispensasi::pluck('kategori_dispensasi', 'id_kategori_dispensasi');
      return view('pages.admin.dispensasi.tambah', compact('kategori'));
  }

  public function simpan(Request $request)
  {
      $input = $request->all();

      //cek foto dan upload
    if ($request->hasFile('foto_dispensasi')) {
      $input['foto_dispensasi'] = $this->uploadFoto($request);
    }

      $input['create_by'] = Auth::guard('admin')->user()->nama;
      $input['create_date'] = date('Y-m-d H:i:s');
      $input['waktu_dispensasi'] = NOW();
      Dispensasi::create($input);
      Session::flash('success', 'dispensasi Berhasil Ditambahkan');

      return redirect()->route('admin.dispensasi');
  }


    public function detail($id)
    {

        $dispensasi = Dispensasi::leftjoin('tbl_daftar', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')
                    ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
                    ->find($id);

        return view('pages.admin.dispensasi.detail', compact('dispensasi'));

    }


     public function print($id)
    {

        $dispensasi = Dispensasi::leftjoin('tbl_daftar', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')
                    ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
                    ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik' )
                    ->find($id);

        $petugas = Auth::guard('admin')->user()->nama;

        return view('pages.admin.dispensasi.print.detail_print', compact('dispensasi', 'petugas'));

    }

    

  public function toTrash($id)
  {
      Dispensasi::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

      Session::flash('fail', 'Data dispensasirmasi Berhasil Dihapus.');

      return redirect()->route('admin.dispensasi');
  }

  public function restore($id)
  {
      Dispensasi::find($id)->update(['is_delete' => 'N']);

      Session::flash('success', 'Data dispensasirmasi Berhasil Dikembalikan.');

      return redirect()->route('admin.dispensasi.trash');
  }

  public function hapus($id)
  {
      $dispensasi = Dispensasi::find($id);
      $dispensasi->delete();

      Session::flash('success', 'Data dispensasirmasi Berhasil Dihapus');

      return redirect()->route('admin.dispensasi.trash');
  }

  public function ubah($id, $dp) {

          $daftar = Pendaftaran::select([ 
            'tbl_daftar_pembayaran_detail.*',
            'tbl_daftar_pembayaran.*',
            'tbl_daftar.*',
            'tbl_dispensasi.*',
            'tbl_daftar_nilai.*',
            'tbl_daftar_kategori.*',
            'm_promo.*',
            't_tahun_akademik.*',
            'tbl_provinsi.*',
            'tbl_prodi.*',
            'tbl_waktu_kuliah.*',
            'tbl_jenjang.*',
            DB::raw("(SELECT SUM(bayar_kelulusan) FROM tbl_daftar_pembayaran_detail  WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = tbl_daftar_pembayaran_detail.id_daftar_pembayaran  ) AS jmlh")
             ])
            ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_nilai', 'tbl_daftar_nilai.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
            ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
            ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
            ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
            ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')
             ->leftjoin('tbl_provinsi', 'tbl_daftar.id_provinsi', 'tbl_provinsi.id_provinsi')
             ->leftjoin('tbl_jenjang', 'tbl_daftar.id_jenjang', 'tbl_jenjang.id_jenjang')
             ->leftjoin('tbl_dispensasi', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')
            ->find($id);

            

             $i = DB::select(DB::raw("SELECT pembayaran_ke FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = '$dp' ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));

            foreach( $i as $ipeke) {

                $ipeke->pembayaran_ke + 1;
            }

            if (!empty($ipeke->pembayaran_ke)) {
                $ke = $ipeke->pembayaran_ke + 1;
            }else{
                $ke = $daftar->pembayaran_ke + 1;
            }
               
             
            
       if (!empty($daftar->potongan))

            {

               
                $biaya = ($daftar->biaya - $daftar->potongan) - $daftar->diskon;

            }

            else

            {

                $biaya = $daftar->biaya - $daftar->diskon;

            }
            
            
            $jmlh = $daftar->jmlh;
            
            $bayar = $biaya - $jmlh ;
        

        $kategori = $daftar->kode_kategori.'-'.$daftar->nama_kategori;




         return view('pages.admin.dispensasi.form', compact('daftar', 'id', 'dp', 'jmlh', 'bayar', 'ke', 'kategori', 'biaya'));

    }

  public function perbarui($id, $dp, Request $req)
    {
        
        $calon = Pendaftaran::select([ 
            'tbl_daftar_pembayaran_detail.*',
            'tbl_daftar_pembayaran.*',
            'tbl_daftar.*',
            'tbl_dispensasi.*',
            'tbl_daftar_nilai.*',
            'tbl_daftar_kategori.*',
            'm_promo.*',
            't_tahun_akademik.*',
            'tbl_provinsi.*',
            'tbl_prodi.*',
            'tbl_waktu_kuliah.*',
            'tbl_jenjang.*',
            DB::raw("(SELECT SUM(bayar_kelulusan) FROM tbl_daftar_pembayaran_detail  WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = tbl_daftar_pembayaran_detail.id_daftar_pembayaran  ) AS jmlh")
            ])
            ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_nilai', 'tbl_daftar_nilai.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
            ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
            ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
            ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
            ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->leftjoin('tbl_provinsi', 'tbl_daftar.id_provinsi', 'tbl_provinsi.id_provinsi')
            ->leftjoin('tbl_jenjang', 'tbl_daftar.id_jenjang', 'tbl_jenjang.id_jenjang')
            ->leftjoin('tbl_dispensasi', 'tbl_dispensasi.id_daftar', 'tbl_daftar.id_daftar')
            ->find($id);




                if (!empty($calon->potongan))

                {

                
                    $biaya = ($calon->biaya - $calon->potongan) - $calon->diskon;

                }

                else

                {

                    $biaya = $calon->biaya - $calon->diskon;

                }
                
                
                $jmlh = $calon->jmlh;
                
                $bayar = $biaya - $jmlh ;

                

            if(str_replace(',', '', $req->nominal_akan_bayar) > $bayar)

            {

                Session::flash('fail', 'Pembayaran Lebih Dari Biaya Seharusnya');



                return redirect()->back()->withInput($req->all());

            }

            else

            {
                
                $tanggal_akan_bayar = date('Y-m-d', strtotime($req->tanggal_akan_bayar));
                

                PendaftaranPembayaran::where('id_daftar', $id)->update(['status_pembayaran' => 'Dispensasi']);

                Dispensasi::where('id_daftar', $id)->update(['id_daftar' => $id, 'tanggal_akan_bayar' => $tanggal_akan_bayar, 'nominal_akan_bayar' => $req->nominal_akan_bayar, 'jenis_pembayaran' => 'Pembayaran Kelulusan', 'created_by' => Auth::guard('admin')->user()->nama, 'created_date' =>  date('Y-m-d H:i:s') ]);


                Session::flash('success', 'Berhasil Melakukan Dispensasi');



                return redirect()->route('admin.dispensasi');

            }
    }
}
