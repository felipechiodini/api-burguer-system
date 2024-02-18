<?php

namespace App\Table\Filters\Operators;

class Equals extends Operator
{
    public String $label = 'Igual';
    public String $value = 'equals';
    public String $eloquentValue = '=';

    public function resolveValue($value): String
    {
        return $value;
    }

}
