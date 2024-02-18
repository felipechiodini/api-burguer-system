<?php

namespace App\Table\Filters\Operators;

class EndsWith extends Operator
{
    public String $label = 'Termina com';
    public String $value = 'ends_with';
    public String $eloquentValue = 'LIKE';

    public function resolveValue($value): String
    {
        return "%$value";
    }

}
