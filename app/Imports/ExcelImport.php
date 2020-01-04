<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Jadwal_ujian_detail;
use App\Jadwal_ujian_detail_kelas;
use App\Ruang;
use App\Matkul;
use App\Kelas;
use DB;
use Carbon\Carbon;

class ExcelImport implements ToCollection
{
    public function  __construct($id_jadwal_ujian, $tahun_akademik)
    {
        $this->id_jadwal_ujian = $id_jadwal_ujian;
        $this->tahun_akademik = $tahun_akademik;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        
        // $this->id_jadwal_ujian = $jadwal_ujian->id_jadwal_ujian;
        $this->list_matkul = Matkul::pluck('id_matkul', 'kode_matkul');
        $list_ruang = Ruang::select('id_ruang', DB::raw("lower(kode_ruang) AS kode_ruang"))
            ->pluck('id_ruang', 'kode_ruang');
        $this->list_kelas = Kelas::select('id_kelas', DB::raw("CONCAT(id_prodi, kode_kelas) AS prodi_kode"))
            ->where('tahun_akademik', $this->tahun_akademik)
            ->pluck('id_kelas', 'prodi_kode');

        foreach ($list_ruang as $key => $val) {
            if (is_numeric($key)) $key = intval($key);
            $this->list_ruang[$key] = $val;
        }

        $this->id_jadwal_ujian_detail = Jadwal_ujian_detail::orderBy('id_jadwal_ujian_detail', 'DESC')->first();

        if (empty($this->id_jadwal_ujian_detail)) {
            $this->id_jadwal_ujian_detail = 1;
        } else {
            $this->id_jadwal_ujian_detail = $this->id_jadwal_ujian_detail->id_jadwal_ujian_detail + 1;
        }

        // import excel
        foreach ($rows as $row)
        {
            if (! empty($row[0])) {
                if (!empty($row[0]) && empty($row[2])) {
                    $this->tanggal_ujian = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]));
                    // $this->tanggal_ujian = '1/6/2020';
                } else {
                    $jam = str_replace('WIB', '', $row[0]);

                    foreach (explode('/', $row[5]) as $kelas) {
                        $this->data_jadwal_ujian_detail_kelas[] = [
                            'id_jadwal_ujian_detail' => $this->id_jadwal_ujian_detail,
                            'id_kelas' => $this->list_kelas[trim($kelas)]
                        ];
                    }

                    $this->data_jadwal_ujian_detail[] = [
                        'id_jadwal_ujian_detail' => $this->id_jadwal_ujian_detail++,
                        'id_jadwal_ujian' => $this->id_jadwal_ujian,
                        'tanggal' => date('Y-m-d', strtotime($this->tanggal_ujian)),
                        'jam_mulai' => str_replace('.', ':', trim(explode('-', $jam)[0])),
                        'jam_selesai' => str_replace('.', ':', trim(explode('-', $jam)[1])),
                        'id_ruang' => $this->list_ruang[strtolower($row[1])],
                        'id_matkul' => $this->list_matkul[$row[2]]
                    ];
                }
            }
        }
        // end

        Jadwal_ujian_detail::insert($this->data_jadwal_ujian_detail);
        Jadwal_ujian_detail_kelas::insert($this->data_jadwal_ujian_detail_kelas);
    }
}
