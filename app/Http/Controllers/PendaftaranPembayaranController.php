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

use App\PendaftaranPembayaranDetail;

use App\Dispensasi;


use App\Mahasiswa;

use App\MahasiswaOrtu;

use App\MahasiswaPekerjaan;

use App\MahasiswaSekolah;

use App\Promo;


use App\Prodi;
use App\TahunAkademik;


class PendaftaranPembayaranController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth:admin');

    }



    public function datatable(Request $req)

    {

        $data = array();

        $no = 1;


         foreach (Pendaftaran::select([ 
            'tbl_daftar_pembayaran_detail.*',
            'tbl_daftar_pembayaran.*',
            'tbl_daftar.*',
            'tbl_daftar_nilai.*',
            'tbl_daftar_kategori.*',
            'm_promo.*',
            DB::raw("(SELECT SUM(bayar_kelulusan) FROM tbl_daftar_pembayaran_detail  WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = tbl_daftar_pembayaran_detail.id_daftar_pembayaran  ) AS jumlah")
             ])
            ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_nilai', 'tbl_daftar_nilai.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
            ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
            ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
            ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
            ->where('tbl_daftar.is_delete', 'N')
            ->where('tbl_daftar_nilai.status', 'Lulus')
            ->where('tbl_daftar.id_status', 2)
            ->orderBy('tbl_daftar.updated_at', 'DESC')
            ->groupBy('tbl_daftar.id_daftar')
            ->get() as $list)

         {
         
            

            if (!empty($list->potongan))

            {

               
                $bayar = ($list->biaya - $list->potongan) - $list->diskon;

            }

            else

            {

                $bayar = $list->biaya - $list->diskon;

            }


          



            if(!empty($list->status_pembayaran))

            {

                if($list->status_pembayaran == 'Lunas')

                {

                    $status = '<strong class="text-success">Lunas</strong>';

                    $aksi = '<a href="'.route('admin.pembayaran_kelulusan.detail',[ $list->id_daftar, $list->pembayaran->id_daftar_pembayaran, $list->id_daftar_detail_pembayaran]).'" class="btn btn-primary btn-sm" title="Detail"><i class="fa fa-eye"></i></a>

                        <a href="#" class="btn btn-success btn-sm" title="Bayar" disabled><i class="fa fa-money"></i></a>
                        
                         <a href="'.route('admin.pembayaran_kelulusan.print',[ $list->id_daftar, $list->id_daftar_pembayaran] ).'" target="_blank" class="btn btn-default btn-sm" title="Print"><i class="fa fa-print"></i></a>';
    
                }

                elseif($list->status_pembayaran == 'Belum Lunas')

                {

                    $status = '<strong class="text-danger">Belum Lunas</strong>';

                    $aksi = '<a href="'.route('admin.pembayaran_kelulusan.detail',[ $list->id_daftar, $list->pembayaran->id_daftar_pembayaran, $list->id_daftar_detail_pembayaran]).'" class="btn btn-primary  btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                    
                        <a href="'.route('admin.pembayaran_kelulusan.bayar',[ $list->id_daftar, $list->pembayaran->id_daftar_pembayaran]).'" class="btn btn-success btn-sm" title="Bayar"><i class="fa fa-money"></i></a>
                        
                        <a href="'.route('admin.pembayaran_kelulusan.dispensasi',[ $list->id_daftar, $list->id_daftar_pembayaran]).'" class="btn btn-warning btn-sm" title="Dispensasi"><i class="fa fa-handshake-o"></i></a>
                        
                        <a href="'.route('admin.pembayaran_kelulusan.print',[ $list->id_daftar, $list->id_daftar_pembayaran ] ).'" target="_blank" class="btn btn-default btn-sm" title="Print"><i class="fa fa-print"></i></a>';

                }
                
                 elseif ($list->status_pembayaran == 'Dispensasi') 
                {
                    
                    $status = '<strong class="text-danger">Dispensasi</strong>';

                    $aksi = ' <a href="'.route('admin.pembayaran_kelulusan.bayar',[ $list->id_daftar, $list->pembayaran->id_daftar_pembayaran]).'" class="btn btn-success btn-sm" title="Bayar"><i class="fa fa-money"></i></a>
                    <a href="'.route('admin.pembayaran_kelulusan.dispensasi.print',[ $list->id_daftar, $list->pembayaran->id_daftar_pembayaran ]).'" target="_blank" class="btn btn-warning btn-sm" title="Print Dispensasi"><i class="fa fa-print"></i></a>';
                }

            }

            else

            {

                $status = '';

               $aksi = ' <a href="'.route('admin.pembayaran_kelulusan.bayar',[ $list->id_daftar, $list->id_daftar_pembayaran]).'" class="btn btn-success btn-sm" title="Bayar"><i class="fa fa-money"></i></a>
                    <a href="'.route('admin.pembayaran_kelulusan.dispensasi',[ $list->id_daftar, $list->id_daftar_pembayaran]).'" class="btn btn-warning btn-sm" title="Dispensasi"><i class="fa fa-handshake-o"></i></a>';
            }



           

           



            $row = array();

            $row['no'] = $no;

            $row['id_daftar'] = $list->id_daftar;

            $row['nama'] = $list->nama;

            $row['nilai'] = $list->nilai;

            $row['biaya'] = number_format($bayar);

            $row['bayar'] = number_format($list->jumlah);

            $row['sisa'] = number_format($bayar - $list->jumlah);

            $row['status'] = $status;

            $row['aksi'] = $aksi;



            $data[] = $row;

            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }

     public function detail($id, $dp, $dpd)

    {

        $daftar = Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
                ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
                ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
                ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
                ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')
                ->find($id);



            $i = DB::select(DB::raw("SELECT pembayaran_ke FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = '$dp' ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));

            foreach( $i as $ipeke) {

                $ipeke->pembayaran_ke + 1;
            }

            $ke = $ipeke->pembayaran_ke + 1;

            $jumlah = DB::select(DB::raw("SELECT sum(bayar_kelulusan) as bayar FROM tbl_daftar_pembayaran_detail 
                        LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                        WHERE tbl_daftar_pembayaran.id_daftar = '$id'"));
            
            foreach ($jumlah as $jmlh) {
                 $jmlh->bayar;
            }

            $jmlh = $jmlh->bayar;

        $diskon_promo = 0;
        
        if (! empty($daftar->id_promo)) {
            foreach (explode(',', $daftar->id_promo) as $id_promo) {
                $promo = Promo::findOrFaiL($id_promo);
                $diskon_promo += $promo->diskon;
            }   
        }
             
        if(!empty($daftar->potongan))

        {

            $bayar = (($daftar->biaya - $daftar->potongan) - $jmlh) - $diskon_promo;

            $biaya = ($daftar->biaya - $daftar->potongan) - $diskon_promo;

        }

        else

        {

            $bayar = ($daftar->biaya - $jmlh) - $diskon_promo;

            $biaya = $daftar->biaya - $diskon_promo;

        }

        $kategori = $daftar->kode_kategori.'-'.$daftar->nama_kategori;


        $detail = PendaftaranPembayaranDetail::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
                
                ->where('tbl_daftar_pembayaran_detail.id_daftar_pembayaran', $dp)->get();

        return view('pages.admin.mahasiswa.pembayaran.detail', compact('daftar', 'id', 'jmlh', 'bayar', 'detail', 'kategori', 'biaya', 'diskon_promo'));

    }


    public function bayar($id, $dp)
    {
        $daftar = Pendaftaran::select([ 
                'tbl_daftar_pembayaran_detail.*',
                'tbl_daftar_pembayaran.*',
                'tbl_daftar.*',
                'tbl_daftar_nilai.*',
                'tbl_daftar_kategori.*',
                'tbl_waktu_kuliah.nama_waktu_kuliah',
                't_tahun_akademik.keterangan',
                DB::raw("(SELECT SUM(bayar_kelulusan) FROM tbl_daftar_pembayaran_detail  WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = tbl_daftar_pembayaran_detail.id_daftar_pembayaran  ) AS jmlh")
            ])
            ->leftjoin('t_tahun_akademik', 't_tahun_akademik.tahun_akademik', 'tbl_daftar.tahun_akademik')
            ->leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_nilai', 'tbl_daftar_nilai.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
            ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            // ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
            ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
            ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
            ->find($id);

        $daftar['diskon'] = 0;

        if (! empty($daftar->id_promo)) {
            foreach (explode(',', $daftar->id_promo) as $id_promo) {
                $promo = Promo::findOrFail($id_promo);
                $daftar['diskon'] += $promo->diskon;
            }
        }

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

        return view('pages.admin.mahasiswa.pembayaran.bayar', compact('daftar', 'id', 'dp', 'jmlh', 'bayar', 'ke', 'kategori', 'biaya'));

    }

    public function perbarui($id, $dp, Request $req)

    {
        $system = New SystemController();

        $calon =  Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar_pembayaran')->find($id);

        $calon['diskon'] = 0;
        
        if (! empty($calon->id_promo)) {
            foreach (explode(',', $calon->id_promo) as $id_promo) {
                $promo = Promo::findOrFail($id_promo);
                $calon['diskon'] += $promo->diskon;
            }
        }

        if(!empty($calon->potongan))

        {

            $bayar = ($calon->biaya - $calon->potongan) - $calon->diskon;

        }

        else

        {

            $bayar = $calon->biaya - $calon->diskon;

        }

        // if (! empty($calon->promo))
        // {
        //     $bayar = $bayar - $calon->promo->diskon;
        // }



        if(str_replace(',', '', $req->bayar) > $bayar)

        {

            Session::flash('fail', 'Pembayaran Lebih Dari Biaya Seharusnya');



            return redirect()->back()->withInput($req->all());

        }

        else

        {
            $ttl = DB::select(DB::raw("SELECT sum(bayar_kelulusan) as bayar FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE id_daftar = '$id'
                    ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));
            foreach ($ttl as $total) {
              
                $total->bayar + str_replace(',', '', $req->bayar);
            }
               $jml_bayar = $total->bayar + str_replace(',', '', $req->bayar);


            $i = DB::select(DB::raw("SELECT pembayaran_ke FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE tbl_daftar_pembayaran.id_daftar = '$id' ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));

            foreach( $i as $ipeke) {

                $ipeke->pembayaran_ke + 1;
            }
        
            
            if (!empty($ipeke->pembayaran_ke)) {

                $ke = $ipeke->pembayaran_ke + 1;

            }else{

                $ke = $calon->pembayaran_ke + 1;
            }


            if($jml_bayar < $bayar)

            {
                $status = 'Belum Lunas';
            }

            else

            {
                $status = 'Lunas';
            }
            
            $tanggal_bayar = date('Y-m-d', strtotime($req->tanggal_bayar));
            
             Pendaftaran::where('id_daftar', $id)->update(['updated_at' => date('Y-m-d H:i:s'), 'updated_by' => Auth::guard('admin')->user()->nama ]);

            PendaftaranPembayaran::where('id_daftar', $id)->update(['status_pembayaran' => $status]);

            $ip = DB::select(DB::raw("SELECT * FROM tbl_daftar_pembayaran WHERE id_daftar = '$id' ORDER BY id_daftar_pembayaran DESC LIMIT 1"));

            foreach ($ip as $ipem) {

             $save =   PendaftaranPembayaranDetail::create(['id_daftar_pembayaran' => $ipem->id_daftar_pembayaran,  
                    'bayar_kelulusan' => str_replace(',', '', $req->bayar), 'pembayaran_ke' => $ke, 
                    'tanggal_pembayaran' => $tanggal_bayar ]);
            }
            
            $dispensasi = Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
            ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
            ->leftjoin('tbl_dispensasi', 'tbl_daftar.id_daftar', 'tbl_dispensasi.id_daftar')
            ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik' )
            ->orderBy('id_dispensasi', 'Desc')
            ->limit(1)
            ->find($id);



            if ($calon->id_daftar == $dispensasi->id_daftar ) {

                if ( $jml_bayar >= $dispensasi->nominal_akan_bayar ) {

                    Dispensasi::where('id_daftar', $id)->update(['status' => 'Sudah Bayar', 'tanggal_bayar' => date('Y-m-d H:i:s'), 'updated_by' => Auth::guard('admin')->user()->nama, 'updated_date' => date('Y-m-d H:i:s') ]);
                }else {
                    Dispensasi::where('id_daftar', $id)->update(['status' => 'Belum Bayar', 'tanggal_bayar' => date('Y-m-d H:i:s'), 'updated_by' => Auth::guard('admin')->user()->nama, 'updated_date' => date('Y-m-d H:i:s') ]);
                }
            }


            Session::flash('success', 'Berhasil Melakukan Pembayaran');
    
           
            $url = "http://yayasanppi.net/admin/pendaftaran/baru/pembayaran-kelulusan/".$id."/".$dp."/print";

            echo "<script>window.open('".$url."', '_blank')</script>"; 

            $urle = "http://yayasanppi.net/admin/pendaftaran/baru/pembayaran-kelulusan";

            echo "<script>window.location='".$urle."'</script>";


        }

    }
    
    
   public function dispensasi($id, $dp) {
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




         return view('pages.admin.mahasiswa.pembayaran.dispensasi', compact('daftar', 'id', 'dp', 'jmlh', 'bayar', 'ke', 'kategori', 'biaya'));

    }
   

     public function dispen($id, $dp, Request $req)

    {

        $system = New SystemController();

        $calon =  Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar_pembayaran')->find($id);



        if(!empty($calon->potongan))

        {

            $bayar = ($calon->biaya - $calon->potongan) - $calon->diskon;

        }

        else

        {

            $bayar = $calon->biaya - $calon->diskon;

        }

        if (! empty($calon->promo))
        {
            $bayar = $bayar - $calon->promo->diskon;
        }



        if(str_replace(',', '', $req->nominal_akan_bayar) > $bayar)

        {

            Session::flash('fail', 'Pembayaran Lebih Dari Biaya Seharusnya');



            return redirect()->back()->withInput($req->all());

        }

        else

        {
            $ttl = DB::select(DB::raw("SELECT sum(bayar_kelulusan) as bayar FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE id_daftar = '$id'
                    ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));
            foreach ($ttl as $total) {
              
                $total->bayar + str_replace(',', '', $req->nominal_akan_bayar);
            }
                $jml_bayar = $total->bayar + str_replace(',', '', $req->nominal_akan_bayar);


            $i = DB::select(DB::raw("SELECT pembayaran_ke FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE tbl_daftar_pembayaran.id_daftar = '$id' ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));

            foreach( $i as $ipeke) {

                $ipeke->pembayaran_ke + 1;
            }
        
            
            if (!empty($ipeke->pembayaran_ke)) {

                $ke = $ipeke->pembayaran_ke + 1;

            }else{

                $ke = $calon->pembayaran_ke + 1;
            }


            if($jml_bayar < $bayar)

            {
                $status = 'Belum Lunas';
            }

            else

            {
                $status = 'Lunas';
            }

            $tanggal_akan_bayar = date('Y-m-d', strtotime($req->tanggal_akan_bayar));
            
             Pendaftaran::where('id_daftar', $id)->update(['updated_at' => date('Y-m-d H:i:s'), 'updated_by' => Auth::guard('admin')->user()->nama   ]);

            PendaftaranPembayaran::where('id_daftar', $id)->update(['status_pembayaran' => 'Dispensasi']);

            Dispensasi::create(['id_daftar' => $id, 'tanggal_akan_bayar' => $tanggal_akan_bayar, 'nominal_akan_bayar' => str_replace(',', '', $req->nominal_akan_bayar), 'jenis_pembayaran' => 'Pembayaran Kelulusan', 'created_by' => Auth::guard('admin')->user()->nama, 'created_date' =>  date('Y-m-d H:i:s') ]);


            Session::flash('success', 'Berhasil Melakukan Dispensasi');

            $url = "http://yayasanppi.net/admin/pendaftaran/baru/pembayaran-kelulusan/". $id ."/". $dp ."/dispensasi/print";

            echo "<script>window.open('".$url."', '_blank')</script>"; 

            $urle = "http://yayasanppi.net/admin/pendaftaran/baru/pembayaran-kelulusan";

            echo "<script>window.location='".$urle."'</script>";

        }

    }
    

    public function dispensasi_print($id, $dp)

    {
        $dispensasi = Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
                    ->leftjoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
                    ->leftjoin('tbl_dispensasi', 'tbl_daftar.id_daftar', 'tbl_dispensasi.id_daftar')
                    ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik' )
                    ->orderBy('id_dispensasi', 'Desc')
                    ->limit(1)
                    ->find($id);
    

        $petugas = Auth::guard('admin')->user()->nama;

        return view('pages.admin.dispensasi.print.detail_print', compact('dispensasi', 'petugas'));

    }



       public function print($id, $dp)

    {
        $daftar = Pendaftaran::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
                ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
                ->leftjoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
                ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
                ->leftjoin('tbl_mahasiswa_status', 'tbl_mahasiswa_status.id_status', 'tbl_daftar.id_status')
                ->leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')
                ->find($id);

        $petugas = Auth::guard('admin')->user()->nama;
        
       


            $i = DB::select(DB::raw("SELECT pembayaran_ke FROM tbl_daftar_pembayaran_detail 
                    LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                    WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = '$dp' ORDER BY id_daftar_detail_pembayaran DESC LIMIT 1"));

            foreach( $i as $ipeke) {

                $ipeke->pembayaran_ke + 1;
            }

            $ke = $ipeke->pembayaran_ke + 1;

            $jumlah = DB::select(DB::raw("SELECT sum(bayar_kelulusan) as bayar FROM tbl_daftar_pembayaran_detail 
                        LEFT JOIN tbl_daftar_pembayaran ON tbl_daftar_pembayaran_detail.id_daftar_pembayaran = tbl_daftar_pembayaran.id_daftar_pembayaran
                        WHERE tbl_daftar_pembayaran.id_daftar = '$id' "));
            
            foreach ($jumlah as $jmlh) {
                 $jmlh->bayar;
            }

            $jmlh = $jmlh->bayar;

        $diskon_promo = 0;
        
        if (! empty($daftar->id_promo)) {
            foreach (explode(',', $daftar->id_promo) as $id_promo) {
                $promo = Promo::findOrFaiL($id_promo);
                $diskon_promo += $promo->diskon;
            }   
        }
             
        if(!empty($daftar->potongan))

        {

            $bayar = (($daftar->biaya - $daftar->potongan) - $jmlh) - $diskon_promo;

            $biaya = ($daftar->biaya - $daftar->potongan) - $diskon_promo;

        }

        else

        {

            $bayar = ($daftar->biaya - $jmlh) - $diskon_promo;

            $biaya = $daftar->biaya - $diskon_promo;

        }

        $kategori = $daftar->kode_kategori.'-'.$daftar->nama_kategori;


        $detail = PendaftaranPembayaranDetail::leftjoin('tbl_daftar_pembayaran', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
                ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
                ->where('tbl_daftar_pembayaran_detail.id_daftar_pembayaran', $dp)->get();

        return view('pages.admin.mahasiswa.pembayaran.print', compact('daftar', 'petugas', 'id', 'jmlh', 'bayar', 'detail',  'kategori', 'biaya', 'diskon_promo'));

    }
    
    
    public function hapus($id, $dp, $dpd)

    {

    $nilai = PendaftaranPembayaranDetail::find($dpd);

    $batal =  PendaftaranPembayaranDetail::find($dpd)->delete();

    $status = PendaftaranPembayaran::find($dp)->update(['status_pembayaran' => 'Belum Lunas']); 


    Session::flash('fail', 'Data Pembayaran Berhasil Dibatalkan.');

    return redirect()->route('admin.pembayaran_kelulusan');

}

    
    

    public function lkk($id, Request $request)
    {
        $list_prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        $list_tahun_akademik = TahunAkademik::orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');
        $list_status = [
            'Lunas' => 'Lunas',
            'Belum Lunas' => 'Belum Lunas',
        ];

        // $awal = $request->awal;
        // $akhir = $request->akhir;

         if ($id == 2) {

            $pembayaran = DB::table('tbl_daftar_pembayaran')
                ->select(DB::raw("m_mahasiswa.nim, 
                    tbl_daftar.nama, 
                    tbl_daftar_pembayaran.id_daftar, 
                    tbl_prodi.nama_prodi, 
                    tbl_daftar_kategori.biaya, 
                    ifnull(m_promo.diskon, 0) AS diskon,
                    SUM(tbl_daftar_pembayaran_detail.bayar_kelulusan) as jum_bayar, 
                    tbl_daftar_pembayaran.status_pembayaran,
                    ((tbl_daftar_kategori.biaya - ifnull(m_promo.diskon, 0)) - SUM(tbl_daftar_pembayaran_detail.bayar_kelulusan)) AS sisa"))
                // ->table('tbl_daftar_pembayaran')
                ->leftJoin('tbl_daftar', 'tbl_daftar_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
                ->leftjoin('tbl_daftar_kategori', function ($join) {
                    $join->on('tbl_daftar.tahun_akademik', '=', 'tbl_daftar_kategori.tahun_akademik')
                            ->on('tbl_daftar_kategori.id_prodi', '=', 'tbl_daftar.id_prodi')
                            ->on('tbl_daftar.id_waktu_kuliah', '=', 'tbl_daftar_kategori.id_waktu_kuliah')
                            ->where('tbl_daftar_kategori.is_delete', '=', "N");
                        }
                    )

                ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
                ->leftjoin('m_mahasiswa', 'tbl_daftar_pembayaran.id_daftar', 'm_mahasiswa.id_daftar')
                ->leftJoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran.id_daftar_pembayaran', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran')
                ->leftJoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
                // ->whereBetween('tbl_daftar.created_at', [$awal, $akhir])
                ->where([
                    'tbl_daftar.is_delete' => 'N',
                    'tbl_daftar.id_status' => $id
                ])
                ->whereNotNull('tbl_daftar_pembayaran.status_pembayaran');

            if (! empty($request->id_prodi)) $pembayaran->where('tbl_daftar.id_prodi', $request->id_prodi);
            if (! empty($request->tahun_akademik)) $pembayaran->where('tbl_daftar.tahun_akademik', $request->tahun_akademik);
            if (! empty($request->status)) $pembayaran->where('tbl_daftar_pembayaran.status_pembayaran', $request->status);
            if (! empty($request->angkatan)) $pembayaran->where(DB::raw("SUBSTR(tbl_daftar.id_daftar,1,2)"), substr($request->angkatan,2));

            $pembayaran->groupBy('tbl_daftar.id_daftar');

            $pembayaran = $pembayaran->get();
        } else if ($id == 6) {

            $pembayaran_pindahan = DB::table('tbl_daftar_pindahan_pembayaran')
                ->select(DB::raw("m_mahasiswa.nim, tbl_daftar_pindahan_pembayaran.id_daftar,
                    tbl_daftar.nama, tbl_prodi.nama_prodi, tbl_daftar_pindahan_pembayaran.bayar_masuk,
                    (tbl_biaya_pindahan.biaya - tbl_daftar_pindahan_pembayaran.bayar_masuk) AS sisa,
                    tbl_daftar_pindahan_pembayaran.status_pembayaran"))

                ->leftJoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')
                ->leftJoin('tbl_daftar', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'tbl_daftar.id_daftar')
                ->leftjoin('m_mahasiswa', 'tbl_daftar_pindahan_pembayaran.id_daftar', 'm_mahasiswa.id_daftar')
                // ->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
                ->leftJoin('tbl_prodi', 'tbl_daftar.id_prodi', 'tbl_prodi.id_prodi')
                // ->whereBetween('tbl_daftar.created_at', [$awal, $akhir])
                ->where([
                    'tbl_daftar.is_delete' => 'N',
                    'tbl_daftar.id_status' => $id
                ])
                ->whereNotNull('tbl_daftar_pindahan_pembayaran.status_pembayaran');

            if (! empty($request->id_prodi)) $pembayaran_pindahan->where('tbl_daftar.id_prodi', $request->id_prodi);
            if (! empty($request->tahun_akademik)) $pembayaran_pindahan->where('tbl_daftar.tahun_akademik', $request->tahun_akademik);
            if (! empty($request->status)) $pembayaran_pindahan->where('tbl_daftar_pindahan_pembayaran.status_pembayaran', $request->status);
            if (! empty($request->angkatan)) $pembayaran_pindahan->where(DB::raw("SUBSTR(tbl_daftar.id_daftar,1,2)"), substr($request->angkatan,2));


            $pembayaran_pindahan = $pembayaran_pindahan->get();
        }
        $list_angkatan = $request->angkatan;

        return view('pages.admin.mahasiswa.pembayaran.lkk', compact('pembayaran', 'pembayaran_pindahan', 'list_prodi', 'list_tahun_akademik', 'list_status', 'list_angkatan'));
    } 

}

