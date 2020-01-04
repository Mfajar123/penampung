<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mahasiswa\PembayaranSPPController;

use DB;
use Auth;

use App\KRS;
use App\Agenda;
use App\Pengumuman;
use App\Jadwal;

class DashboardController extends Controller
{
    public function get_pengumuman()
    {
        return Pengumuman::where([
                ['umumkan_ke', '!=', 'Dosen'],
                'is_delete' => 'N'
            ])
            ->orderBy('waktu_pengumuman', 'DESC')
            ->take(5)
            ->skip(0)
            ->get();
    }

    public function get_now_tahun_akademik()
    {
        $user = Auth::guard('mahasiswa')->user();

        $krs = KRS::select([
                't_tahun_akademik.*'
            ])
            ->leftJoin('t_tahun_akademik', 't_krs.tahun_akademik', 't_tahun_akademik.tahun_akademik')
            ->where([
                't_krs.nim' => $user->nim,
                't_krs.is_delete' => 'N',
                't_krs.status' => 'Y',
            ])
            ->orderBy('t_krs.tahun_akademik', 'DESC')
            ->first();

        return $krs;
    }

    public function get_pembayaran_spp($id_tahun_akademik)
    {
        $pembayaran_spp = new PembayaranSPPController();
        $tahun_akademik = $this->get_now_tahun_akademik();

        return $pembayaran_spp->get_pembayaran_spp($id_tahun_akademik)['pembayaran_spp'];
    }

    public function get_agenda()
    {
        $data = [];
        $list_agenda =  Agenda::where('is_delete', 'N')->get();
        
        foreach ($list_agenda as $agenda) {
            $data[] = [
                'title' => $agenda->judul,
                'start' => $agenda->tanggal_mulai,
                'end' => $agenda->tanggal_selesai
            ];
        }

        return $data;
    }

    public function get_day_name($n)
    {
        $day_name = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jum\'at',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        return $day_name[$n];
    }

    public function get_jadwal($tahun_akademik)
    {
        $user = Auth::guard('mahasiswa')->user();

        $day_name = $this->get_day_name(date('N'));

        $krs = KRS::where([
                'tahun_akademik' => $tahun_akademik,
                'nim' => $user->nim,
                'status' => 'Y'
            ])
            ->first();

        $krs_item = (! empty($krs) && $krs->krs_item()->count() > 0) ? $krs->krs_item()->pluck('id_matkul') : [];

        $list_jadwal = DB::table('t_jadwal AS j')
            ->select([
                'h.nama_hari',
                'j.jam_mulai',
                'j.jam_selesai',
                'r.kode_ruang',
                'r.nama_ruang',
                'k.kode_kelas',
                'k.nama_kelas',
                'm.kode_matkul',
                'm.nama_matkul',
                'm.sks',
                'k.id_prodi',
                'k.kode_kelas',
                'd.nama',
                'd.nip'
            ])
            ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
            ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
            ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
            ->leftJoin('m_kelas AS k', 'j.id_kelas', '=', 'k.id_kelas')
            ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
            ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
            ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
            ->rightJoin('m_kelas_detail AS kd', 'k.id_kelas', '=', 'kd.id_kelas')
            ->where([
                'j.tahun_akademik' => $tahun_akademik,
                'kd.nim' => $user->nim,
                'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah,
                'h.nama_hari' => $day_name
            ])
            ->whereIn('m.id_matkul', $krs_item)
            ->orderBy('h.id_hari', 'ASC')
            ->orderBy('j.jam_mulai', 'ASC')
            ->groupBy('m.kode_matkul')
            ->groupBy('j.jam_mulai')
            ->get();

        $list_jadwal_remedial = DB::table('m_kelas_detail_remedial AS kd')
            ->select([
                'h.nama_hari',
                'j.jam_mulai',
                'j.jam_selesai',
                'r.kode_ruang',
                'r.nama_ruang',
                'k.kode_kelas',
                'k.nama_kelas',
                'm.kode_matkul',
                'm.nama_matkul',
                'm.sks',
                'k.id_prodi',
                'k.kode_kelas',
                'd.nama',
                'd.nip'
            ])
            ->leftJoin('m_kelas AS k', 'kd.id_kelas', 'k.id_kelas')
            ->leftJoin('t_jadwal AS j', function ($join) {
                $join->on('j.id_kelas', 'kd.id_kelas');
                $join->on('j.id_matkul', 'kd.id_matkul');
            })
            ->leftJoin('t_tahun_akademik AS ta', 'j.tahun_akademik', '=', 'ta.tahun_akademik')
            ->leftJoin('m_hari AS h', 'j.hari', '=', 'h.nama_hari')
            ->leftJoin('tbl_semester AS s', 'j.id_semester', 's.id_semester')
            ->leftJoin('m_matkul AS m', 'j.id_matkul', '=', 'm.id_matkul')
            ->leftJoin('m_ruang AS r', 'j.id_ruang', '=', 'r.id_ruang')
            ->leftJoin('m_dosen AS d', 'j.id_dosen', '=', 'd.id_dosen')
            ->where([
                'j.tahun_akademik' => $tahun_akademik,
                'kd.nim' => $user->nim,
                'j.id_waktu_kuliah' => @$krs->id_waktu_kuliah,
                'h.nama_hari' => $day_name
            ])
            ->whereIn('kd.id_matkul', $krs_item)
            ->orderBy('h.id_hari', 'ASC')
            ->orderBy('j.jam_mulai', 'ASC')
            ->groupBy('kode_matkul')
            ->get();

        $list_jadwal = array_merge($list_jadwal->toArray(), $list_jadwal_remedial->toArray());
        $list_jadwal = json_decode(json_encode($list_jadwal), FALSE);

        return $list_jadwal;
    }

    public function index()
    {
        $list_pengumuman = $this->get_pengumuman();
        $tahun_akademik = $this->get_now_tahun_akademik();
        if (! empty($tahun_akademik)) {
            $list_pembayaran_spp = $this->get_pembayaran_spp($tahun_akademik->id_tahun_akademik);
            $list_jadwal = $this->get_jadwal($tahun_akademik->tahun_akademik);
        } else {
            $list_pembayaran_spp = [];
            $list_jadwal = [];
        }
        $list_agenda = $this->get_agenda();

        return view('pages.mahasiswa.dashboard.index', compact('list_pengumuman', 'tahun_akademik', 'list_pembayaran_spp', 'list_agenda', 'list_jadwal'));
    }
}
