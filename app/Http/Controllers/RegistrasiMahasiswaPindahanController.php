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
use App\WaktuKuliah;

use App\Dosen;

use App\Mahasiswa;

use App\MahasiswaOrtu;

use App\MahasiswaPekerjaan;

use App\MahasiswaSekolah;



use App\Provinsi;



class RegistrasiMahasiswaPindahanController extends Controller

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
            'tbl_daftar.*',
            'tbl_prodi.*',
            'tbl_waktu_kuliah.*',
            'tbl_biaya_pindahan.*',
            'tbl_daftar_pindahan_pembayaran.*',
            'm_promo.*',
            'm_mahasiswa.nim',
        ])->leftjoin('tbl_daftar_pindahan_pembayaran', 'tbl_daftar.id_daftar', 'tbl_daftar_pindahan_pembayaran.id_daftar')->leftjoin('tbl_biaya_pindahan', 'tbl_daftar_pindahan_pembayaran.id_biaya', 'tbl_biaya_pindahan.id_biaya')->leftjoin('m_promo', 'tbl_daftar.id_promo', 'm_promo.id_promo')
            ->leftjoin('m_mahasiswa','tbl_daftar.id_daftar', 'm_mahasiswa.id_daftar' )
            ->leftjoin('tbl_prodi','tbl_daftar.id_prodi', 'tbl_prodi.id_prodi' )
            ->leftJoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', '=', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->where('tbl_daftar.id_status', '6')->groupBy('tbl_daftar.id_daftar')->where('tbl_daftar.is_delete', 'N')->get() as $list)

        {
            
            


            if($list->status_pembayaran  == 'Belum Lunas')

            {

                if($list->bayar_masuk >= $list->minimal && $list->bayar_masuk <= $list->biaya)

                {

                    $aksi = '<a href="'.route('admin.pindahan.registrasi.index', $list->id_daftar).'" class="btn btn-success btn-sm"><i class="fa fa-sign-in"></i></a>';

                }

                else

                {

                    $aksi = '<a href="#" class="btn btn-success btn-sm" disabled><i class="fa fa-sign-in"></i></a>';

                }

            }

            else if ($list->status_pembayaran  == 'Lunas') 
            {
                $aksi = '<a href="'.route('admin.pindahan.registrasi.index', $list->id_daftar).'" class="btn btn-success btn-sm"><i class="fa fa-sign-in"></i></a>';
                
            }
            
            else

            {

                $aksi = '<a href="#" class="btn btn-success btn-sm" disabled><i class="fa fa-sign-in"></i></a>';

            }
            
            if (empty($list->status_pembayaran)) $aksi = '<a href="#" class="btn btn-success btn-sm" disabled><i class="fa fa-sign-in"></i></a>';
            
            
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

            $row['nim'] = $list->nim;

            $row['nama'] = $list->nama;

            $row['prodi'] = $list->nama_prodi;
            
            $row['wakul'] = $list->nama_waktu_kuliah;

            $row['status'] = '<strong class="text-success">'.$list->status_pembayaran.'</strong>';
            
            $row['sisa'] = number_format($list->biaya - $list->bayar_masuk);

            $row['aksi'] = $aksi;

            $data[] = $row;

            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }



    public function registrasi($id)

    {

        $daftar = Pendaftaran::find($id);
        
        $dosen = Dosen::orderBy('nama', 'ASC')->pluck('nama', 'nip');

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

            $nim = substr($daftar->tahun_akademik, 2, 2).$daftar->id_jenjang.substr($daftar->id_prodi, 0, 2).'6'.$num.$nim_old;

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

        $biodata['id_prodi'] = substr($req->id_prodi, 0,3);

        $biodata['id_waktu_kuliah'] = substr($req->id_waktu_kuliah, 0,1);

        $biodata['id_prov'] = $req->id_provinsi;

        $biodata['id_status'] = $daftar->id_status;

        $biodata['id_jenjang'] = $daftar->id_jenjang;

        $biodata['password'] = $system->encrypt('123', $req->nim, $req->nim);

        $biodata['auth'] = $system->encrypt('123', $req->nim, $req->nim);

        $biodata['crated_by'] = Auth::guard('admin')->user()->nama;



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

        $daftar->update(['registration' => 'T']);

        

        Session::flash('success', $req->nama.' Berhasil Diregistrasikan');



        return redirect()->route('admin.pindahan.registrasi');

    }

}

