<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use DataTables;

use App\KRS;
use App\KRSItem;
use App\Mahasiswa;
use App\KelasDetail;
use App\KelasDetailRemedial;
use App\WaktuKuliah;

class KRSRollbackController extends Controller
{
    public function datatable()
    {
        $data = array();
        $no = 1;

        // ambil tahun akademik terakhir dari KRS yang terakhir kali diinput
        $tahun_akademik = KRS::select([
            'tahun_akademik'
        ])
        ->orderBy('tahun_akademik', 'DESC')
        ->pluck('tahun_akademik')
        ->first();
        
        // tampilkan krs berdasarkan tahun akademik terakhir
        $krs = KRS::select([
            't_krs.id_krs',
            't_krs.nim',
            'm_mahasiswa.nama',
            't_tahun_akademik.keterangan',
            'tbl_waktu_kuliah.nama_waktu_kuliah',
            't_krs.status'
        ])
        ->leftJoin('m_mahasiswa', 't_krs.nim', 'm_mahasiswa.nim')
        ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', 't_tahun_akademik.tahun_akademik')
        ->leftJoin('tbl_waktu_kuliah', 't_krs.id_waktu_kuliah', 'tbl_waktu_kuliah.id_waktu_kuliah')
        ->where([
            't_krs.tahun_akademik' => $tahun_akademik,
            't_krs.status' => 'Y'
        ])
        ->orderBy('t_krs.id_krs', 'ASC')
        ->get();

        foreach ($krs as $list)
        {
            // tampung data krs ke array data
            $data[] = array(
                'no' => $no++,
                'nim_nama' => $list->nim.' - '.$list->nama,
                'keterangan' => $list->keterangan,
                'nama_waktu_kuliah' => $list->nama_waktu_kuliah,
                'status' => '<strong>'.(empty($list->status) ? '<span class="text-danger">Belum diapprove</span>' : '<span class="text-success">Sudah diapprove</span>').'</strong>',
                'aksi' => '
                    <button type="button" value="'.$list->id_krs.'" class="btn btn-warning btn-sm btn-rollback"><i class="fa fa-repeat"></i> Rollback</button>
                    <button type="button" value="'.$list->id_krs.'" class="btn btn-primary btn-sm btn-detail"><i class="fa fa-search"></i> Detail</button>
                '
            );
        }

        // genereate datatable
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        $list_waktu_kuliah = WaktuKuliah::select([
            'id_waktu_kuliah',
            'nama_waktu_kuliah'
        ])
        ->pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        return view('pages.admin.krs.rollback.index', compact('list_waktu_kuliah'));
    }

    // fungsi ini digunakan untuk mencari waktu kuliah dari mahasiwa tersebut
    public function get_watku_kuliah(Request $request)
    {
        $krs = KRS::findOrFail($request->id_krs);
        $mahasiswa = Mahasiswa::where([
            'nim' => $krs->nim
        ])
        ->first();

        return response()->json(['status' => 'success', 'id_waktu_kuliah' => $mahasiswa->id_waktu_kuliah]);
    }

    // fungsi ini digunakan untuk melakukan rollback mata kulioh / krs
    public function rollback(Request $request)
    {
        $krs = KRS::findOrFail($request->id);
        $mahasiswa = Mahasiswa::where([
            'nim' => $krs->nim
        ])
        ->first();

        // update waktu kuliah mahasiswa, karena di formnya dapat mengubah waktu kuliah
        // dan cek juga, apakah krs tersebut sudah di approve atau belum
        // jika belum, maka semester pada mahasiswa tidak perlu di rollback
        if ($krs->status !== 'Y')
        {
            $mahasiswa->update([
                'id_waktu_kuliah' => $request->id_waktu_kuliah,
            ]);
        }
        else
        {
            // jika sudah diapprove, maka semester pada mahasiswa tersebut harus dirollback ke semester sebelumnya
            // karena krs tersebut sudah diapprove, dia sudah naik ke semester berikutnya
            $mahasiswa->update([
                'id_waktu_kuliah' => $request->id_waktu_kuliah,
                'id_semester' => $mahasiswa->id_semester - 1
            ]);

            // hapus mahasiswa tersebut dari kelas
            // karena ketika krs dia sudah diapprove, maka dia sudah masuk/mendapatkan kelas
            // oleh karena itu, harus dihapus datanya dari detail kelas & detail kelas remedial
            $delete_kelas_detail = KelasDetail::leftJoin('m_kelas', 'm_kelas_detail.id_kelas', 'm_kelas.id_kelas')
            ->where([
                'm_kelas_detail.nim' => $krs->nim,
                'm_kelas.tahun_akademik' => $krs->tahun_akademik
            ])
            ->delete();

            $delete_kelas_detail_remedial = KelasDetailRemedial::leftJoin('m_kelas', 'm_kelas_detail_remedial.id_kelas', 'm_kelas.id_kelas')
            ->where([
                'm_kelas_detail_remedial.nim' => $krs->nim,
                'm_kelas.tahun_akademik' => $krs->tahun_akademik
            ])
            ->delete();
        }

        // hapus krs item berdasarkan id krs
        $delete_krs_item = KRSItem::where([
            'id_krs' => $krs->id_krs
        ]);

        // hapus krs berdasarkan id krs
        $krs->delete();

        // tampilkan alert success
        Session::flash('success', 'Data berhasil dirollback.');
        
        // redirect ke halaman rollback
        return redirect()->route('admin.krs.rollback.index');
    }
}
