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



use App\BiayaPindahan;

use App\TahunAkademik;



class BiayaPindahanController extends Controller

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

            $biaya = BiayaPindahan::where('is_delete', 'Y')->get();

        }

        else

        {

            $biaya = BiayaPindahan::where('is_delete', 'N')->get();

        }



        foreach ($biaya as $list)

        {

            $toTrash = "'Anda Yakin Akan Menghapus Pembayaran ".$list->nama_biaya."'";

            $hapus = "'Anda Yakin Akan Menghapus Permanen Pembayaran ".$list->nama_biaya."'";

            $restore = "'Anda Yakin Akan Memulihkan Pembayaran ".$list->nama_biaya."'";



            $row = array();

            $row['no'] = $no;

            $row['akademik'] = $list->tahun_akademik;

            $row['nama'] = $list->nama_biaya;

            $row['biaya'] = number_format($list->biaya);

            $row['minimal'] = number_format($list->minimal);

            if(!empty($req->segment(5)))

            {

                $row['aksi'] =

                '<a href="'.route('admin.pembayaran.pindahan.restore', $list->id_biaya).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')"><i class="fa fa-mail-reply"></i></a>

                <a href="'.route( 'admin.pembayaran.pindahan.hapus.permanen', $list->id_biaya).'" class="btn btn-danger btn-sm" title="Hapus Permanen" onclick="return confirm('.$hapus.')"><i class="fa fa-trash-o"></i></a>';

            }

            else

            {

                $row['aksi'] =

                    '<a href="'.route('admin.pembayaran.pindahan.ubah', $list->id_biaya).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>

                    <a href="'.route('admin.pembayaran.pindahan.hapus', $list->id_biaya).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';

            }



            $data[] = $row;

            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }



    public function trash()

    {

        return view('pages.admin.pembayaran.pindahan.trash');

    }



    public function tambah()

    {

        $akademik = TahunAkademik::where('status', 1)->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');



        return view('pages.admin.pembayaran.pindahan.tambah', compact('akademik'));

    }



    public function simpan(Request $req)

    {

        $input = $req->all();

        if($count = BiayaPindahan::count() >= 1)

        {

            $id = intval($count)+1;

        }

        else

        {

            $id = 1;

        }

        $input['created_by'] = Auth::guard('admin')->user()->nama;



        if(!empty($req->biaya))

        {

            $input['biaya'] = str_replace(',', '', $req->biaya);

        }



        if(!empty($req->minimal))

        {

            $input['minimal'] = str_replace(',', '', $req->minimal);

        }



        BiayaPindahan::create($input);

        Session::flash('success', $req->nama_biaya.' Behasil Ditambahkan');



        return redirect()->route('admin.pembayaran.pindahan');

    }



    public function ubah($id)

    {

        $biaya = BiayaPindahan::find($id);



        $akademik = TahunAkademik::where('status', 1)->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'tahun_akademik');



        return view('pages.admin.pembayaran.pindahan.ubah', compact('akademik', 'id', 'biaya'));

    }



    public function perbarui($id, Request $req)

    {

        $biaya = BiayaPindahan::find($id);



        $input = $req->all();

        if(!empty($req->biaya))

        {

            $input['biaya'] = str_replace(',', '', $req->biaya);

        }



        if(!empty($req->minimal))

        {

            $input['minimal'] = str_replace(',', '', $req->minimal);

        }



        $input['updated_by'] = Auth::guard('admin')->user()->nama;



        $biaya->update($input);



        Session::flash('success', $req->nama_biaya.' Behasil Diperbarui');



        return redirect()->route('admin.pembayaran.pindahan');

    }



    public function toTrash($id)

    {

        $biaya = BiayaPindahan::find($id);

        $biaya->update(['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::guard('admin')->user()->nama, 'is_delete' => 'Y']);



        Session::flash('success', $biaya->nama_biaya.' Berhasil Dihapus');



        return redirect()->route('admin.pembayaran.pindahan');

    }



    public function restore($id)

    {

        $biaya = BiayaPindahan::find($id);

        $biaya->update(['is_delete' => 'N']);



        Session::flash('success', $biaya->nama_biaya.' Berhasil Dipulihkan');



        return redirect()->route('admin.pembayaran.pindahan.trash');

    }



    public function hapus($id)

    {

        $biaya = BiayaPindahan::find($id);

        Session::flash('success', $biaya->nama_biaya.' Berhasil Dihapus Permanen');



        $biaya->delete();



        return redirect()->route('admin.pembayaran.pindahan.trash');

    }

}

