<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use File;
use Auth;
use ReCaptcha;
use Session;
use DB;
use DataTables;
use Storage;

use App\InfoWeb;
use App\Pesan;
use App\KategoriInfo;
use App\FotoPendukung;


class WebController extends Controller
{
    function index()
    {
    	$info_list = InfoWeb::take(4)->skip(0)->orderBy('id_info', 'DESC')
    				 ->whereIn('id_kategori_info', [1, 2, 3])
    				 ->where('is_delete', 'N')->get();
    			
    	$gallery_list = KategoriInfo::leftjoin('m_info', 'm_info.id_kategori_info', 'm_kategori_info.id_kategori_info')
    	               ->take(8)->skip(0)->orderBy('id_info', 'DESC')
    				 ->where('m_kategori_info.id_kategori_info', '5')
    				 ->where('m_info.is_delete', 'N')
    				 ->get();

        return view('pages.web.beranda', compact('info_list', 'gallery_list'));
    }

    function sejarah()
    {

    	return view('pages.web.sejarah');
    }

    function tentang_kami()
    {
    	

    	return view('pages.web.tentang_kami');
    }

    function visimisi()
    {
    	
    	return view('pages.web.visimisi');
    }

     function struktur()
    {
  
    	return view('pages.web.struktur');
    }

     function perpustakaan()
    {
    	$perpustakaan_list = InfoWeb::where('judul_info', 'Perpustakaan')->get();

    	return view('pages.web.perpustakaan', compact('perpustakaan_list'));
    }

      function lab_komputer()
    {
    	$lab_komputer = InfoWeb::where('judul_info', 'Lab Komputer')->get();

    	return view('pages.web.lab_komputer', compact('lab_komputer'));
    }

    function masjid()
    {
    	$masjid_list = InfoWeb::where('judul_info', 'Masjid At-tin')->get();

    	return view('pages.web.masjid', compact('masjid_list'));
    }

    function studio_musik()
    {
    	$studio_musik = InfoWeb::where('judul_info', 'Studio Musik')->get();

    	return view('pages.web.studio_musik', compact('studio_musik'));
    }

    function free_wifi()
    {
    	$free_wifi = InfoWeb::where('judul_info', 'Free Wifi')->get();

    	return view('pages.web.free_wifi', compact('free_wifi'));
    }

    function atm_center()
    {
    	$atm_center = InfoWeb::where('judul_info', 'ATM Center')->get();

    	return view('pages.web.atm_center', compact('atm_center'));
    }

     function radio_ppi()
    {
    	$radio_ppi = InfoWeb::where('judul_info', 'Radio PPI')->get();

    	return view('pages.web.radio_ppi', compact('radio_ppi'));
    }

      function kantin()
    {
    	$kantin = InfoWeb::where('judul_info', 'Kantin')->get();

    	return view('pages.web.kantin', compact('kantin'));
    }

      function ruang_kelas_ac()
    {
    	$ruang_kelas_ac = InfoWeb::where('judul_info', 'Ruang Kelas Ber-AC')->get();

    	return view('pages.web.ruang_kelas_ac', compact('ruang_kelas_ac'));
    }

      function kontak()
    {

    	return view('pages.web.kontak', compact('kontak'));
    }

    public function simpan(Request $request)
    {
        $captchas = $request->all();
        $captchas['created_by'] = $request->nama;
        $captchas['created_date'] = date('Y-m-d H:i:s');
        $captchas['tanggal_pesan'] = NOW();
        Pesan::create($captchas);
        Session::flash('success', 'Pesan Berhasil Dikirim');
        return redirect()->route('web.kontak');
  
    }

    public function berita($id)
    {

        $info = InfoWeb::find($id); 

        @$fotkung = FotoPendukung::where('id_info', $info->id_info)->get();

        $not = $info->id_info;
    
        $list = DB::select(DB::raw("SELECT * FROM m_info WHERE id_info != '$not' AND id_kategori_info = '1,2,3' LIMIT 3 "));

        return view('pages.web.berita', compact('info', 'not', 'list', 'fotkung' ));
    }
    
      public function semua_berita($info = null, Request $req)
    {


        if(!empty($req->search))
        {
            $info_list = InfoWeb::whereIn('id_kategori_info', [1, 2, 3])
                         ->where('is_delete', 'N')
                         ->where('judul_info', 'LIKE', '%'.$req->search.'%')
                         ->orderBy('id_info', 'DESC')
                         ->get();
            $search = $req->search;             
        }
        else
        {
            $info_list = InfoWeb::whereIn('id_kategori_info', [1, 2, 3])
                         ->where('is_delete', 'N')
                         ->orderBy('id_info', 'DESC')
                         ->get();
        }

        return view('pages.web.semua_berita', compact('info_list', 'search'));             
    }
	public function semua_gallery(){
        $gallery_list = KategoriInfo::join('m_info', 'm_info.id_kategori_info', 'm_kategori_info.id_kategori_info')
                       ->skip(0)->orderBy('id_info', 'DESC')
                     ->where('m_kategori_info.id_kategori_info', '5')
                     ->where('m_info.is_delete', 'N')
                     ->paginate(12);
        return view('pages.web.gallery',compact('gallery_list'));
    }
}
