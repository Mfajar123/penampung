<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SystemController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use URL;
use Auth;
use Session;
use App\Admin;
use App\AdminSmk;
use App\AdminSmp;
use App\Mahasiswa;
use App\Dosen;

class LoginController extends Controller
{
    function __construct()
    {
        $this->middleware('guest:users', ['except' => 'logout']);
    }

    function form(Request $req)
    {
        if($req->segment(1) == 'mahasiswa')
        {
            $route = "mahasiswa.login.auth";
        }
        elseif($req->segment(1) == 'dosen')
        {
            $route = "dosen.login.auth";
        }
        elseif($req->segment(1) == 'admin')
        {
            $route = "admin.login.auth";
        }
        elseif($req->segment(1) == 'wali')
        {
            $route = "wali.login.auth";
        }
         elseif($req->segment(1) == 'admin_smk')
        {
            $route = "admin_smk.login.auth";
        }
        elseif($req->segment(1) == 'admin_smp')
        {
            $route = "admin_smp.login.auth";
        }
        
        return view('login', compact('route'));
    }

    function login(Request $request)
    {
        $system = new SystemController();

        if($request->segment(1) == 'mahasiswa')
        {
            $count = Mahasiswa::where('nim', $request->nim)->count();
            if ($count > 0) {
                # code...
                $mahasiswa = Mahasiswa::where('nim', $request->nim)->get();
                foreach($mahasiswa as $view){

                        $password = $system->encrypt($request->password, $request->nim, $request->nim);
                        if ($mhs = Mahasiswa::where(['nim' => $request->nim, 'password' => $password])->first())
                        {

                            Auth::guard('mahasiswa')->login($mhs);
				if ($mhs->isFirstLogin == null)
                            {
                                Session::flash('flash_lengkapi', 'Silahkan lengkapi data sesuai dengan ijazah.');

                                $mhs->update([
                                    'isFirstLogin' => 'N'
                                ]);

                                return redirect()->route('mahasiswa.profil.ubah');
                            }
                            return redirect()->intended(route('mahasiswa.home'));
                        }
                        else
                        {
                            Session::flash('fail', 'Username atau Password salah.');
                
                            return redirect()->back()->withInput($request->only('nim'));
                        }
                    }
            }else{
                Session::flash('fail', 'NIM tidak terdaftar.');
                
                return redirect()->back();
            }
        }
        elseif($request->segment(1) == 'dosen')
        {
            $count = Dosen::where('nip', $request->nip)->count();
            if ($count > 0) {
                # code...
                $dosen = Dosen::where('nip', $request->nip)->get();
                foreach($dosen as $view){
                    $password = $system->encrypt($request->password, $request->nip, $request->nip);
                        if ($dsn = Dosen::where(['nip' => $request->nip, 'password' => $password])->first())
                        {

                            Auth::guard('dosen')->login($dsn);
                            return redirect()->intended(route('dosen.home'));
                        }
                        else
                        {
                            Session::flash('fail', 'Username atau Password salah.');
                
                            return redirect()->back()->withInput($request->only('nip'));
                        }
                    }
            }else{
                Session::flash('fail', 'NIP tidak terdaftar.');
                
                return redirect()->back();
            }
        }
        elseif($request->segment(1) == 'admin')
        {
            $count = Admin::where('username', $request->username)->count();
            if ($count > 0) {
                # code...
                $admin = Admin::where('username', $request->username)->get();
                foreach($admin as $view){
                    $password = $system->encrypt($request->password, $request->username, $request->username);
                    if ($adm = Admin::where(['username' => $request->username, 'password' => $password])->first())
                    {
                        Auth::guard('admin')->login($adm);
                        return redirect()->intended(route('admin.home'));
                    }
                    else
                    {
                        Session::flash('fail', 'Username atau Password salah.');
            
                        return redirect()->back()->withInput($request->only('username'));
                    }
                }
            }else{
                Session::flash('fail', 'Username tidak terdaftar.');
                
                return redirect()->back();
            }
        }
        elseif($request->segment(1) == 'wali')
        {
            $count = Mahasiswa::where('nim', $request->nim)->count();
            if ($count > 0) {
                # code...
                $mahasiswa = Mahasiswa::where('nim', $request->nim)->get();
                foreach($mahasiswa as $view){

                        $password = $system->encrypt($request->password, $request->nim, $request->nim);
                        if ($mhs = Mahasiswa::where(['nim' => $request->nim, 'password' => $password])->first())
                        {

                            Auth::guard('wali')->login($mhs);
                            return redirect()->intended(route('wali.home'));
                        }
                        else
                        {
                            Session::flash('fail', 'Username atau Password salah.');
                
                            return redirect()->back()->withInput($request->only('nim'));
                        }
                    }
            }else{
                Session::flash('fail', 'NIM tidak terdaftar.');
                
                return redirect()->back();
            }
        }
        
        elseif($request->segment(1) == 'admin_smk')
        {
            $count = AdminSmk::where('username', $request->username)->count();
            if ($count > 0) {
                
                $adminsmk = AdminSmk::where('username', $request->username)->get();
                foreach($adminsmk as $view){

                        $password = $system->encrypt($request->password, $request->username, $request->username);
                        if ($admsmk = AdminSmk::where(['username' => $request->username, 'password' => $password])->first())
                        {
                            Auth::guard('admin_smk')->login($admsmk);
                            return redirect()->intended(route('admin_smk.home'));
                        }
                        else
                        {
                            Session::flash('fail', 'Username atau Password salah.');
                
                            return redirect()->back()->withInput($request->only('username'));
                        }
                    }
            }else{
                Session::flash('fail', 'Username tidak terdaftar.');
                
                return redirect()->back();
            }
        }        

         elseif($request->segment(1) == 'admin_smp')
        {
            $count = AdminSmp::where('username', $request->username)->count();
            if ($count > 0) {
                
                $adminsmp = AdminSmp::where('username', $request->username)->get();
                foreach($adminsmp as $view){

                        $password = $system->encrypt($request->password, $request->username, $request->username);
                        if ($admsmp = AdminSmp::where(['username' => $request->username, 'password' => $password])->first())
                        {
                            Auth::guard('admin_smp')->login($admsmp);
                            return redirect()->intended(route('admin_smp.home'));
                        }
                        else
                        {
                            Session::flash('fail', 'Username atau Password salah.');
        
                            return redirect()->back()->withInput($request->only('username'));
                        }
                    }
            }else{
                Session::flash('fail', 'Username tidak terdaftar.');
                
                return redirect()->back();
            }
        }        
        
    }

    function logout(Request $request)
    {
        if($request->segment(1) == 'mahasiswa')
        {
            Auth::guard('mahasiswa')->logout();

            return redirect()->route('mahasiswa.login');
        }
        if($request->segment(1) == 'dosen')
        {
            Auth::guard('dosen')->logout();

            return redirect()->route('dosen.login');
        }
        if($request->segment(1) == 'admin')
        {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login');
        }
        if($request->segment(1) == 'wali')
        {
            Auth::guard('wali')->logout();

            return redirect()->route('wali.login');
        }
        
        if($request->segment(1) == 'admin_smk')
        {
            Auth::guard('admin_smk')->logout();

            return redirect()->route('admin_smk.login');
        }

         if($request->segment(1) == 'admin_smp')
        {
            Auth::guard('admin_smp')->logout();

            return redirect()->route('admin_smp.login');
        }
    }
}
