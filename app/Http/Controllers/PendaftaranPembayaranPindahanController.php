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



use App\PendaftaranNilai;

use App\Pendaftaran;

use App\KategoriPembayaran;

use App\PendaftaranPembayaran;



use App\Mahasiswa;

use App\MahasiswaOrtu;

use App\MahasiswaPekerjaan;

use App\MahasiswaSekolah;



class PendaftaranPembayaranPindahanController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth:admin');

    }



    public function datatable(Request $req)

    {

        $data = array();

        $no = 1;



        foreach (DB::table('tbl_daftar_pindahan_pembayaran')->leftjoin('tbl_daftar', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')->where('id_status', 6)->where('tbl_daftar.is_delete', 'N')->get() as $list)

        {



            if(!empty($list->status_pembayaran))

            {

                if($list->status_pembayaran == 'Lunas')

                {

                    $status = '<strong class="text-success">Lunas</strong>';

                    $aksi = '<a href="#" class="btn btn-success btn-sm" title="Bayar" disabled><i class="fa fa-money"></i></a>
                    <a href="'.route('admin.pindahan.pembayaran.kwitansi', $list->id_daftar).'" class="btn btn-default btn-sm" title="Print" target="_blank" ><i class="fa fa-print"></i></a>
                    <a href="'.route('admin.pindahan.pembayaran.update_nominal', $list->id_daftar).'" class="btn btn-warning btn-sm" title="Update Nominal" ><i class="fa fa-edit"></i></a>';

                }

                else

                {

                    $status = '<strong class="text-danger">Belum Lunas</strong>';

                    $aksi = '<a href="'.route('admin.pindahan.pembayaran.detail', $list->id_daftar).'" class="btn btn-success btn-sm" title="Bayar"><i class="fa fa-money"></i></a>
                    <a href="'.route('admin.pindahan.pembayaran.kwitansi', $list->id_daftar).'" class="btn btn-default btn-sm" title="Print" ><i class="fa fa-print"></i></a>
                    <a href="'.route('admin.pindahan.pembayaran.update_nominal', $list->id_daftar).'" class="btn btn-warning btn-sm" title="Update Nominal" ><i class="fa fa-edit"></i></a>';

                }

            }

            else

            {

                $status = '<strong class="text-danger">Belum Bayar</strong>';

                $aksi = '<a href="'.route('admin.pindahan.pembayaran.detail', $list->id_daftar).'" class="btn btn-success btn-sm" title="Bayar"><i class="fa fa-money"></i></a>';

            }


            if (!empty($list->potongan))

            {

               
                $bayar = ($list->biaya - $list->potongan) - $list->diskon;

            }

            else

            {

                $bayar = $list->biaya - $list->diskon;

            }


            $row = array();

            $row['no'] = $no;

            $row['id_daftar'] = $list->id_daftar;

            $row['akademik'] = $list->tahun_akademik;

            $row['nama'] = $list->nama;

            $row['prodi'] = $list->nama_prodi;

            $row['biaya'] = number_format($bayar);
            
            

            $row['minimal'] = number_format($list->minimal);

            $row['bayar'] = number_format($list->bayar_masuk);

            $row['sisa'] = number_format($bayar- $list->bayar_masuk);

            $row['status'] = $status;

            $row['aksi'] = $aksi;



            $data[] = $row;

            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }



    public function detail($id)

    {

        $daftar = Pendaftaran::leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
        ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
        ->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')
        ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')->find($id);





        return view('pages.admin.mahasiswa.pindahan.pembayaran.bayar', compact('daftar', 'id'));

    }
    
    public function update_nominal($id)

    {

        $daftar = Pendaftaran::leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
        ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
        ->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')
        ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')->find($id);





        return view('pages.admin.mahasiswa.pindahan.pembayaran.update_nominal', compact('daftar', 'id'));

    }
    
     public function print($id)

    {

        $daftar = Pendaftaran::leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
        ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
        ->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')
        ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')->find($id);

        $kategori = $daftar->kode_kategori.'-'.$daftar->nama_kategori;
        $petugas = Auth::guard('admin')->user()->nama;
        
        // $discount = $daftar->bayar_masuk - $daftar-diskon;
        
        $biaya_harus_dibayar = $daftar->biaya - $daftar->diskon;

        $kurang = $biaya_harus_dibayar - $daftar->bayar_masuk;



        return view('pages.admin.mahasiswa.pindahan.pembayaran.print', compact('daftar', 'id', 'kategori', 'petugas', 'biaya_harus_dibayar', 'kurang'));

    }


    public function perbarui($id, Request $req)
    {
        $system = New SystemController();
        $daftar =  Pendaftaran::leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')->find($id);

        if(!empty($req->bayar))
        {
            $bayar = str_replace(',', '', $req->bayar);

            if($bayar > 0)
            {
                if(DB::table('tbl_daftar_pindahan_pembayaran')->where('id_daftar', $id)->count() > 0)
                {
                    $jml_bayar = intval($daftar->bayar_masuk) + intval($bayar);
                    $ke = $daftar->bayar_ke + 1;
                }
                else
                {
                    $jml_bayar = $bayar;
                    $ke = 1;
                }

                 if (!empty($daftar->potongan))
                    {
                        $bayar = ($daftar->biaya - $daftar->potongan) - $list->diskon;
                    }
                    else
                    {
                        $bayar = $daftar->biaya - $daftar->diskon;        
                    }

                if($jml_bayar < $bayar)
                {
                    $status = 'Belum Lunas';
                }
                else
                {
                    $status = 'Lunas';
                }

                DB::table('tbl_daftar_pindahan_pembayaran')->where('id_daftar', $id)->update(['bayar_masuk' => $jml_bayar, 'bayar_ke' => $ke, 'status_pembayaran' => $status]);

                Session::flash('success', 'Berhasil Melakukan Pembayaran');
                return redirect()->route('admin.pindahan.pembayaran');
            }
        }
        else
        {
            Session::flash('fail', 'Biaya Pembayaran Tidak Boleh Kosong');
            return redirect()->back()->withInput($req->all());
        }

    }

    public function perbarui_nominal($id, Request $req)
    {
        $system = New SystemController();
        $daftar =  Pendaftaran::leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')->find($id);

        if(!empty($req->bayar))
        {
            $bayar = str_replace(',', '', $req->bayar);

            if($bayar > 0)
            {
                $jml_bayar = $bayar;

                if (!empty($daftar->potongan))
                   {
                       $bayar = ($daftar->biaya - $daftar->potongan) - $list->diskon;
                   }
                   else
                   {
                       $bayar = $daftar->biaya - $daftar->diskon;        
                   }

                if (empty($req->status_pembayaran))
                {
                    $status = 'Belum Lunas';
                }
                else
                {
                    $status = $req->status_pembayaran;
                }

                DB::table('tbl_daftar_pindahan_pembayaran')->where('id_daftar', $id)->update(['bayar_masuk' => $jml_bayar, 'status_pembayaran' => $req->status_pembayaran]);

                Session::flash('success', 'Berhasil Melakukan Perubahan Pembayaran');
                return redirect()->route('admin.pindahan.pembayaran');
            }
        }
        else
        {
            Session::flash('fail', 'Biaya Pembayaran Tidak Boleh Kosong');
            return redirect()->back()->withInput($req->all());
        }

    }

}

