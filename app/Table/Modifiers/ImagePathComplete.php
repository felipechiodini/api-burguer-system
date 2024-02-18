<?php

namespace App\Table\Modifiers;

use Closure;

class ImagePathComplete implements Modifier
{

    public function getClosure(): Closure
    {
        return fn($value) => "https://d2sbwe6sqww2sr.cloudfront.net/$value";
    }

}
