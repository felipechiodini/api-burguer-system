<?php

namespace App\Http\Controllers\Panel;

use App\Dashboard\Home;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function get()
    {
        return response()->json(Home::get());
    }

}
