<?php

namespace App\Http\Controllers\SMK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use File;
use Auth;
use Captcha;
use Session;
use DB;
use DataTables;
use Storage;

use App\SMKInfo;
use App\Pesan;
use App\SMKKategoriInfo;

class SMKController extends Controller
{
    function index()
    {
        $info_list = SMKInfo::take(6)->skip(0)->orderBy('id_info', 'DESC')
                     ->where('is_delete', 'N')
                     ->where('id_kategori_info', '!=', '7')
                     ->get();
                
        $gallery_list = SMKInfo::take(3)->skip(0)->orderBy('id_info', 'DESC')
                    ->where('is_delete', 'N')
                     ->where('id_kategori_info', '4')->get();

        return view('pages.smk.web.beranda', compact('info_list', 'gallery_list'));
    }

    function guru()
    {
        $kepala_sekolah = SMKInfo::orderBy('id_info', 'ASC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Kepala Sekolah')
                         ->get();

        $wakasek           = SMKInfo::orderBy('id_info', 'DESC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Wakasek')
                         ->get();


    $tata_usaha           = SMKInfo::orderBy('id_info', 'ASC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Tata Usaha')
                         ->get(); 

    $kepala_bagian        = SMKInfo::orderBy('id_info', 'DESC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'KA')
                         ->get(); 

    $kaprog        = SMKInfo::orderBy('id_info', 'DESC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Kaprog')
                         ->get(); 
              

        $wali_kelas      = SMKInfo::orderBy('id_info', 'ASC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Wali Kelas')
                         ->get();

        $guru           = SMKInfo::orderBy('id_info', 'ASC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Guru')
                         ->get();

        $guru           = SMKInfo::orderBy('id_info', 'ASC')
                         ->where('is_delete', 'N')
                         ->where('id_kategori_info', '=', '7')
                         ->where('ringkasan_info', '=', 'Guru')
                         ->get();



        return view('pages.smk.web.guru', compact('kepala_sekolah', 'kepala_tata_usaha', 'kepala_bagian', 'wakasek', 'tata_usaha', 'bp', 'wali_kelas', 'guru', 'kaprog'));
    }

    function tentang_kami()
    {
        

        return view('pages.smk.web.tentang_kami');
    }

    function visimisi()
    {
        
        return view('pages.smk.web.visimisi');
    }

     function daftar_guru()
    {

        
        return view('pages.smk.web.guru');
    }

   

     function perpustakaan()
    {
        $perpustakaan_list = SMKInfo::where('judul_info', 'Perpustakaan')->get();

        return view('pages.smk.web.perpustakaan', compact('perpustakaan_list'));
    }

      function lab_komputer()
    {
        $lab_komputer = SMKInfo::where('judul_info', 'Lab Komputer')->get();

        return view('pages.smk.web.lab_komputer', compact('lab_komputer'));
    }

    function masjid()
    {
        $masjid_list = SMKInfo::where('judul_info', 'Masjid At-tin')->get();

        return view('pages.smk.web.masjid', compact('masjid_list'));
    }


    function free_wifi()
    {
        $free_wifi = SMKInfo::where('judul_info', 'Free Wifi')->get();

        return view('pages.smk.web.free_wifi', compact('free_wifi'));
    }

      function kantin()
    {
        $kantin = SMKInfo::where('judul_info', 'Kantin')->get();

        return view('pages.smk.web.kantin', compact('kantin'));
    }

      function ruang_kelas_ac()
    {
        $ruang_kelas_ac = SMKInfo::where('judul_info', 'Ruang Kelas Ber-AC')->get();

        return view('pages.smk.web.ruang_kelas_ac', compact('ruang_kelas_ac'));
    }


      function struktur()
    {
        $struktur = SMKInfo::where('judul_info', 'Struktur Organisasi SMK')->get();

        return view('pages.smk.web.struktur', compact('struktur'));
    }


      function kontak()
    {

        return view('pages.smk.web.kontak', compact('kontak'));
    }

    public function simpan(Request $request)
    {

     $recaptcha = new \ReCaptcha\ReCaptcha('6Le5eU0UAAAAABSRCNf0HO_c6A-PPw7_Zy-2fee7');
        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        if ($resp->isSuccess())
        {
            $captchas = new Captcha;
            $captchas = $request->all();
            $captchas['created_by'] = $request->nama;
            $captchas['created_date'] = date('Y-m-d H:i:s');
            $captchas['tanggal_pesan'] = NOW();
            Pesan::create($captchas);
           Session::flash('success', 'Pesan Berhasil Dikirim');
            return redirect()->route('web.kontak');
        }
        else
        {
            //$errors = $resp->getErrorCodes();
            
            Session::flash('fail', 'Gagal Mohon lengkapi form dengan Recaptcha yang tersedia');
            return redirect()->route('web.kontak');
        }
  
    }

    public function berita($id)
    {

        $info = SMKInfo::find($id); 

        $not = $info->id_info;
    
        $list = DB::select(DB::raw("SELECT * FROM m_info_smk WHERE is_delete = 'N' AND id_info != '$not' AND id_kategori_info != '7' LIMIT 3 "));

        return view('pages.smk.web.berita', compact('info', 'not', 'list' ));

    }
}
