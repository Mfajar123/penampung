<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use DataTables;

use App\Agenda;

class AgendaController extends Controller
{
    public function datatable()
    {
        $data = array();
        $list_agenda = Agenda::where('is_delete', 'N')
            ->orderBy('id_agenda', 'DESC')
            ->get();

        foreach ($list_agenda as $list) {
            $list['no'] = null;
            $list['tanggal_mulai'] = date('d F Y', strtotime($list->tanggal_mulai));
            $list['tanggal_selesai'] = date('d F Y', strtotime($list->tanggal_selesai));
            $list['action'] = '
                <a href="'.route('admin.agenda.edit', $list->id_agenda).'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                <a href="'.route('admin.agenda.destroy', $list->id_agenda).'" class="btn btn-danger btn-sm" onclick="return confirm_delete()"><i class="fa fa-trash"></i> Hapus</a>
            ';
            $data[] = $list;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function index()
    {
        return view('pages.admin.agenda.index');
    }

    public function create()
    {
        return view('pages.admin.agenda.create');
    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $input = $request->all();
        $input['created_by'] = $user->nama;
        $input['created_date'] = date('Y-m-d H:i:s');

        $agenda = Agenda::create($input);

        Session::flash('success', 'Data agenda berhasil disimpan');

        return redirect()->route('admin.agenda.index');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        return view('pages.admin.agenda.edit', compact('agenda'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::guard('admin')->user();
        $agenda = Agenda::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = $user->nama;
        $input['updated_date'] = date('Y-m-d H:i:s');

        $agenda->update($input);

        Session::flash('success', 'Data agenda berhasil diperbarui');

        return redirect()->route('admin.agenda.index');
    }

    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        $agenda = Agenda::findOrFail($id);

        $agenda->update([
            'deleted_by' => $user->nama,
            'deleted_date' => date('Y-md H:i:s'),
            'is_delete' => 'Y'
        ]);

        Session::flash('error', 'Data agenda berhasil dihapus');

        return redirect()->route('admin.agenda.index');
    }
}
