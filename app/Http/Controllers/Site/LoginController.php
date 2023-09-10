<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function get()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        return view('login');
    }

}
