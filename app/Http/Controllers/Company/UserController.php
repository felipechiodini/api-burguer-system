<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function subscribe(Request $request)
    {
        $request->validate([
            'daw' => 'dwad'
        ]);

        User::query()
            ->create([
                'name',
                'email',
                'password',
                'cellphone',
                'root'
            ]);

    }

}
