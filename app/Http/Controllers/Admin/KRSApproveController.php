<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use DataTables;

use App\KRS;
use App\KRSItem;
use App\Kelas;
use App\Mahasiswa;
use App\KelasDetailRemedial;

class KRSApproveController extends Controller
{
    public function datatable()
    {
        $krs = KRS::select([
                't_krs.id_krs',
                't_krs.file_surat',
                DB::raw("CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) as nim_nama"),
                DB::raw("CONCAT(m_dosen.nip, ' - ', m_dosen.nama) as nip_nama"),
                't_tahun_akademik.keterangan'
            ])
            ->leftJoin('m_mahasiswa', 't_krs.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_dosen', 'm_mahasiswa.nip', '=', 'm_dosen.nip')
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', '=', 't_tahun_akademik.tahun_akademik')
            ->whereNull('t_krs.status')
            ->where('t_krs.is_delete', 'N')
            ->orderBy('t_krs.id_krs', 'ASC')
            ->groupBy('t_krs.nim')
            ->groupBy('t_krs.tahun_akademik')
            ->get();
        
        $data = array();
        $no = 1;

        foreach ($krs as $list)
        {
            $data[] = [
                'no' => $no++,
                'id_krs' => $list->id_krs,
                'nim_nama' => $list->nim_nama,
                'nip_nama' => ! empty($list->nip_nama) ? $list->nip_nama : '<span class="text-danger">Belum ada Dosen PA</span>',
                'tahun_akademik' => $list->keterangan,
                'aksi' => ! empty($list->nip_nama) ? '
                    <a href="'.route('admin.krs.approve.approve', $list->id_krs).'" class="btn btn-success btn-sm" onClick="return confirm_approve()"><i class="fa fa-check"></i> Approve</a>
                    <button type="button" value="'.$list->id_krs.'" data-loading-text="Loading..." class="btn btn-danger btn-sm btn-tolak"><i class="fa fa-remove"></i> Tolak</button>
                    <button type="button" value="'.$list->id_krs.'" data-loading-text="Loading..." class="btn btn-primary btn-sm btn-detail"><i class="fa fa-search"></i> Detail KRS</button>
                    '.(! empty($list->file_surat) ? '<a href="'.url('/files/surat/'.$list->file_surat).'" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-search"></i> Lihat Surat</a>' : '').'
                ' : ''
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function datatable_ulang_matkul()
    {
        /*
        $krs = KRS::select([
                't_krs.id_krs',
                DB::raw("CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) as nim_nama"),
                DB::raw("CONCAT(m_dosen.nip, ' - ', m_dosen.nama) as nip_nama"),
                't_tahun_akademik.keterangan'
            ])
            ->leftJoin('m_mahasiswa', 't_krs.nim', '=', 'm_mahasiswa.nim')
            ->leftJoin('m_dosen', 'm_mahasiswa.nip', '=', 'm_dosen.nip')
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', '=', 't_tahun_akademik.tahun_akademik')
            ->rightJoin('t_krs_item', 't_krs.id_krs', '=', 't_krs_item.id_krs')
            ->where([
                't_krs_item.is_repeat' => 1,
                't_krs_item.is_repeat_approved' => 0
            ])
            ->whereNotNull('t_krs.status')
            ->groupBy('t_krs.id_krs')
            ->orderBy('t_krs_item.id_krs_item', 'ASC')
            ->get();
        */
        $krs = DB::select("select `t_ulang_mk`.`id_krs`, 
                CONCAT(m_mahasiswa.nim, ' - ', m_mahasiswa.nama) as nim_nama, 
                CONCAT(m_dosen.nip, ' - ', m_dosen.nama) as nip_nama, 
                `t_tahun_akademik`.`keterangan` 
                from `t_ulang_mk` 
                left join `t_krs` on `t_ulang_mk`.`id_krs` = `t_krs`.`id_krs`
                left join `m_mahasiswa` on `t_ulang_mk`.`nim` = `m_mahasiswa`.`nim` 
                left join `m_dosen` on `m_mahasiswa`.`nip` = `m_dosen`.`nip` 
                left join `t_tahun_akademik` on `t_krs`.`tahun_akademik` = `t_tahun_akademik`.`tahun_akademik` 
                left join `t_krs_item` on `t_krs`.`id_krs` = `t_krs_item`.`id_krs` 
                where `t_ulang_mk`.`status` = 0 
                -- (`t_krs_item`.`is_repeat` = 1 and `t_krs_item`.`is_repeat_approved` = 0) 
                -- and 
                -- `t_krs`.`status` is not null 
                group by `t_krs`.`id_krs` 
                order by `t_krs_item`.`id_krs_item` asc");

        $data = array();
        $no = 1;

        foreach ($krs as $list)
        {
            $data[] = [
                'no' => $no++,
                'id_krs' => $list->id_krs,
                'nim_nama' => $list->nim_nama,
                'nip_nama' => ! empty($list->nip_nama) ? $list->nip_nama : '<span class="text-danger">Belum ada Dosen PA</span>',
                'tahun_akademik' => $list->keterangan,
                'aksi' => ! empty($list->nip_nama) ? '
                    <a href="'.route('admin.krs.approve.approve_ulang_matkul', $list->id_krs).'" class="btn btn-success btn-sm" onClick="return confirm_approve()"><i class="fa fa-check"></i> Approve</a>
                    <button type="button" value="'.$list->id_krs.'" data-loading-text="Loading..." class="btn btn-primary btn-sm btn-detail"><i class="fa fa-search"></i> Detail KRS</button>
                ' : ''
            ];
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.admin.krs.approve.index');
    }

    public function ulang_matkul()
    {
        return view('pages.admin.krs.approve.ulang_matkul.index');
    }

    public function approve($id)
    {
        $krs = KRS::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $krs->nim)->first();

        if ($mahasiswa->id_status != 6)
        {
            $kelas = Kelas::select([
                'm_kelas.id_kelas',
                DB::raw("(COUNT(DISTINCT m_kelas_detail.nim) >= m_kelas.kapasitas) AS isFull")
            ])
            ->leftJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
            ->where([
                'm_kelas.id_semester' => $krs->id_semester,
                'm_kelas.tahun_akademik' => $krs->tahun_akademik,
                'm_kelas.id_prodi' => $mahasiswa->id_prodi,
                'm_kelas.id_waktu_kuliah' => $krs->id_waktu_kuliah,
            ])
            ->having('isFull', '=', 0)
            ->groupBy('m_kelas.id_kelas')
            ->orderBy('m_kelas.kode_kelas', 'ASC')
            ->first();

            if (empty($kelas))
            {
                Session::flash('flash_message', 'Semua kelas sudah full.');

                return redirect()->back();
            }
            else
            {
                $kelas->kelas_detail()->create([
                    'nim' => $mahasiswa->nim
                ]);
            }
        }
        else
        {
            $krs_item = KRSItem::where([
                'id_krs' => $id,
                't_krs_item.is_repeat' => 0,
            ])
            ->get();
    
            foreach ($krs_item as $list)
            {
                $kelas_detail_remedial = KelasDetailRemedial::insert([
                    'id_kelas' => $list->id_kelas,
                    'id_matkul' => $list->id_matkul,
                    'nim' => $krs->nim
                ]);
            }
        }

        if (empty($krs->id_waktu_kuliah)) $krs->update(['id_waktu_kuliah' => $mahasiswa->id_waktu_kuliah]);

        $krs->update([
            'status' => 'Y'
        ]);

        $mahasiswa->update([
            'id_semester' => $mahasiswa->id_semester + 1,
		    'is_updated_information' => 'F'
        ]);

        Session::flash('flash_message', 'Berhasil di approve.');

        return redirect()->back();
    }

    public function approve_ulang_matkul($id)
    {
        /*
        $krs = KRS::findOrFail($id);

        $krs_item = KRSItem::where([
            'id_krs' => $id,
            't_krs_item.is_repeat' => 1,
            't_krs_item.is_repeat_approved' => 0
        ])
        ->get();

        foreach ($krs_item as $list)
        {
            $kelas_detail_remedial = KelasDetailRemedial::insert([
                'id_kelas' => $list->id_kelas,
                'id_matkul' => $list->id_matkul,
                'nim' => $krs->nim
            ]);

            KRSItem::where([
                'id_krs_item' => $list->id_krs_item
            ])->update([
                'is_repeat_approved' => 1
            ]);
        }
        */
        DB::select("INSERT INTO t_krs_item (id_krs, id_matkul, id_kelas)
                    SELECT u.id_krs, j.id_matkul, j.id_kelas
                    FROM t_ulang_mk u
                    LEFT JOIN t_jadwal j ON u.id_jadwal = j.id_jadwal
                    WHERE id_krs = ".$id);
        DB::table('t_ulang_mk')
            ->where('id_krs', $id)
            ->update(['status' => 1]);

        Session::flash('success', 'Berhasil di approve.');

        return redirect()->back();
    }

    public function get_detail_krs(Request $request)
    {
        $krs_item = KRSItem::select([
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            'm_matkul.sks',
            'm_kelas.nama_kelas'
        ])
        ->leftJoin('m_matkul', 't_krs_item.id_matkul', '=', 'm_matkul.id_matkul')
        ->leftJoin('m_kelas', 't_krs_item.id_kelas', '=', 'm_kelas.id_kelas')
        ->where([
            't_krs_item.id_krs' => $request->id_krs,
            't_krs_item.is_repeat' => 0
        ])
        // ->whereNull('t_krs_item.id_kelas')
        ->get();

        return response()->json(['status' => 'success', 'krs_item' => $krs_item]);
    }

    public function get_detail_krs_ulang_matkul(Request $request)
    {
        $krs_item = KRSItem::select([
            'm_matkul.kode_matkul',
            'm_matkul.nama_matkul',
            'm_matkul.sks',
            'm_kelas.nama_kelas',
        ])
        ->leftJoin('m_matkul', 't_krs_item.id_matkul', '=', 'm_matkul.id_matkul')
        ->leftJoin('m_kelas', 't_krs_item.id_kelas', '=', 'm_kelas.id_kelas')
        ->where([
            't_krs_item.id_krs' => $request->id_krs,
            't_krs_item.is_repeat' => 1,
            't_krs_item.is_repeat_approved' => 0
        ])
        ->get();

        return response()->json(['status' => 'success', 'krs_item' => $krs_item]);
    }

    public function krs_ditolak(Request $request)
    {
        $krs = KRS::findOrFail($request->id);
        
        $krs->update([
            'status' => 'N',
            'keterangan' => $request->keterangan
        ]);

        Session::flash('success', 'KRS berhasil ditolak.');
        
        return redirect()->back();
    }
}
