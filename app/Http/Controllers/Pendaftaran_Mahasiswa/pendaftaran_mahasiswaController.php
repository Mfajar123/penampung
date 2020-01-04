<?php

namespace App\Http\Controllers\Pendaftaran_Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
// use Alert;
use Session;
use Auth;

use App\Daftar;
use App\Provinsi;
use App\Pendaftar;
use App\Pendaftaran;
use App\PendaftaranNilai;
use App\WaktuKuliah;
use App\Prodi;
use App\Jenjang;

class pendaftaran_mahasiswaController extends Controller
{
    public function automatic_number_registration()
    {
        $query = DB::table('pendaftar')->max('kd_daftar');
        return sprintf("%03s", abs($query + 1));
    }

    public function data_pendaftar()
    {
        $list_pendaftar = Pendaftar::all();

        return view('pendaftaran_mahasiswa_baru.data_pendaftaran_mahasiswa_baru', compact('list_pendaftar'));
    }

    public function pendaftaran()
    {
        $list_provinsi = Provinsi::pluck('nama_provinsi', 'id_provinsi');
        $list_prodi = Prodi::whereIn('nama_prodi', ['Manajemen', 'Akuntansi'])->pluck('nama_prodi', 'id_prodi');
        $list_jenjang = Jenjang::pluck('nama_jenjang', 'id_jenjang');
        $list_waktu_kuliah = WaktuKuliah::pluck('nama_waktu_kuliah', 'id_waktu_kuliah');

        return view('pendaftaran_mahasiswa_baru.pendaftaran_mahasiswa_baru', compact('list_provinsi', 'list_prodi', 'list_jenjang', 'list_waktu_kuliah'));
    }

    /**
     * Fungsi untuk mendapatkan tahun akademik sekarang
     */
    public function get_now_tahun_akademik()
    {
        return date('Y').'20';
    }

    public function input_pendaftar(Request $request)
    {
        $no_otomatis = $this->automatic_number_registration();
        $nama = $request->nama;
        $email = $request->email;
        $no_tlp = $request->no_telp;
        $alamat = $request->alamat;
        $id_provinsi = $request->id_provinsi;
        $jenkel = $request->jenkel;
        $tempat_lahir = $request->tempat_lahir;
        $tgl_lahir = $request->tgl_lahir;
        $id_prodi = $request->id_prodi;
        $id_waktu_kuliah = $request->id_waktu_kuliah;
        $id_jenjang = $request->id_jenjang;
        $asal_sekolah = $request->asal_sekolah;

        $insert = DB::table('pendaftar')->insert([
            'kd_daftar' => $no_otomatis,
            'nama' => $nama,
            'email' => $email,
            'no_telp' => $no_tlp,
            'alamat' => $alamat,
            'id_provinsi' => $id_provinsi,
            'jenis_kelamin' => $jenkel,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'id_prodi' => $id_prodi,
            'id_waktu_kuliah' => $id_waktu_kuliah,
            'id_jenjang' => $id_jenjang,
            'tgl_daftar' => date('Y-m-d H:i:s'),
            'asal_sekolah' => $asal_sekolah
        ]);
        
        // Alert::message('Data Pendaftaran Anda Berhasil Di simpan', 'Terima Kasih')->autoclose(5000);

        Session::flash('success', 'Data Pendaftaran Anda berhasil disimpan');
        return redirect('pendaftaran_mahasiswa');
    }

    /**
     * Fungsi untuk membuat id daftar di table pendaftaran
     * @param string $tahun_akademik
     * @param int $id_waktu_kuliah
     */
    public function generate_id_daftar($id_waktu_kuliah)
    {
        $pendaftaran = Pendaftaran::where('id_daftar', 'like', '%'.date('y').$id_waktu_kuliah.'%')
            ->orderBy('id_daftar', 'DESC')
            ->first();

        if (empty($pendaftaran)) return date('y').$id_waktu_kuliah.'00001';
        
        $hitung = intval(substr($pendaftaran->id_daftar, 3)) + 1;

        return date('y').$id_waktu_kuliah.substr('00000', strlen($hitung)).$hitung;
    }

    /**
     * Fungsi untuk mencopy data dari daftar online ke pendaftaran
     * @param string $kd_daftar
     */
    public function transfer($kd_daftar, Request $request)
    {
        $pendaftar = Pendaftar::findOrFail($kd_daftar);
        $tahun_akademik = $this->get_now_tahun_akademik();
        $id_daftar = $this->generate_id_daftar($pendaftar->id_waktu_kuliah);
        $user = Auth::guard('admin')->user();

        $pendaftaran = Pendaftaran::create([
            'id_daftar' => $id_daftar,
            'nama' => $pendaftar->nama,
            'no_telp' => $pendaftar->no_telp,
            'alamat' => $pendaftar->alamat,
            'id_provinsi' => $pendaftar->id_provinsi,
            'id_waktu_kuliah' => $pendaftar->id_waktu_kuliah,
            'tahun_akademik' => $tahun_akademik,
            'id_prodi' => $pendaftar->id_prodi,
            'id_jenjang' => $pendaftar->id_jenjang,
            'id_status' => 2,
            'alamat' => $pendaftar->alamat,
            'tempat_lahir' => $pendaftar->tempat_lahir,
            'tanggal_lahir' => $pendaftar->tgl_lahir,
            'no_telp' => $pendaftar->no_telp,
            'status_bayar' => 'Belum Bayar',
            'created_by' => $user->nama
        ]);

        $pendaftaran_nilai = PendaftaranNilai::create(['id_daftar' => $id_daftar]);

        $pendaftar->update(['id_daftar' => $id_daftar]);

        Session::flash('success', 'Data Pendaftar Online berhasil ditambahkan ke Data Pendaftaran.');

        return redirect()->back();
    }
}
