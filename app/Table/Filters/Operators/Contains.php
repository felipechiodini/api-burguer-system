<?php

namespace App\Table\Filters\Operators;

class Contains extends Operator
{
    public String $label = 'Contém';
    public String $value = 'contains';
    public String $eloquentValue = 'LIKE';

    public function resolveValue($value): String
    {
        return "%$value%";
    }

}
