<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Shared_material;
use App\Prodi;

class SharedMaterialController extends Controller
{
    public function index()
    {
        $list_shared_material = array();
        $list_prodi = Prodi::select('id_prodi', 'nama_prodi')->whereIn('nama_prodi', ['Manajemen', 'Akuntansi'])->pluck('nama_prodi', 'id_prodi');
        
        if (isset($_GET['id_prodi'])) {
            $list_shared_material = Shared_material::select(
                't_shared_material.nama_materi',
                'm_dosen.nama',
                't_shared_material.file'
            )
            ->leftJoin('m_dosen', 't_shared_material.id_dosen', '=', 'm_dosen.id_dosen')
            ->where('t_shared_material.id_prodi', '=', $_GET['id_prodi'])
            ->get();
        }

        return view('pages.mahasiswa.shared_material.index', compact('list_shared_material', 'list_prodi'));
    }
}
