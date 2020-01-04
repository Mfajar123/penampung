<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Mahasiswa;

class SemesterController extends Controller
{
    public function index()
    {
        return view('pages.admin.setting_semester.index');
    }

    public function submit(Request $request)
    {
        $list_mahasiswa = DB::table('m_mahasiswa AS m')
            ->select('m.nim')
            ->where([
                ['m.id_semester', '>', 0],
                ['m.id_semester', '<', 8]
            ])
            ->pluck('m.nim');

        $update_semester = Mahasiswa::whereIn('nim', $list_mahasiswa)->increment('id_semester');
        
        return redirect()->route('admin.setting.semester.index');
    }
}
