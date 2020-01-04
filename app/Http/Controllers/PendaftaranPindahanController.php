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

use App\Pendaftaran;
use App\PendaftaranNilai;

use App\WaktuKuliah;
use App\TahunAkademik;
use App\Promo;
use App\Prodi;
use App\Jenjang;
use App\Semester;
use App\Provinsi;
use App\MahasiswaStatus;

use App\BiayaPindahan;

class PendaftaranPindahanController extends Controller
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
            $mahasiswa = Pendaftaran::where('is_delete', 'Y')->orderBy('created_at', 'DESC')->get();
        }
        else
        {
            $mahasiswa = Pendaftaran::leftjoin('tbl_mahasiswa_status', 'tbl_daftar.id_status', 'tbl_mahasiswa_status.id_status')->where('is_delete', 'N')->where('tbl_daftar.id_status', '6')->orderBy('created_at', 'DESC');

            if (! empty($req->tahun_akademik))
            {
                $mahasiswa = $mahasiswa->where('tbl_daftar.tahun_akademik', $req->tahun_akademik);
            }
    
             if (! empty($req->id_prodi))
            {
                $mahasiswa = $mahasiswa->where('tbl_daftar.id_prodi', $req->id_prodi);
            }
    
             $mahasiswa = $mahasiswa->get();
        }
        
        
        foreach ($mahasiswa as $list)
        {
            $toTrash = "'Anda Yakin Akan Menghapus ".$list->nama."'";
            $hapusPermanen = "'Anda Yakin Akan Menghapus Permanen ".$list->nama."'";
            $restore = "'Anda Yakin Akan Memulihkan ".$list->nama."'";
            
            if($list->status_bayar == 'Lunas')
            {
                $status = '<strong class="text-success">'.$list->status_bayar.'</strong>';
                $bayar = '<a href="#" disabled class="btn btn-info btn-sm" title="Pembayaran"><i class="fa fa-money"></i></a>';
                //$ubah = '<a href="#" class="btn btn-warning btn-sm" title="Ubah" disabled><i class="fa fa-edit"></i></a>';
                // $bayar = '<a href="'.route('admin.daftar.pindahan.pembayaran', $list->id_daftar).'" class="btn btn-info btn-sm" title="Pembayaran"><i class="fa fa-money"></i></a>';
                $ubah = '<a href="'.route('admin.daftar.pindahan.ubah', $list->id_daftar).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>';
                $hapus = '<a href="#" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')" disabled><i class="fa fa-trash-o"></i></a>';
                $print = '<a href="'.route('admin.daftar.pindahan.print', $list->id_daftar).'" class="btn btn-default btn-sm" target="_blank" title="Print" ><i class="fa fa-print"></i></a>';
            }
            else
            {
                $status = '<strong class="text-danger">'.$list->status_bayar.'</strong>';
                $bayar = '<a href="'.route('admin.daftar.pindahan.pembayaran', $list->id_daftar).'" class="btn btn-info btn-sm" title="Pembayaran"><i class="fa fa-money"></i></a>';
                $ubah = '<a href="'.route('admin.daftar.pindahan.ubah', $list->id_daftar).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>';
                $hapus = '<a href="'.route('admin.daftar.pindahan.hapus', $list->id_daftar).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
                $print = '<a href="#" class="btn btn-default btn-sm"  title="Print" disabled ><i class="fa fa-print"></i></a>';
            }

            $row = array();
            $row['no'] = $no;
            $row['id_daftar'] = $list->id_daftar;
            $row['akademik'] = $list->tahun_akademik;
            $row['nama'] = $list->nama;
            $row['status'] = $list->nama_status;
            $row['prodi'] = $list->prodi->nama_prodi;
            $row['status_pembayaran'] = $status;
            if(!empty($req->segment(4)))
            {
                $row['aksi'] =
                '<a href="'.route('admin.daftar.pindahan.restore', $list->id_daftar).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')"><i class="fa fa-mail-reply"></i></a>
                <a href="'.route( 'admin.daftar.pindahan.hapus.permanen', $list->id_daftar).'" class="btn btn-danger btn-sm" title="Hapus Permanen" onclick="return confirm('.$hapusPermanen.')"><i class="fa fa-trash-o"></i></a>';
            }
            else
            {
                $row['aksi'] =
                $bayar.' '.$ubah.' '.$hapus.' '.$print;
            }

            $data[] = $row;
            $no++;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }
    
    public function index() { 

        $list_tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        $list_prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');

        $list_tahun_akademik->prepend('- Semua -', '');

        $list_prodi->prepend('- Semua -', '');

        return view('pages.admin.mahasiswa.pindahan.daftar.index', compact('list_tahun_akademik', 'list_prodi'));

    }



    public function trash()
    {
        return view('pages.admin.mahasiswa.pindahan.daftar.trash');
    }

    public function tambah()
    {
        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        $jenjang = Jenjang::pluck('nama_jenjang', 'id_jenjang');
        $promo = Promo::where('is_delete', 'N')->pluck('nama_promo', 'id_promo');
        $waktu = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');
        $provinsi = Provinsi::pluck('nama_provinsi', 'id_provinsi');
        $akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $status = MahasiswaStatus::orderBy('nama_status', 'DESC')->pluck('nama_status', 'id_status');

        return view('pages.admin.mahasiswa.pindahan.daftar.tambah', compact('prodi', 'status', 'waktu', 'provinsi', 'akademik', 'jenjang', 'promo'));
    }

    public function simpan(Request $req)
    {
        $system = new SystemController();
        $input = $req->all();

        if(empty($req->nama))
        {
            Session::flash('fail', 'Nama Harus Diisi !');

            return redirect()->back()->withInput($req->all());
        }
        else
        {
            $daftar = Pendaftaran::where(['id_waktu_kuliah' => $req->id_waktu_kuliah])->orderBy('created_at', 'DESC')->first();
            if(empty($daftar))
            {
                $id = substr($req->tahun_akademik, 2, 2).$req->id_waktu_kuliah.'00001';
            }
            else
            {
                if(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 1)
                {
                    $num = '0000';
                }
                elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 2)
                {
                    $num = '000';
                }
                elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 3)
                {
                    $num = '00';
                }
                elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 4)
                {
                    $num = '0';
                }
                elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 5)
                {
                    $num = '';
                }

                $hasil = substr($req->tahun_akademik, 2, 2).$req->id_waktu_kuliah.$num.intval(substr($daftar->id_daftar, 3, 5))+1;
                $cek_id = Pendaftaran::where(['id_daftar' => $hasil])->count();
                if ($cek_id = 1){
                    $id = substr($req->tahun_akademik, 2, 2).$req->id_waktu_kuliah.$num.intval(substr($daftar->id_daftar, 3, 5))+2;
                }else{
                    $id = $hasil;
                }
            }

            $input['id_daftar'] = $id;
            $input['status_bayar'] = 'Belum Bayar';
            $input['created_by'] = Auth::guard('admin')->user()->nama;
           
           if($req->id_status == 2)
            {
                PendaftaranNilai::create(['id_daftar' => $id]);
            }
            elseif($req->id_status == 6)
            {
                // if( BiayaPindahan::where('nama_biaya', 'Biaya Masuk')->count() > 0)
                $pindahan = BiayaPindahan::where('tahun_akademik', $req->tahun_akademik)->first();
                if(! empty($pindahan))
                {
                    DB::table('tbl_daftar_pindahan_pembayaran')->insert(['id_daftar' => $id, 'id_biaya' => $pindahan->id_biaya]);
                }
                else
                {
                    Session::flash('fail', 'Pembayaran Biaya Masuk Tidak Ada');

                    return redirect()->back()->withInput($req->all());
                }
                
                if(!empty($req->transkrip))
                {
                    $foto = $req->file('transkrip');

                    $fname = 'Transkrip#'.$id.'_'.$req->nama.'.'.$foto->getClientOriginalExtension();
                    $input['transkrip'] = $fname;

                    $foto->move('images/mahasiswa/transkrip/', $fname);
                }
            }
            Pendaftaran::create($input);

            Session::flash('success', $req->nama.' Berhasil Didaftarkan');

            return redirect()->route('admin.daftar.pindahan');
        }
    }

    public function ubah($id)
    {
        $daftar = Pendaftaran::find($id);

        $prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');
        $jenjang = Jenjang::pluck('nama_jenjang', 'id_jenjang');
        $promo = Promo::where('is_delete', 'N')->pluck('nama_promo', 'id_promo');
        $waktu = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');
        $provinsi = Provinsi::pluck('nama_provinsi', 'id_provinsi');
        $akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $status = MahasiswaStatus::orderBy('nama_status', 'DESC')->pluck('nama_status', 'id_status');

        return view('pages.admin.mahasiswa.pindahan.daftar.ubah', compact('prodi', 'status', 'waktu', 'provinsi', 'akademik', 'jenjang', 'promo', 'daftar', 'id'));
    }

    public function perbarui($id, Request $request)
    {
        $daftar = Pendaftaran::find($id);
        $input = $request->all();

        // if($request->id_tahun_akademik == $daftar->id_tahun_akademik && $request->id_waktu_kuliah == $daftar->id_waktu_kuliah)
        // {
        //     $id_daftar = $daftar->id_daftar;
        // }
        // else
        // {
        //     $daftar_ = Pendaftaran::where(['id_waktu_kuliah' => $request->id_waktu_kuliah])->orderBy('created_at', 'DESC')->first();
        //     //$akademik = TahunAkademik::where('id_waktu_kuliah', $request->id_waktu_kuliah)->first();
        //     if(empty($daftar))
        //     {
        //         $id_daftar = substr($req->tahun_akademik, 2, 2).$request->id_waktu_kuliah.'00001';
        //     }
        //     else
        //     {
        //         if(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 1)
        //         {
        //             $num = '0000';
        //         }
        //         elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 2)
        //         {
        //             $num = '000';
        //         }
        //         elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 3)
        //         {
        //             $num = '00';
        //         }
        //         elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 4)
        //         {
        //             $num = '0';
        //         }
        //         elseif(strlen(intval(substr($daftar->id_daftar, 3, 5))) == 5)
        //         {
        //             $num = '';
        //         }

        //         $id_daftar = substr($req->tahun_akademik, 2, 2).$request->id_waktu_kuliah.$num.intval(substr($daftar->id_daftar, 3, 5))+1;
        //     }
        // }

        // $input['id_daftar'] = $id_daftar;
        // $input['updated_by'] = Auth::guard('admin')->user()->nama;

        
        // if($request->id_status == 6)
        // {
        //     if(!empty($request->transkrip))
        //     {
        //         File::delete('images/mahasiswa/transkrip/'.$daftar->transkrip);

        //         $foto = $request->file('transkrip');

        //         $fname = 'Transkrip#'.$id.'_'.$request->nama.'.'.$foto->getClientOriginalExtension();
        //         $input['transkrip'] = $fname;

        //         $foto->move('images/mahasiswa/transkrip/', $fname);
        //     }
        // }

        // if($request->id_status == 2)
        // {
        //     PendaftaranNilai::where('id_daftar', $id)->update(['id_daftar' => $id_daftar]);
        // }
        
        $daftar->update($input);

        Session::flash('success', 'Data '.$request->nama.' Berhasil Diubah');

        return redirect()->route('admin.daftar.pindahan');
    }

    public function toTrash($id)
    {
        $daftar = Pendaftaran::find($id);
        $daftar->update(['is_delete' => 'Y']);

        Session::flash('success', $daftar->nama.' Berhasil Dihapus');

        return redirect()->route('admin.daftar.pindahan');
    }

    public function detail($id)
    {
        
    }
    
      public function print($id)
    {
          $daftar = Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')->find($id);
          $kategori = $daftar->kode_kategori.'-'.$daftar->nama_kategori;
          $petugas = Auth::guard('admin')->user()->nama;
          
                function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
        }
     
        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }           
            return $hasil;
        }

        $bilangan_bayar = terbilang($daftar->bayar); 

          return view('pages.admin.mahasiswa.pindahan.daftar.print', compact('daftar', 'id', 'kategori', 'bilangan_bayar', 'petugas'));
    }

    public function restore($id)
    {
        $daftar = Pendaftaran::find($id);
        $daftar->update(['is_delete' => 'N']);

        Session::flash('success', $daftar->nama.' Berhasil Dipulihkan');

        return redirect()->route('admin.daftar.pindahan.trash');   
    }

    public function hapus($id)
    {
        $daftar = Pendaftaran::find($id);
        
        if($daftar->id_status == 2)
        {
            PendaftaranNilai::where('id_daftar', $id);
        }
        elseif($daftar->id_status == 6)
        {
            DB::table('tbl_daftar_pindahan_pembayaran')->where('id_daftar', $id)->delete();
            if(!empty($daftar->transkrip))
            {
                File::delete('images/mahasiswa/transkrip/'.$daftar->transkrip);
            }
        }
        
        Session::flash('success', $daftar->nama.' Berhasil Dihapus');
        
        $daftar->delete();

        return redirect()->route('admin.daftar.pindahan.trash');
    }

    public function pembayaran($id)
    {
        $daftar = Pendaftaran::leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')->find($id);

        $tunggakan = 250000 - $daftar->bayar;
        return view('pages.admin.mahasiswa.pindahan.daftar.pembayaran', compact('daftar', 'id', 'tunggakan'));
    }

    public function ubah_pembayaran($id, Request $req)
    {
        $daftar = Pendaftaran::find($id);
        $input = $req->all();
        $bayar = $daftar->bayar + intval(str_replace(',', '', $req->biaya));
        $tanggal_pembayaran = date('Y-m-d', strtotime($req->tanggal_pembayaran));

        if($bayar < 250000)
        {
            $status = 'Belum Lunas';
        }
        else
        {
            $status = 'Lunas';
        }

        $input['bayar'] = $bayar;
        $input['tanggal_pembayaran'] = $tanggal_pembayaran;
        $input['status_bayar'] = $status;
        $input['updated_by'] = Auth::guard('admin')->user()->nama;

        $daftar->update($input);

        Session::flash('success', 'Pembayaran Berhasil Dilakukan');

        return redirect()->route('admin.daftar.pindahan');
    }
}
