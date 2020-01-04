<?php

namespace App\Http\Controllers\SMK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SystemController;

use Auth;

use App\AdminSmk;



class SMKAdminController extends Controller
{

      function __construct(Request $req)
    {
        $this->middleware('auth:admin_smk');
    }
    
     function index()
    {
         return view('pages.smk.home');
    }

      public function SMKInfo()
    {
        return view('pages.smk.admin.info.index');
    }

      public function SMKGuru()
    {
        return view('pages.smk.admin.guru.index');
    }

      public function SMKKategoriInfo()
    {
        return view('pages.smk.admin.kategori_info.index');
    }

      public function SMKkaryawan()
    {
        return view('pages.smk.admin.karyawan.index');
    }



      function password(Request $req)
    {
        $system = New SystemController();
        $route = 'admin_smk.password.ubah';
        $id = Auth::guard('admin_smk')->user()->id_admin;

        $profil = AdminSmk::find($id);

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
