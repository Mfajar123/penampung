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

use App\DosenJabatan;

class AdminDosenJabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $req)
    {
        $data = array();
        $no = 1;

        if(!empty($req->segment(4)))
        {
            $jabatan = DosenJabatan::where('is_delete', 'Y')->get();
        }
        else
        {
            $jabatan = DosenJabatan::where('is_delete', 'N')->get();
        }
        foreach ($jabatan as $list)
        {
            $toTrash = "'Anda Yakin Akan Menghapus Jabatan ".$list->nama."'";
            $hapus = "'Anda Yakin Akan Menghapus Permanen Jabatan ".$list->nama."'";
            $restore = "'Anda Yakin Akan Mengembalikan Data Jabatan ".$list->nama."'";

            $row = array();
            $row['no'] = $no;
            $row['id_dosen_jabatan'] = $list->id_dosen_jabatan;
            $row['nama'] = $list->nama;
            $row['tunjangan_jabatan'] = $list->tunjangan_jabatan;
            $row['tunjangan_sks'] = $list->tunjangan_sks;
            $row['jumlah_komulatif_maksimal'] = $list->jumlah_komulatif_maksimal;
            if(!empty($req->segment(4)))
            {
                $row['aksi'] =
                '<a href="'.route('admin.dosen_jabatan.restore', $list->id_dosen_jabatan).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
                <a href="'.route( 'admin.dosen_jabatan.hapus.permanent', $list->id_dosen_jabatan).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';
            }
            else
            {
                $row['aksi'] =
                '
                <a href="'.route('admin.dosen_jabatan.ubah', $list->id_dosen_jabatan).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.dosen_jabatan.hapus', $list->id_dosen_jabatan).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';
            }

            $data[] = $row;
            $no++;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function trash()
    {
        return view('pages.admin.dosen_jabatan.trash');
    }

    public function tambah()
    {
        return view('pages.admin.dosen_jabatan.tambah');
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        $input['create_by'] = Auth::guard('admin')->user()->nama;
        $input['create_date'] = date('Y-m-d H:i:s');
        DosenJabatan::create($input);
        Session::flash('success', 'Dosen Jabatan Berhasil Ditambahkan');

        return redirect()->route('admin.dosen_jabatan');
    }

    public function ubah($id)
    {
        $jabatan = DosenJabatan::find($id);
        return view('pages.admin.dosen_jabatan.ubah', compact('jabatan', 'id'));
    }

    public function perbarui($id, Request $request)
    {
        $jabatan = DosenJabatan::find($id);

        $input = $request->all();
        $input['update_by'] = Auth::guard('admin')->user()->nama;
        $input['update_date'] = date('Y-m-d H:i:s');

        $jabatan->update($input);
        Session::flash('success', 'Data Dosen Jabatan Berhasil Diperbarui.');

        return redirect()->route('admin.dosen_jabatan');
    }

    public function toTrash($id)
    {
        DosenJabatan::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);

        Session::flash('fail', 'Data Dosen Jabatan Berhasil Dihapus.');

        return redirect()->route('admin.dosen_jabatan');
    }

    public function restore($id)
    {
        DosenJabatan::find($id)->update(['is_delete' => 'N']);

        Session::flash('success', 'Data Dosen Jabatan Berhasil Dikembalikan.');

        return redirect()->route('admin.dosen_jabatan.trash');
    }

    public function hapus($id)
    {
        $jabatan = DosenJabatan::find($id);

        $jabatan->delete();

        Session::flash('success', 'Data Dosen Jabatan Berhasil Dihapus');

        return redirect()->route('admin.dosen_jabatan.trash');
    }
}
