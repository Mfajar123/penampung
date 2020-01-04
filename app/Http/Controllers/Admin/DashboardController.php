<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

use App\Agenda;
use App\Pendaftaran;
use App\Dispensasi;
use App\Mahasiswa;
use App\Dosen;
use App\Admin;

class DashboardController extends Controller
{
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

    public function get_notification_dispensasi()
    {
        return Dispensasi::leftJoin('tbl_daftar', 'tbl_dispensasi.id_daftar',  'tbl_daftar.id_daftar')
            ->where('status', 'Belum bayar')
            ->where('tbl_dispensasi.is_delete', 'N')
            ->get();
    }

    public function index()
    {
        $list_agenda = $this->get_agenda();
        $list_notification_dispensasi = $this->get_notification_dispensasi();
        $count_mahasiswa = Mahasiswa::where('is_delete', 'N')->count();
        $count_dosen = Dosen::where('is_delete', 'N')->count();
        $count_karyawan = Admin::where('is_delete', 'N')->count();
        $count_pendaftaran = Pendaftaran::where('is_delete', 'N')->count();
        $tanggal = date('Y-m-d');

        return view('pages.admin.dashboard.index', compact('list_agenda', 'list_notification_dispensasi', 'count_mahasiswa', 'count_dosen', 'count_karyawan', 'count_pendaftaran', 'tanggal'));
    }
}
