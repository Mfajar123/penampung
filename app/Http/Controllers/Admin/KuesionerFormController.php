<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

use App\Kuesioner_form;
use App\Kuesioner_kategori;
use App\Kuesioner_pertanyaan;

class KuesionerFormController extends Controller
{
    public function index()
    {
        $kuesioner_form = Kuesioner_form::findOrFail(1);
        $list_jenis_pertanyaan = [
            'Pilihan Ganda' => 'Pilihan Ganda',
            'Paragraf' => 'Paragraf'
        ];

        return view('pages.admin.kuesioner.index', compact('kuesioner_form', 'list_jenis_pertanyaan'));
    }

    public function kategori_submit(Request $request)
    {
        $input = $request->all();
        $input['id_kuesioner_form'] = 1;

        if (empty($request->id_kuesioner_kategori)) {
            $kuesioner_kategori = Kuesioner_kategori::create($input);

            Session::flash('success', 'Kategori Pertanyaan berhasil disimpan.');
        } else {
            $kuesioner_kategori = Kuesioner_kategori::findOrFail($request->id_kuesioner_kategori);
            $kuesioner_kategori->update($input);

            Session::flash('success', 'Kategori Pertanyaan berhasil diperbarui.');
        }

        return redirect()->back();
    }

    public function hapus_kategori($id)
    {
        $kuesioner_kategori = Kuesioner_kategori::findOrFail($id);
        $kuesioner_kategori->kuesioner_pertanyaan()->delete();
        $kuesioner_kategori->delete();

        Session::flash('success', 'Kategori Pertanyaan berhasil dihapus.');

        return redirect()->back();
    }

    public function pertanyaan_submit(Request $request)
    {
        $input = $request->all();

        if (empty($request->id_kuesioner_pertanyaan)) {
            $kuesioner_pertanyaan = Kuesioner_pertanyaan::create($input);

            Session::flash('success', 'Pertanyaan berhasil disimpan.');
        } else {
            $kuesioner_pertanyaan = Kuesioner_pertanyaan::findOrFail($request->id_kuesioner_pertanyaan);
            $kuesioner_pertanyaan->update($input);

            Session::flash('success', 'Pertanyaan berhasil diperbarui.');
        }

        return redirect()->back();
    }

    public function hapus_pertanyaan($id)
    {
        $kuesioner_pertanyaan = Kuesioner_pertanyaan::findOrFail($id);
        $kuesioner_pertanyaan->delete();

        Session::flash('success', 'Pertanyaan berhasil dihapus.');

        return redirect()->back();
    }
}
