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

use App\Kelas;

use App\KategoriPembayaran;

use App\PendaftaranPembayaran;

use App\Dosen;

use App\Dispensasi;







use App\Mahasiswa;



use App\MahasiswaOrtu;



use App\MahasiswaPekerjaan;



use App\MahasiswaSekolah;



use App\WaktuKuliah;

use App\TahunAkademik;

use App\PenasihatAkademik;

use App\DetailPenasihatAkademik;





use App\Prodi;


use App\Provinsi;







class RegistrasiMahasiswaController extends Controller



{







    public function __construct()



    {



        $this->middleware('auth:admin');



    }


	public function get_now_tahun_akademik()
    {
        $bulan = date('m');

        if ($bulan >= 02 and $bulan <= 07) {
            $tahun_lalu = date("Y") - 1;
            $belakang = "20";
            $tahun = $tahun_lalu.$belakang;
        }else{
            $tahun_sekarang = date("Y");
            $belakang = "10";
            $tahun = $tahun_sekarang.$belakang;
        }

        return $tahun;
    }

    public function datatable(Request $req)
    {

        $data = array();
        $no = 1;

       $list_pendaftaran = Pendaftaran::select([
            'tbl_daftar.*',
            'tbl_prodi.*',
            'tbl_waktu_kuliah.*',
            'tbl_mahasiswa_status.*',
            'tbl_daftar_pembayaran.*',
            'm_promo.*',
            'tbl_daftar_kategori.*',
            'tbl_daftar_pembayaran_detail.*',
            'm_mahasiswa.nim',
             DB::raw("(SELECT SUM(bayar_kelulusan) FROM tbl_daftar_pembayaran_detail  WHERE tbl_daftar_pembayaran.id_daftar_pembayaran = tbl_daftar_pembayaran_detail.id_daftar_pembayaran  ) AS jumlah"),
            'tbl_daftar_nilai.*'
        ])
        ->leftJoin('tbl_mahasiswa_status', 'tbl_daftar.id_status', '=', 'tbl_mahasiswa_status.id_status')
        ->leftjoin('m_mahasiswa','tbl_daftar.id_daftar', 'm_mahasiswa.id_daftar' )
        ->leftJoin('tbl_prodi', 'tbl_daftar.id_prodi', '=', 'tbl_prodi.id_prodi')
        ->leftJoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', '=', 'tbl_waktu_kuliah.id_waktu_kuliah')
        ->leftJoin('tbl_daftar_pembayaran', 'tbl_daftar.id_daftar', '=', 'tbl_daftar_pembayaran.id_daftar')
        ->leftJoin('tbl_daftar_pembayaran_detail', 'tbl_daftar_pembayaran_detail.id_daftar_pembayaran', '=', 'tbl_daftar_pembayaran.id_daftar_pembayaran')
        ->leftJoin('tbl_daftar_nilai', 'tbl_daftar.id_daftar', '=', 'tbl_daftar_nilai.id_daftar')
        ->leftJoin('m_promo', 'tbl_daftar.id_promo', '=', 'm_promo.id_promo')
        ->leftjoin('tbl_daftar_kategori', 'tbl_daftar_pembayaran.id_daftar_kategori', 'tbl_daftar_kategori.id_daftar_kategori')
        ->where('tbl_daftar.id_status', '2')
        ->where('tbl_daftar.is_delete', 'N')
        ->orderBy('tbl_daftar.updated_at', 'DESC')
        ->groupBy('tbl_daftar.id_daftar');


        if (! empty($req->tahun_akademik))
        {
            $list_pendaftaran = $list_pendaftaran->where('tbl_daftar.tahun_akademik', $req->tahun_akademik);
        }

         if (! empty($req->id_prodi))
        {
            $list_pendaftaran = $list_pendaftaran->where('tbl_daftar.id_prodi', $req->id_prodi);
        }

         $list_pendaftaran = $list_pendaftaran->get();


        foreach ($list_pendaftaran as $list)

        {

            if (!empty($list->potongan))

            {

               
                $bayar = ($list->biaya - $list->potongan) - $list->diskon;

            }

            else

            {

                $bayar = $list->biaya - $list->diskon;

            }

            $sisa = $bayar - $list->jumlah;
            
            if (($list->registration == 'F' && $list->status == 'Lulus' && $list->status_pembayaran == 'Lunas') || ($list->jumlah >= $list->minimal_biaya && $list->registration == 'F' && $list->status_pembayaran != 'Lunas') || ( $list->registration == 'F' && $list->status_pembayaran == 'Dispensasi' ) || ( $sisa <= 900000 && $list->registration == 'F' && $list->status_pembayaran != 'Lunas' ) )

            {
                
                $aksi = '<a href="'.route('admin.registrasi.index', $list->id_daftar).'" class="btn btn-success btn-sm" title="Registrasi"><i class="fa fa-sign-in"></i></a>';
                if (empty($list->status_pembayaran)) $aksi = '<button type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-sign-in"></i></button>';
            }

            else

            {
                
                /* cpenk edit */
                $cek_pembayaran = DB::table('t_pembayaran_spp')->where('nim', $list->nim)->count();
                $aksi = '<button type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-sign-in"></i></button> <a href="'.route('admin.registrasi.batal_regis', $list->id_daftar).'" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-danger btn-sm" title="Batalkan"><i class="fa fa-times"></i></a>';
                if ($cek_pembayaran > 0) $aksi = '<button type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-sign-in"></i></button> <button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-times"></i></button>';
                /* end */
                /* before 
                $aksi = '<button type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-sign-in"></i></button>';
                */

            }

		$search_kelas = DB::table('m_kelas')
            ->select([
                'm_kelas.id_prodi',
                'm_kelas.kode_kelas'
            ])
            ->rightJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->where([
                'm_kelas_detail.nim' => $list->nim,
		'm_kelas.tahun_akademik' => $this->get_now_tahun_akademik(),
            ])
            ->first();

		if (empty($search_kelas))
		{
			$kelas = null;
		}
		else
		{
			$kelas = $search_kelas->id_prodi."-".$search_kelas->kode_kelas;
		}



            $data[] = array(

                'no' => $no++,

                'id_daftar' => $list->id_daftar,
                
                'nim' => $list->nim,

                'akademik' => $list->tahun_akademik,

                'nama' => $list->nama,

                'prodi' => $list->nama_prodi,

                'waktu_kuliah' => $list->nama_waktu_kuliah,

                'status' => $list->nama_status,
                
                'status_pembayaran' => $list->status_pembayaran,  

                'sisa' => $bayar - $list->jumlah,

                'aksi' => $aksi

            );

        }



        return DataTables::of($data)->escapeColumns([])->make(true);

    }


    function index()
    {
        $list_tahun_akademik = TahunAkademik::where('is_delete', 'N')->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');

        $list_prodi = Prodi::whereIn('nama_prodi', ['Akuntansi', 'Manajemen'])->pluck('nama_prodi', 'id_prodi');

        $list_tahun_akademik->prepend('- Semua -', '');

        $list_prodi->prepend('- Semua -', '');

        return view('pages.admin.mahasiswa.registrasi.index', compact('list_tahun_akademik', 'list_prodi'));
    }






    public function registrasi($id)



    {



        $daftar = Pendaftaran::find($id);




        $dosen = Dosen::select('nip', 'nama')->where('status_dosen', '1')->orderBy('nama', 'ASC')->pluck('nama', 'nip');


        $provinsi = Provinsi::orderBy('nama_provinsi', 'ASC')->pluck('nama_provinsi', 'id_provinsi');



        if(Mahasiswa::where(['tahun_masuk' => substr($daftar->tahun_akademik, 0, 4), 'id_jenjang' => $daftar->id_jenjang, 'id_prodi' => $daftar->id_prodi])->count() > 0)



        {



            $mahasiswa = Mahasiswa::where(['tahun_masuk' => substr($daftar->tahun_akademik, 0, 4), 'id_jenjang' => $daftar->id_jenjang, 'id_prodi' => $daftar->id_prodi])->orderBy('id_mahasiswa', 'DESC')->first();



            $nim_old = intval(substr($mahasiswa->nim, 6, 4)) + 1;



            if(strlen($nim_old) == 1)



            {



                $num = '000';



            }



            elseif(strlen($nim_old) == 2)



            {



                $num = '00';



            }



            elseif(strlen($nim_old) == 3)



            {



                $num = '0';



            }



            else



            {



                $num = '';



            }



            $nim = substr($daftar->tahun_akademik, 2, 2).$daftar->id_jenjang.substr($daftar->id_prodi, 0, 2).'2'.$num.$nim_old;



        }



        else



        {



            $nim = substr($daftar->tahun_akademik, 2, 2).$daftar->id_jenjang.substr($daftar->id_prodi, 0, 2).'20001';



        }



        $waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');







        return view('pages.admin.mahasiswa.registrasi.registrasi', compact('daftar', 'id', 'nim', 'provinsi', 'waktu_kuliah', 'dosen'));



    }







    public function perbarui($id, Request $req)



    {



        $system = New SystemController();



        $daftar = Pendaftaran::find($id);



        



        $biodata = $req->all();



        $biodata['tahun_masuk'] = substr($daftar->tahun_akademik, 0, 4);

        

        $biodata['tahun_akademik'] = $daftar->tahun_akademik;



        $biodata['id_prodi'] = substr($req->id_prodi, 0,3);


        $biodata['tgl_lahir'] = date('Y-m-d', strtotime( $req->tgl_lahir ));
        

        $biodata['id_waktu_kuliah'] = substr($req->id_waktu_kuliah, 0,1);



        $biodata['id_prov'] = $req->id_provinsi;



        $biodata['id_status'] = $daftar->id_status;



        $biodata['id_jenjang'] = $daftar->id_jenjang;
        
           
        $biodata['nip'] = $req->nip;



        $biodata['password'] = $system->encrypt('123', $req->nim, $req->nim);



        $biodata['auth'] = $system->encrypt('123', $req->nim, $req->nim);



        $biodata['crated_by'] = Auth::guard('admin')->user()->nama;

	    $biodata['id_daftar'] = $daftar->id_daftar;







        //Sekolah



        $sekolah['nim'] = $req->nim;



        if($daftar->id_status == '6')



        {



            $sekolah['pt_asal'] = $req->pt_asal;



        }



        $sekolah['asal_sekolah'] = $req->asal_sekolah;



        $sekolah['no_ijazah'] = $req->no_ijazah;



        $skeolah['jurusan'] = $req->jurusan;



        $sekolah['alamat_sekolah'] = $req->alamat_sekolah;



        $sekolah['kabupaten_sekolah'] = $req->kabupaten_sekolah;



        $sekolah['id_provinsi'] = $req->id_provinsi;







        //Pekerjaan



        $pekerjaan['nim'] = $req->nim;



        $pekerjaan['perusahaan'] = $req->perusahaan;



        $pekerjaan['posisi'] = $req->posisi;



        $pekerjaan['alamat_perusahaan'] = $req->alamat_perusahaan;







        //Data Orang Tua



        $ortu['nim'] = $req->nim;



        $ortu['nama_ibu'] = $req->nama_ibu;



        $ortu['nama_ayah'] = $req->nama_ayah;



        $ortu['alamat_ortu'] = $req->alamat_ortu;



        $ortu['no_telp_ortu'] = $req->no_telp_ortu;







        if(!empty($req->foto_profil))



        {



            $foto = $req->file('foto_profil');



            $nama = $req->nim.$req->nama.'.'.$foto->getClientOriginalExtension();



            $foto->move('images/mahasiswa/', $nama);



            $biodata['foto_profil'] = $nama;



        }







        Mahasiswa::create($biodata);



        MahasiswaSekolah::create($sekolah);



        MahasiswaPekerjaan::create($pekerjaan);



        MahasiswaOrtu::create($ortu);

        $tahun_masuk = substr($daftar->tahun_akademik, 0, 4);

        $inputdosen = PenasihatAkademik::create(['nip' => $req->nip, 'tahun_masuk' => $tahun_masuk,  'created_by' => Auth::guard('admin')->user()->nama, 'created_date' => date('Y-m-d') ]);

        DetailPenasihatAkademik::create(['nip' => $req->nip, 'nim' => $req->nim,  'created_by' => Auth::guard('admin')->user()->nama, 'created_date' => date('Y-m-d') ]);



        $daftar->update(['registration' => 'T', 'updated_at' => date('Y-m-d H:i:s') ]);



        



        Session::flash('success', $req->nama.' Berhasil Diregistrasikan');







        return redirect()->route('admin.registrasi');



    }
    
    
    /* cpenk add */
    
    public function batal_regis($id)
    {
        // $system = New SystemController();
        $daftar = Pendaftaran::find($id);
        $mhs = Mahasiswa::where(['id_daftar' => $id])->first();
        DB::table('m_kelas_detail')->where('nim', $mhs->nim)->delete();
        DB::table('m_mahasiswa')->where('nim', $mhs->nim)->delete();
        DB::table('m_mahasiswa_ortu')->where('nim', $mhs->nim)->delete();
        DB::table('m_mahasiswa_pekerjaan')->where('nim', $mhs->nim)->delete();
        DB::table('m_mahasiswa_sekolah')->where('nim', $mhs->nim)->delete();
        // DB::table('tbl_dispensasi')->where('nim', $mhs->nim)->delete();
        // DB::table('t_absensi')->where('nim', $mhs->nim)->delete();
        // DB::table('t_khs')->where('nim', $mhs->nim)->delete();
        // DB::table('t_krs')->where('nim', $mhs->nim)->delete();
        // DB::table('t_pembayaran_spp')->where('nim', $mhs->nim)->delete();
        DB::table('tbl_detail_penasihat_akademik')->where('nim', $mhs->nim)->delete();
        $daftar->update(['registration' => 'F', 'updated_at' => date('Y-m-d H:i:s') ]);
        Session::flash('success', 'Registrasi '.$daftar->nama.' Berhasil Dibatalkan');
        return redirect()->route('admin.registrasi');
    }

    /* end */

   


    public function laporan_kelas()

    {
        $all    = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $akuntansi = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_prodi', 622)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $manajemen = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_prodi', 612)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $pagi       = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_waktu_kuliah', 1)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $malem      = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_waktu_kuliah', 2)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $executive  = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_waktu_kuliah', 3)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');

        $shift      = Kelas::leftjoin('m_kelas_detail', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
                    ->leftjoin('m_mahasiswa', 'm_mahasiswa.nim', 'm_kelas_detail.nim')
                    ->where('m_mahasiswa.id_waktu_kuliah', 4)
                    ->where('m_mahasiswa.is_delete', 'N')
                    ->count('m_kelas_detail.nim');
        
            
        return view('pages.admin.mahasiswa.registrasi.laporan_kelas', compact('akuntansi', 'manajemen', 'pagi', 'malem', 'executive', 'shift', 'all'));
        
    } 

}



