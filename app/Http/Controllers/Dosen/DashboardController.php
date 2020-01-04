<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                ['umumkan_ke', '!=', 'Mahasiswa'],
                'is_delete' => 'N'
            ])
            ->orderBy('waktu_pengumuman', 'DESC')
            ->take(5)
            ->skip(0)
            ->get();
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

    public function get_now_tahun_akademik()
    {
        $bulan = date('m');

        if ($bulan >= 02 and $bulan <= 07) {
            $tahun_lalu = date("Y") - 1;
            $belakang = "20";
            $tahun = $tahun_lalu.$belakang;
        } else {
            $tahun_sekarang = date("Y");
            $belakang = "10";
            $tahun = $tahun_sekarang.$belakang;
        }

        return $tahun;
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
        $day_name = $this->get_day_name(date('N'));

        $user = Auth::guard('dosen')->user();
        
        $list_jadwal = Jadwal::select([
                't_jadwal.jam_mulai',
                't_jadwal.jam_selesai',
                'm_matkul.kode_matkul',
                'm_matkul.nama_matkul',
                'm_ruang.kode_ruang',
                'm_ruang.nama_ruang',
                'm_kelas.kode_kelas',
                'm_kelas.id_prodi'
            ])
            ->leftJoin('m_kelas', 't_jadwal.id_kelas', 'm_kelas.id_kelas')
            ->leftJoin('m_matkul', 't_jadwal.id_matkul', 'm_matkul.id_matkul')
            ->leftJoin('m_ruang', 't_jadwal.id_ruang', 'm_ruang.id_ruang')
            ->where([
                't_jadwal.id_dosen' => $user->id_dosen,
                't_jadwal.tahun_akademik' => $tahun_akademik,
                't_jadwal.hari' => $day_name
            ])
            ->orderBy('t_jadwal.jam_mulai', 'asc')
            ->get();

        return $list_jadwal;
    }

    public function index()
    {
        $tahun_akademik = $this->get_now_tahun_akademik();
        $list_pengumuman = $this->get_pengumuman();
        $list_agenda = $this->get_agenda();
        $list_jadwal = $this->get_jadwal($tahun_akademik);

        return view('pages.dosen.dashboard.index', compact('list_pengumuman', 'list_agenda', 'list_jadwal'));
    }
}
