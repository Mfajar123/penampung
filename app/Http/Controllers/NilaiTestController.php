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

use App\PendaftaranNilai;
use App\Pendaftaran;
use App\KategoriPembayaran;
use App\PendaftaranPembayaran;

class NilaiTestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable(Request $req)
    {
        $data = array();
        $no = 1;

        foreach (Pendaftaran::where('is_delete', 'N')->leftjoin('tbl_daftar_nilai', 'tbl_daftar.id_daftar', '=', 'tbl_daftar_nilai.id_daftar')->where('id_status', 2)->orderBy('created_at', 'DESC')->groupBy('tbl_daftar.id_daftar')->get() as $list)
        {
            if(!empty($list->nilai) || $list->bayar < 250000)
            {
                $nilai = '<a href="#" class="btn btn-success btn-sm" title="Masukkan Nilai" disabled><i class="fa fa-edit"></i></a>';
            }
            else
            {
                $nilai = '<a href="'.route('admin.nilai.ubah', $list->id_daftar).'" class="btn btn-success btn-sm" title="Masukkan Nilai"><i class="fa fa-edit"></i></a>';
            }

            if(!empty($list->status))
            {
                if($list->status == 'Lulus')
                {
                    $status = '<strong class="text-success">Lulus</strong>';
                }
                else
                {
                    $status = '<strong class="text-danger">Tidak Lulus</strong>';
                }
            }
            else
            {
                $status = '';
            }

            

            $row = array();
            $row['no'] = $no;
            $row['id_daftar'] = $list->id_daftar;
            $row['akademik'] = $list->tahun_akademik;
            $row['nama'] = $list->nama;
            $row['prodi'] = $list->prodi->nama_prodi;
            $row['nilai'] = $list->nilai;
            $row['status'] = $status;
            $row['aksi'] = $nilai;

            $data[] = $row;
            $no++;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function nilai($id)
    {
        $daftar = Pendaftaran::leftjoin('t_tahun_akademik', 'tbl_daftar.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->leftjoin('tbl_waktu_kuliah', 'tbl_daftar.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
            ->find($id);

        return view('pages.admin.mahasiswa.nilai.nilai', compact('daftar', 'id'));
    }

    public function perbarui($id, Request $req)
    {
        $calon = Pendaftaran::find($id);
        $input = $req->all();

        $kategori = KategoriPembayaran::where(['id_waktu_kuliah' => $calon->id_waktu_kuliah, 'tahun_akademik' => $calon->tahun_akademik, 'id_prodi' => $calon->id_prodi])->where('nilai_terendah', '<=', $req->nilai)->where('nilai_tertinggi', '>=', $req->nilai)->first();

        if(empty($kategori))
        {
            Session::flash('fail', 'Tidak Ditemukan Kategori Pembayaran Yang Sesuai !');

            return redirect()->back()->withInput($input);
        }
        else
        {
            if(substr($kategori->kode_kategori, 0, 1) == 'T')
            {
                $status = 'Lulus';
            }
            else
            {
                $status = 'Tidak Lulus';
            }

            if($req->nilai >= $kategori->nilai_terendah && $req->nilai <= $kategori->nilai_tertinggi)
            {
                $kode = $kategori->id_daftar_kategori;
            }
            
            PendaftaranNilai::where('id_daftar', $id)->update(['nilai' => $req->nilai, 'status' => $status]);
            PendaftaranPembayaran::create([ 'id_daftar' => $id, 'id_daftar_kategori' => $kode ]);

            Session::flash('success', 'Nilai Berhasil Ditambahkan');

            return redirect()->route('admin.nilai');
        }
    }
}
