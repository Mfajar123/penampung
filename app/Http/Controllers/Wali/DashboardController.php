<?php

namespace App\Http\Controllers\Wali;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class DashboardController extends Controller
{
    public function __construct(Request $req)
    {
    	$this->middleware('auth:wali');
    }

    public function index()
    {
        return view('pages.home');
    }
}
