<?php

namespace App\Http\Controllers\SMP;

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

use App\SMPInfo;
use App\Pesan;
use App\SMPKategoriInfo;

class SMPController extends Controller
{
    function index()
    {
        $info_list = SMPInfo::take(8)->skip(0)->orderBy('id_info', 'DESC')
                     ->where('is_delete', 'N')
                     ->whereIn('id_kategori_info', [1, 2, 4])->get();
                
        $gallery_list = SMPInfo::take(8)->skip(0)->orderBy('id_info', 'DESC')
                    ->where('is_delete', 'N')
                     ->where('id_kategori_info', '6')->get();

        return view('pages.smp.web.beranda', compact('info_list', 'gallery_list'));
    }

    function sejarah()
    {

        return view('pages.smp.web.sejarah');
    }

    function tentang_kami()
    {
        

        return view('pages.smp.web.tentang_kami');
    }

    function visimisi()
    {
        
        return view('pages.smp.web.visimisi');
    }

     function struktur()
    {
  
        return view('pages.smp.web.struktur');
    }

     function perpustakaan()
    {
        $perpustakaan_list = SMPInfo::where('judul_info', 'Perpustakaan')->get();

        return view('pages.smp.web.perpustakaan', compact('perpustakaan_list'));
    }

      function lab_komputer()
    {
        $lab_komputer = SMPInfo::where('judul_info', 'Lab Komputer')->get();

        return view('pages.smp.web.lab_komputer', compact('lab_komputer'));
    }

    function masjid()
    {
        $masjid_list = SMPInfo::where('judul_info', 'Masjid At-tin')->get();

        return view('pages.smp.web.masjid', compact('masjid_list'));
    }

    function studio_musik()
    {
        $studio_musik = SMPInfo::where('judul_info', 'Studio Musik')->get();

        return view('pages.smp.web.studio_musik', compact('studio_musik'));
    }

    function free_wifi()
    {
        $free_wifi = SMPInfo::where('judul_info', 'Free Wifi')->get();

        return view('pages.smp.web.free_wifi', compact('free_wifi'));
    }

    function atm_center()
    {
        $atm_center = SMPInfo::where('judul_info', 'ATM Center')->get();

        return view('pages.smp.web.atm_center', compact('atm_center'));
    }

     function radio_ppi()
    {
        $radio_ppi = SMPInfo::where('judul_info', 'Radio PPI')->get();

        return view('pages.smp.web.radio_ppi', compact('radio_ppi'));
    }

      function kantin()
    {
        $kantin = SMPInfo::where('judul_info', 'Kantin')->get();

        return view('pages.smp.web.kantin', compact('kantin'));
    }

      function ruang_kelas_ac()
    {
        $ruang_kelas_ac = SMPInfo::where('judul_info', 'Ruang Kelas Ber-AC')->get();

        return view('pages.smp.web.ruang_kelas_ac', compact('ruang_kelas_ac'));
    }

      function kontak()
    {

        return view('pages.smp.web.kontak', compact('kontak'));
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

        $info = SMPInfo::find($id); 

        $not = $info->id_info;
    
        $list = DB::select(DB::raw("SELECT * FROM m_info_smp WHERE id_info != '$not' AND id_kategori_info = '1,2,3' LIMIT 3 "));

        return view('pages.smp.web.berita', compact('info', 'not', 'list' ));

    }
}
