<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use DataTables;

use App\Shared_material;
use App\Prodi;

class SharedMaterialController extends Controller
{
    private function upload_material(Request $request)
    {
        $material = $request->file('file');
        $ext = $material->getClientOriginalExtension();

        if ($material->isValid()) {
            $material_name = date('YmdHis').'.'.$ext;
            $upload_path = 'files/materials';
            $material->move($upload_path, $material_name);

            return $material_name;
        } else {
            return false;
        }
    }

    public function datatable()
    {
        $data = array();
        $no = 1;

        $shared_material = DB::table('t_shared_material AS sm')
            ->select(
                'sm.id_shared_material',
                'p.kode_prodi',
                'p.nama_prodi',
                'sm.nama_materi',
                'sm.file'
            )
            ->leftJoin('tbl_prodi AS p', 'sm.id_prodi', '=', 'p.id_prodi')
            ->where('sm.id_dosen', '=', Auth::guard('dosen')->user()->id_dosen)
            ->get();
        
        foreach ($shared_material as $list) {
            $data[] = [
                'no' => $no++,
                'id_shared_material' => $list->id_shared_material,
                'nama_prodi' => $list->kode_prodi.' - '.$list->nama_prodi,
                'nama_materi' => $list->nama_materi,
                'file' => "<a href='".asset('files/materials/'.$list->file)."' class='btn btn-info btn-sm' target='_blank'><i class='fa fa-file-o'></i></a>",
                'aksi' => "
                    <a href='".route('dosen.shared_material.ubah', $list->id_shared_material)."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> Ubah</a>
                    <a href='".route('dosen.shared_material.hapus', $list->id_shared_material)."' class='btn btn-danger btn-sm'><i class='fa fa-edit'></i> Hapus</a>
                "
            ];
        }
        
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.dosen.shared_material.index');
    }

    public function tambah()
    {
        $list_prodi = Prodi::select('id_prodi', 'nama_prodi')->whereIn('nama_prodi', ['Manajemen', 'Akuntansi'])->pluck('nama_prodi', 'id_prodi');

        return view('pages.dosen.shared_material.tambah', compact('list_prodi'));
    }

    public function simpan(Request $request)
    {
        $input = $request->all();
        
        $input['id_dosen'] = Auth::guard('dosen')->user()->id_dosen;

        if ($request->hasFile('file')) {
            $input['file'] = $this->upload_material($request);
        }

        $shared_material = Shared_material::create($input);

        Session::flash('flash_message', 'Data berhasil disimpan.');

        return redirect()->route('dosen.shared_material');
    }

    public function ubah($id)
    {
        $shared_material = Shared_material::findOrFail($id);

        $list_prodi = Prodi::select('id_prodi', 'nama_prodi')->whereIn('nama_prodi', ['Manajemen', 'Akuntansi'])->pluck('nama_prodi', 'id_prodi');

        return view('pages.dosen.shared_material.ubah', compact('shared_material', 'list_prodi'));
    }

    public function perbarui($id, Request $request)
    {
        $shared_material = Shared_material::findOrFail($id);
        
        $input = $request->all();
        
        $input['id_dosen'] = Auth::guard('dosen')->user()->id_dosen;

        if ($request->hasFile('file')) {
            $input['file'] = $this->upload_material($request);
        }

        $shared_material->update($input);

        Session::flash('flash_message', 'Data berhasil diperbarui.');

        return redirect()->route('dosen.shared_material');
    }

    public function hapus($id)
    {
        $shared_material = Shared_material::findOrFail($id);
        
        $shared_material->delete();

        Session::flash('flash_message', 'Data berhasil diperbarui.');

        return redirect()->route('dosen.shared_material');
    }
}
