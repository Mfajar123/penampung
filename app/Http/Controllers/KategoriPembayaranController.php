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







use App\KategoriPembayaran;



use App\TahunAkademik;



use App\Prodi;



use App\WaktuKuliah;







class KategoriPembayaranController extends Controller



{







    public function __construct()



    {



        $this->middleware('auth:admin');



    }







    public function datatable(Request $req)



    {



        $data = array();



        $no = 1;







        if(!empty($req->segment(5)))



        {



            $kategori = KategoriPembayaran::where('is_delete', 'Y')->orderBy('id_daftar_kategori', 'DESC')->get();



        }



        else



        {



            $kategori = KategoriPembayaran::where('is_delete', 'N')->orderBy('id_daftar_kategori', 'DESC')->get();



        }







        foreach ($kategori as $list)



        {



            $toTrash = "'Anda Yakin Akan Menghapus Pembayaran ".$list->kode_kategori." - ".$list->nama_kategori." ( ".$list->waktu_kuliah->nama_waktu_kuliah." )'";



            $hapus = "'Anda Yakin Akan Menghapus Permanen Pembayaran ".$list->kode_kategori." - ".$list->nama_kategori." ( ".$list->waktu_kuliah->nama_waktu_kuliah." )'";



            $restore = "'Anda Yakin Akan Memulihkan Pembayaran ".$list->kode_kategori." - ".$list->nama_kategori." ( ".$list->waktu_kuliah->nama_waktu_kuliah." )'";







            $row = array();



            $row['no'] = $no;



            $row['kode'] = $list->kode_kategori;



            $row['akademik'] = $list->tahun_akademik;



            $row['kategori'] = $list->nama_kategori;



            $row['prodi'] = $list->prodi->nama_prodi;



            $row['waktu_kuliah'] = $list->waktu_kuliah->nama_waktu_kuliah;



            $row['biaya'] = number_format($list->biaya);



            $row['potongan'] = number_format($list->potongan);



            $row['terendah'] = $list->nilai_terendah;



            $row['tertinggi'] = $list->nilai_tertinggi;



            if(!empty($req->segment(5)))



            {



                $row['aksi'] =



                '<a href="'.route('admin.pembayaran.restore', $list->id_daftar_kategori).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')"><i class="fa fa-mail-reply"></i></a>



                <a href="'.route( 'admin.pembayaran.hapus.permanen', $list->id_daftar_kategori).'" class="btn btn-danger btn-sm" title="Hapus Permanen" onclick="return confirm('.$hapus.')"><i class="fa fa-trash-o"></i></a>';



            }



            else



            {



                $row['aksi'] =



                    '<a href="'.route('admin.pembayaran.ubah', $list->id_daftar_kategori).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>



                    <a href="'.route('admin.pembayaran.hapus', $list->id_daftar_kategori).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';



            }







            $data[] = $row;



            $no++;



        }



        return DataTables::of($data)->escapeColumns([])->make(true);



    }







    public function trash()



    {



        return view('pages.admin.pembayaran.trash');



    }







    public function tambah()



    {



        $akademik = TahunAkademik::where('status', 1)->pluck('keterangan', 'tahun_akademik');



        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');



        $waktu = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');







        return view('pages.admin.pembayaran.tambah', compact('akademik', 'prodi', 'waktu'));



    }







    public function simpan(Request $req)



    {



        $input = $req->all();







        if(!empty($req->biaya))



        {



            $input['biaya'] = str_replace(',', '', $req->biaya);



        }



        else



        {



            $input['biaya'] = 0;



        }



        if(!empty($req->minimal_biaya))



        {



            $input['minimal_biaya'] = str_replace(',', '', $req->minimal_biaya);



        }



        else



        {



            $input['minimal_biaya'] = 0;



        }



        $input['created_by'] = Auth::guard('admin')->user()->nama;







        if($req->nama_kategori == 'Diterima')



        {



            $kd = 'T';



        }



        else



        {



            $kd = 'G';



        }







        if(KategoriPembayaran::where(['id_waktu_kuliah' => $req->id_waktu_kuliah, 'id_prodi' => $req->id_prodi])->where('kode_kategori', 'LIKE', $kd.'%')->count() > 0)



        {



            $kategori = KategoriPembayaran::where(['id_waktu_kuliah' => $req->id_waktu_kuliah, 'id_prodi' => $req->id_prodi])->where('kode_kategori', 'LIKE', $kd.'%')->orderBy('id_daftar_kategori', 'DESC')->first();







            $jumlah = intval(substr($kategori->kode_kategori, 1)) + 1;



            $kode_kategori = $kd.$jumlah;



        }



        else



        {



            $kode_kategori =  $kd.intval(1);



        }







        $input['kode_kategori'] = $kode_kategori;







        if(trim($req->potongan) == '')



        {



            $input['potongan'] = 0;



        }



        else



        {



            $input['potongan'] = str_replace(',', '', $req->potongan);



        }







        KategoriPembayaran::create($input);







        Session::flash('success', 'Kategori Pembayaran Behasil Ditambahkan');







        return redirect()->route('admin.pembayaran');



    }







    public function ubah($id)



    {



        $pembayaran = KategoriPembayaran::find($id);







        $akademik = TahunAkademik::where('status', 1)->pluck('keterangan', 'tahun_akademik');



        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');



        $waktu = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');







        return view('pages.admin.pembayaran.ubah', compact('akademik', 'prodi', 'waktu', 'pembayaran', 'id'));



    }







    public function perbarui($id, Request $req)



    {



        $pembayaran = KategoriPembayaran::find($id);







        $input = $req->all();







        if(!empty($req->biaya))



        {



            $input['biaya'] = str_replace(',', '', $req->biaya);



        }



        else



        {



            $input['biaya'] = 0;



        }



        if(!empty($req->minimal_biaya))



        {



            $input['minimal_biaya'] = str_replace(',', '', $req->minimal_biaya);



        }



        else



        {



            $input['minimal_biaya'] = 0;



        }



        $input['updated_by'] = Auth::guard('admin')->user()->nama;







        if($req->nama_kategori == 'Diterima')



        {



            $kd = 'T';



        }



        else



        {



            $kd = 'G';



        }







        if($req->id_prodi == $pembayaran->id_prodi && $req->id_waktu_kuliah == $pembayaran->id_waktu_kuliah && $req->nama_kategori == $pembayaran->nama_kategori)



        {



            $kode_kategori = $pembayaran->kode_kategori;



        }



        else



        {



            if(KategoriPembayaran::where(['id_waktu_kuliah' => $req->id_waktu_kuliah, 'id_prodi' => $req->id_prodi])->where('kode_kategori', 'LIKE', $kd.'%')->whereNotIn('id_daftar_kategori', [$pembayaran->id_daftar_kategori])->count() > 0)



            {



                $kategori = KategoriPembayaran::where(['id_waktu_kuliah' => $req->id_waktu_kuliah, 'id_prodi' => $req->id_prodi])->where('kode_kategori', 'LIKE', $kd.'%')->orderBy('id_daftar_kategori', 'DESC')->whereNotIn('id_daftar_kategori', [$pembayaran->id_daftar_kategori])->first();







                $jumlah = intval(substr($kategori->kode_kategori, 1)) + 1;



                $kode_kategori = $kd.$jumlah;



            }



            else



            {



                $kode_kategori =  $kd.intval(1);



            }



        }







        $input['kode_kategori'] = $kode_kategori;







        if(trim($req->potongan) == '')



        {



            $input['potongan'] = 0;



        }



        else



        {



            $input['potongan'] = str_replace(',', '', $req->potongan);



        }







        $pembayaran->update($input);







        Session::flash('success', 'Kategori Pembayaran Behasil Diperbarui');







        return redirect()->route('admin.pembayaran');



    }







    public function toTrash($id)



    {



        KategoriPembayaran::find($id)->update(['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::guard('admin')->user()->nama, 'is_delete' => 'Y']);



        Session::flash('success', 'Kategori Pembayaran Berhasil Dihapus');







        return redirect()->route('admin.pembayaran');



    }







    public function restore($id)



    {



        KategoriPembayaran::find($id)->update(['is_delete' => 'N']);



        Session::flash('success', 'Kategori Pembayaran Berhasil Dipulihkan');







        return redirect()->route('admin.pembayaran.trash');



    }







    public function hapus($id)



    {



        KategoriPembayaran::find($id)->delete();



        Session::flash('success', 'Kategori Pembayaran Berhasil Dihapus Permanen');







        return redirect()->route('admin.pembayaran.trash');



    }



}



