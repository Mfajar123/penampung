<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kelas;

class OptionsController extends Controller
{
    public function list_bulan()
    {
        return array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
    }

    public function list_semester()
    {
        return array(
            'Ganjil' => 'Ganjil',
            'Genap' => 'Genap'
        );
    }
    
    public function get_now_tahun_akademik()
    {
        $bulan = date('m');

        if ($bulan >= 02 and $bulan <= 07)
        {
            $tahun_lalu = date("Y") - 1;
            $belakang = "20";
            $tahun = $tahun_lalu.$belakang;
        }
        else
        {
            $tahun_sekarang = date("Y");
            $belakang = "10";
            $tahun = $tahun_sekarang.$belakang;
        }

        return $tahun;
    }

    public function get_semester($nim, $tahun_akademik)
    {
        $kelas = Kelas::select([
            'tbl_semester.id_semester',
            'tbl_semester.semester_ke'
        ])
        ->rightJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
        ->leftJoin('tbl_semester', 'm_kelas.id_semester', '=', 'tbl_semester.id_semester')
        ->where([
            'm_kelas.tahun_akademik' => $tahun_akademik,
            'm_kelas_detail.nim' => $nim
        ])
        ->first();

        return $kelas;
    }

    public function get_now_semester($nim, $tahun_akademik)
    {
        $semester_ke = Kelas::select([
            'tbl_semester.id_semester',
            'tbl_semester.semester_ke'
        ])
        ->rightJoin('m_kelas_detail', 'm_kelas.id_kelas', '=', 'm_kelas_detail.id_kelas')
        ->leftJoin('tbl_semester', 'm_kelas.id_semester', '=', 'tbl_semester.id_semester')
        ->where([
            ['m_kelas.tahun_akademik', '>=', $tahun_akademik],
            'm_kelas_detail.nim' => $nim
        ])
        ->count();

        return $semester_ke;
    }
}
