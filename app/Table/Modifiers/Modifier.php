<?php

namespace App\Table\Modifiers;

use Closure;

interface Modifier {
    public function getClosure(): Closure;
}

