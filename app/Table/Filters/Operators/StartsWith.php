<?php

namespace App\Table\Filters\Operators;

class StartsWith extends Operator
{
    public String $label = 'Inicia com';
    public String $value = 'starts_with';
    public String $eloquentValue = 'LIKE';

    public function resolveValue($value): String
    {
        return "$value%";
    }

}
