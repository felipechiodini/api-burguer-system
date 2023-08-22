<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Subscription\Braintree;

class BraintreeController extends Controller
{

    public function token()
    {
        $braintree = new Braintree();
        return response()->json(['token' => $braintree->token()]);
    }

}
