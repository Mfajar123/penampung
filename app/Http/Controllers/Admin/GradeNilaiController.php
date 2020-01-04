<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;

use App\Grade_nilai;

class GradeNilaiController extends Controller
{
    public function index(Request $request)
    {
        $tahun_akademik = null;
        $list_grade_nilai = array();

        $list_tahun_akademik = DB::table('m_grade_nilai AS gn')
            ->select([
                'gn.tahun_akademik',
                'ta.keterangan'
            ])
            ->join('t_tahun_akademik AS ta', 'gn.tahun_akademik', '=', 'ta.tahun_akademik')
            ->orderBy('gn.tahun_akademik', 'DESC')
            ->groupBy('gn.tahun_akademik')
            ->pluck('ta.keterangan', 'gn.tahun_akademik');
        
        if ($request->tahun_akademik) {

            $tahun_akademik = $request->tahun_akademik;
            
            $list_grade_nilai = DB::table('m_grade_nilai')
                ->select('huruf', 'nilai_min', 'nilai_max', 'bobot')
                ->where('tahun_akademik', '=', $request->tahun_akademik)
                ->orderBy('huruf', 'ASC')
                ->get();
        }

        return view('pages.admin.grade_nilai.index', compact('list_tahun_akademik', 'tahun_akademik', 'list_grade_nilai'));
    }

    public function tambah()
    {
        $list_tahun_akademik = DB::table('t_tahun_akademik')
            ->select('tahun_akademik', 'keterangan')
            ->orderBy('tahun_akademik', 'DESC')
            ->groupBy('tahun_akademik')
            ->pluck('keterangan', 'tahun_akademik');

        return view('pages.admin.grade_nilai.tambah', compact('list_tahun_akademik'));
    }

    public function simpan(Request $request)
    {
        $count_grade = Grade_nilai::where(['tahun_akademik' => $request->tahun_akademik])->count();

        if ($count_grade > 0) {
            Session::flash('flash_message', 'Grade Nilai untuk Tahun Akademik '.$request->tahun_akademik.' sudah ada.');
            
            return redirect()->back();
        } else {
            $list_grade_nilai = array();

            foreach ($request->huruf as $key => $val) {
                $list_grade_nilai[] = array(
                    'tahun_akademik' => $request->tahun_akademik,
                    'huruf' => $val,
                    'nilai_min' => $request->nilai_min[$key],
                    'nilai_max' => $request->nilai_max[$key],
                    'bobot' => $request->bobot[$key],
                );
            }

            $simpan = Grade_nilai::insert($list_grade_nilai);

            Session::flash('flash_message', 'Grade Nilai berhasil disimpan.');
            
            return redirect()->route('admin.grade_nilai.index');
        }
    }

    public function ubah($tahun_akademik)
    {
        $list_grade_nilai = Grade_nilai::where('tahun_akademik', $tahun_akademik)->get();

        $list_tahun_akademik = DB::table('t_tahun_akademik')
            ->select('tahun_akademik', 'keterangan')
            ->orderBy('tahun_akademik', 'DESC')
            ->groupBy('tahun_akademik')
            ->pluck('keterangan', 'tahun_akademik');

        return view('pages.admin.grade_nilai.ubah', compact('tahun_akademik', 'list_grade_nilai', 'list_tahun_akademik'));
    }

    public function perbarui($tahun_akademik, Request $request)
    {
        $list_grade_nilai = array();

        foreach ($request->huruf as $key => $val) {
            $list_grade_nilai[] = array(
                'tahun_akademik' => $tahun_akademik,
                'huruf' => $val,
                'nilai_min' => $request->nilai_min[$key],
                'nilai_max' => $request->nilai_max[$key],
                'bobot' => $request->bobot[$key],
            );
        }

        $hapus = Grade_nilai::where('tahun_akademik', $tahun_akademik)->delete();

        $simpan = Grade_nilai::insert($list_grade_nilai);

        Session::flash('flash_message', 'Grade Nilai berhasil diperbarui.');
        
        return redirect()->route('admin.grade_nilai.index');
    }

    public function hapus($tahun_akademik)
    {
        $hapus = Grade_nilai::where('tahun_akademik', $tahun_akademik)->delete();

        Session::flash('flash_message', 'Grade Nilai berhasil dihapus.');
        
        return redirect()->route('admin.grade_nilai.index');
    }
}
