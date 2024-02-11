<?php

namespace App\Http\Controllers\Panel;

use App\Dashboard\Panel\Dashboard;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function get()
    {
        $dashboard = new Dashboard;

        return response()
            ->json(compact('dashboard'));
    }

}
