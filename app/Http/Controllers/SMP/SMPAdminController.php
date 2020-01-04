<?php

namespace App\Http\Controllers\SMP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SystemController;

use Auth;

use App\AdminSmp;



class SMPAdminController extends Controller
{

      function __construct(Request $req)
    {
        $this->middleware('auth:admin_smp');
    }
    
     function index()
    {
         return view('pages.smp.home');
    }

      public function SMPInfo()
    {
        return view('pages.smp.admin.info.index');
    }

      public function SMPKategoriInfo()
    {
        return view('pages.smp.admin.kategori_info.index');
    }

      public function SMPkaryawan()
    {
        return view('pages.smp.admin.karyawan.index');
    }



      function password(Request $req)
    {
        $system = New SystemController();
        $route = 'admin_SMP.password.ubah';
        $id = Auth::guard('admin_smp')->user()->id_admin;

        $profil = AdminSmp::find($id);

        if(empty($system->crypt($profil->password, 'd')))
        {
            $password = $profil->password;
        }
        else
        {
            $password = $system->crypt($profil->password, 'd');
        }

        return view('pages.profil.password', compact('system', 'route', 'id', 'profil', 'password'));
    }
  
}
