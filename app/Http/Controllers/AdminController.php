<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Mahasiswa;
use App\Pendaftaran;
use App\Prodi;
use App\Matkul;
use App\Dispensasi;
use App\Dosen;
use App\InfoWeb;
use App\KategoriInfo;
use App\Pesan;

class AdminController extends Controller
{
    function __construct(Request $req)
    {
        $this->middleware('auth:admin');
    }

     function index()
    {
        $mahasiswa = Mahasiswa::where('is_delete', 'N')->count();

        $dosen = Dosen::where('is_delete', 'N')->count();

        $karyawan = Admin::where('is_delete', 'N')->count();

        $pendaftar = Pendaftaran::where('is_delete', 'N')->count();

        $notif_dispen = Dispensasi::leftJoin('tbl_daftar', 'tbl_dispensasi.id_daftar',  'tbl_daftar.id_daftar')
                        ->where('status', 'Belum bayar')
                        ->where('tbl_dispensasi.is_delete', 'N')
                        ->get();


        $tanggal = date('Y-m-d');
        


        return view('pages.home', compact('mahasiswa', 'dosen', 'karyawan', 'pendaftar', 'tanggal', 'notif_dispen'));
    }

    function mahasiswa()
    {
        $password = $system->crypt('cahyanto', 'd');
        return view('pages.admin.mahasiswa.index');
    }

    function prodi()
    {
        $prodi = Prodi::all();
        return view('pages.admin.prodi.index', compact('prodi'));
    }

    function matkul()
    {
        $no = 1;
        $matkul = Matkul::all();

        return view('pages.admin.matkul.index', compact('matkul', 'no'));
    }

    function karyawan()
    {
        return view('pages.admin.karyawan.index');
    }
    
    function dosen()
    {
        return view('pages.admin.dosen.index');
    }
    
    function dosen_jabatan()
    {
        return view('pages.admin.dosen_jabatan.index');
    }
    
    function ruang()
    {
        return view('pages.admin.ruang.index');
    }
    
     function infoweb()
    {
        return view('pages.admin.info.index');
    }
    
       function pengumuman()
    {
        return view('pages.admin.pengumuman.index');
    }

    function kategoriinfo()
    {
        return view('pages.admin.kategori_info.index');
    }
    
      function pesan()
    {
        return view('pages.admin.pesan.index');
    }

    
    function promo()
    {
        return view('pages.admin.promo.index');
    }
    
    function tahun_akademik()
    {
        return view('pages.admin.tahun_akademik.index');
    }
    
    function daftar()
    {
        return view('pages.admin.mahasiswa.daftar.index');
    }

    function nilai()
    {
        return view('pages.admin.mahasiswa.nilai.index');
    }

    function kategori_pembayaran_kelulusan()
    {
        return view('pages.admin.pembayaran.index');
    }

    function kategori_pembayaran_pindahan()
    {
        return view('pages.admin.pembayaran.pindahan.index');
    }

    function pembayaran_kelulusan()
    {
        return view('pages.admin.mahasiswa.pembayaran.index');
    }

    function maba()
    {
        return view('pages.admin.mahasiswa.registrasi.index');
    }

    function transkrip_nilai_pindahan()
    {
        return view('pages.admin.mahasiswa.pindahan.transkrip.index');
    }

    function pembayaran_masuk_pindahan()
    {
        return view('pages.admin.mahasiswa.pindahan.pembayaran.index');
    }

    function regis_pindahan()
    {
        return view('pages.admin.mahasiswa.pindahan.registrasi.index');
    }
    
    
    function password(Request $req)
    {
        $system = New SystemController();
        $route = 'admin.password.ubah';
        $id = Auth::guard('admin')->user()->id_admin;

        $profil = Admin::find($id);

        if(empty($system->crypt($profil->password, 'd')))
        {
            $password = $profil->password;
        }
        else
        {
            $password = $system->crypt($profil->password, 'd');
        }
        return view('pages.profil.password', compact('system', 'route', 'id', 'profil', 'password'));
    }
}
