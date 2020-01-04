<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use DataTables;

use App\TahunAkademik;
use App\Mahasiswa;
use App\Pembayaran_spp;

class PembayaranSPPController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $list_tahun_akademik = array();

        if (!empty($mahasiswa->tahun_akademik)) {
            $list_tahun_akademik = TahunAkademik::select('id_tahun_akademik', 'keterangan')->where('tahun_akademik', '>=', $mahasiswa->tahun_akademik)->orderBy('tahun_akademik', 'DESC')->pluck('keterangan', 'id_tahun_akademik');
        }

        return view('pages.mahasiswa.pembayaran_spp.index', compact('list_tahun_akademik'));
    }

    public function get_pembayaran_spp($id_tahun_akademik)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $tahun_akademik = TahunAkademik::select('semester')->where('id_tahun_akademik', $id_tahun_akademik)->first();

        if ($tahun_akademik->semester == 'Ganjil') {
            $list_bulan = array(
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
                1 => 'Januari'
            );
        } else {
            $list_bulan = array(
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
            );
        }

        $response = array();
        
        $response['status'] = 'success';
        $no = 1;

        foreach ($list_bulan as $key => $val) {
            $pembayaran_spp = Pembayaran_spp::where([
                    't_pembayaran_spp.nim' => $nim,
                    't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
                    't_pembayaran_spp.bulan' => $key
                ])
                ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
                ->first();
            $count_spp_ = Pembayaran_spp::where([
                    't_pembayaran_spp.nim' => $nim,
                    't_pembayaran_spp.id_tahun_akademik' => $id_tahun_akademik,
                    't_pembayaran_spp.bulan' => $key
                ])
                ->leftJoin('tbl_dispensasi', 't_pembayaran_spp.id_dispensasi', 'tbl_dispensasi.id_dispensasi')
                ->count();

            if ($count_spp_ == 0) {
                $status = "<span class='text-danger'>Belum Bayar</span>";
            } else {
                $status = "<span class='text-success'>Sudah Bayar</span>";

                if (! empty($pembayaran_spp->id_dispensasi)) {
                    if (strtolower($pembayaran_spp->status) == 'belum bayar') {
                        $status = "<span class='text-success'>Dispensasi [Belum Bayar]</span>";
                    } else {
                        $status = "<span class='text-success'>Dispensasi [Sudah Bayar]</span>";
                    }
                }
            }

            $response['pembayaran_spp'][] = array(
                'no' => $no++,
                'key_bulan' => $key,
                'bulan' => $val,
                'status' => $status,
                'bayar' => ! empty($pembayaran_spp->bayar) ? "Rp. ".number_format($pembayaran_spp->bayar, 0, ",", ".") : '-',
                'tanggal' => ! empty($pembayaran_spp->tanggal_pembayaran) ? date('d M Y', strtotime($pembayaran_spp->tanggal_pembayaran)) : '-',
                'keterangan' => ! empty($pembayaran_spp->keterangan) ? $pembayaran_spp->keterangan : '-'
            );
        }

	return $response;

        return response()->json($response, 200);
    }
}
