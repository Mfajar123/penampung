<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use File;
use Auth;
use Session;
use DB;
use DataTables;

use App\TahunAkademik;
use App\Ruang;
use App\MatkulPindahan;
use App\MatkulPindahanDetail;
use App\Mahasiswa;
use App\Matkul;
use App\Pendaftaran;


class MatkulPindahanController extends Controller
{
    public function datatables()
    {   
        $data = array();
        
        $no = 1;
        
        $matkul_pindahan = MatkulPindahan::select([
            'm_mahasiswa.nama',
            'm_mahasiswa.nim', 
            'tbl_matkul_pindahan.*',
            DB::raw("(SELECT COUNT(id_matkul) FROM tbl_detail_matkul_pindahan AS tmp WHERE tmp.id_matkul_pindahan = tbl_matkul_pindahan.id_matkul_pindahan and tbl_matkul_pindahan.is_delete = 'N') AS jumlah"),
            DB::raw("(SELECT SUM(sks) FROM tbl_detail_matkul_pindahan AS tmp WHERE tmp.id_matkul_pindahan = tbl_matkul_pindahan.id_matkul_pindahan and tbl_matkul_pindahan.is_delete = 'N') AS jumlah_sks")
            ])->leftjoin('m_mahasiswa', 'tbl_matkul_pindahan.nim', 'm_mahasiswa.nim')
            ->groupBy('tbl_matkul_pindahan.nim')
            ->get();

        foreach ($matkul_pindahan as $list) {
            $data[] = [
                'no' => $no++,
                'nama' => $list->nim . ' - ' . $list->nama,
                'jumlah_matkul' =>$list->jumlah,
                'jumlah_sks' => $list->jumlah_sks,
                
                'aksi' => "
                    <a href='".route('admin.matkul_pindahan.detail', [ $list->nim, $list->id_matkul_pindahan])."' class='btn btn-info btn-sm'><i class='fa fa-search'></i> Detail</a>
                    <a href='".route('admin.matkul_pindahan.destroy', $list->id_matkul_pindahan )."' class='btn btn-danger btn-sm'  ><i class='fa fa-trash'></i> Hapus</a>
                "
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.admin.matkul_pindahan.index');
    }

    public function buat()
    {
        $list_nama = Mahasiswa::where('id_status', 6)->where('is_delete', 'N')->select('nim', 'nama', DB::raw("CONCAT(nim, ' - ', nama) AS nim_nama"))->orderBy('nama', 'ASC')->pluck('nim_nama', 'nim');

        $list_matkul = Matkul::where('is_delete', 'N')->get();

        return view('pages.admin.matkul_pindahan.buat', compact('list_nama', 'list_matkul'));
    }
    
    

    public function simpan(Request $request)
    {

        $maba = $request->nim;
        $matkul = $request->id_matkul;
        $nilai = $request->nilai;
        
        $sks = $request->sks;
        
        $mp =  MatkulPindahan::create([ 'nim' => $maba, 'created_by' => Auth::guard('admin')->user()->nama, 'created_date' => date('Y-m-d H:i:s')]);
        
        $ulang = count($sks);
        

        for ($i=0; $i < $ulang ; $i++) { 

         $query_update = MatkulPindahanDetail::create([ 'id_matkul_pindahan' => $mp->id_matkul_pindahan , 'id_matkul' => substr($matkul[$i], 3), 'sks' => $sks[$i], 'nilai' => $nilai[$i] ]);
        }

        Session::flash('flash_message', 'Matkul Pindahan berhasil disimpan.');

        return redirect()->route('admin.matkul_pindahan');
    }
    
    public function ubah($imp, $idmp, $nim)
    {
        $matkul_pindahan = MatkulPindahan::find($imp);
        
        $mp = MatkulPindahanDetail::find($idmp);
        
        $count = MatkulPindahanDetail::where('id_matkul_pindahan', $imp)->count();
    
    
        $list_matkul = Matkul::where('m_matkul.is_delete', 'N')->get();
    
        $list_nama = Mahasiswa::where('id_status', 6)->where('is_delete', 'N')->select('nim', 'nama')->orderBy('nama', 'ASC')->pluck('nama', 'nim');

        return view('pages.admin.matkul_pindahan.edit', compact('matkul_pindahan', 'imp', 'idmp', 'nim', 'list_nama', 'list_matkul', 'matkul_select', 'mp', 'count'));
    }
    
    public function perbarui($imp, $idmp, $nim, Request $request)
    {
        $maba = $request->nim;
        $matkul = $request->id_matkul;
        $sks = $request->sks;
         $nilai = $request->nilai;
        
        
        $input = MatkulPindahan::find($imp)->update(['nim' => $maba , 'updated_by' => Auth::guard('admin')->user()->nama, 'updated_date' => date('Y-m-d H:i:s') ]);
        
        $ulang = count($sks);
        

        for ($i=0; $i < $ulang ; $i++) { 

         $update = MatkulPindahanDetail::find($idmp)->update([ 'id_matkul_pindahan' => $imp, 'id_matkul' => substr($matkul[$i], 3), 'sks' => $sks[$i], 'nilai' => $nilai[$i]  ]);
        }
        
       

        Session::flash('flash_message', 'Matkul Pindahan berhasil disimpan.');

        return redirect()->route('admin.matkul_pindahan.detail', [$nim, $imp]);
    }

    public function detail($id, $kd)
    {
        $dm = MatkulPindahan::leftjoin('m_mahasiswa', 'tbl_matkul_pindahan.nim', 'm_mahasiswa.nim')
                            ->leftjoin('tbl_mahasiswa_status', 'tbl_mahasiswa_status.id_status', 'm_mahasiswa.id_status')
                            ->leftjoin('tbl_prodi', 'tbl_prodi.id_prodi', 'm_mahasiswa.id_prodi')
                            ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah')
                            ->find($kd);

        // $mp = MatkulPindahan::leftjoin('m_mahasiswa', 'tbl_matkul_pindahan.nim', 'm_mahasiswa.nim')
        //                     ->leftjoin('tbl_detail_matkul_pindahan', 'tbl_matkul_pindahan.id_matkul_pindahan', 'tbl_detail_matkul_pindahan.id_matkul_pindahan')
        //                     ->leftjoin('m_matkul', 'm_matkul.id_matkul', 'tbl_detail_matkul_pindahan.id_matkul')
        //                     ->where('tbl_matkul_pindahan.nim', $id)
        //                     ->get();

        $mp = MatkulPindahan::select([
            'tbl_matkul_pindahan.id_matkul_pindahan',
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            'tbl_detail_matkul_pindahan.sks',
            'tbl_detail_matkul_pindahan.nilai'
        ])
        ->leftjoin('tbl_detail_matkul_pindahan', 'tbl_matkul_pindahan.id_matkul_pindahan', 'tbl_detail_matkul_pindahan.id_matkul_pindahan')
        ->leftJoin('m_matkul', 'tbl_detail_matkul_pindahan.id_matkul', 'm_matkul.id_matkul')
        ->where([
            'tbl_matkul_pindahan.id_matkul_pindahan' => $kd,
            'tbl_matkul_pindahan.nim' => $id
        ])
        ->get();

        return view('pages.admin.matkul_pindahan.detail', compact('mp', 'dm'));
    }

    public function mahasiswa()
    {
        $kd = Auth::guard('mahasiswa')->user()->id_mahasiswa;
        $dm = Mahasiswa::leftjoin('tbl_mahasiswa_status', 'tbl_mahasiswa_status.id_status','m_mahasiswa.id_status')
                        ->leftjoin('tbl_prodi', 'tbl_prodi.id_prodi', 'm_mahasiswa.id_prodi')
                        ->leftjoin('tbl_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah', 'm_mahasiswa.id_waktu_kuliah')
                        ->find($kd);

       
        $id = $dm->nim ;

        $mp = MatkulPindahan::leftjoin('tbl_detail_matkul_pindahan', 'tbl_detail_matkul_pindahan.id_matkul_pindahan', 'tbl_matkul_pindahan.id_matkul_pindahan')->leftjoin('m_matkul', 'tbl_detail_matkul_pindahan.id_matkul', 'm_matkul.id_matkul')->leftjoin('m_mahasiswa', 'tbl_matkul_pindahan.nim', 'm_mahasiswa.nim')->where('tbl_matkul_pindahan.nim', $id)->get();
        
        return view('pages.mahasiswa.matkul_pindahan.index', compact('mp', 'dm'));
    }

   public function hapus($id)
    {
        
        $DMP = MatkulPindahanDetail::find($id);
        $DMP->delete();

        Session::flash('flash_message', 'Matkul Pindahan berhasil dihapus.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $matkul_pindahan = MatkulPindahan::find($id);
        $matkul_pindahan->delete();

        $DMP = MatkulPindahanDetail::where('id_matkul_pindahan', $id);
        $DMP->delete();

        Session::flash('flash_message', 'Matkul Pindahan berhasil dihapus.');

        return redirect()->back();
    }
}
