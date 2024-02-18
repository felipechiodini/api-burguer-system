<?php

namespace App\Table\Filters;

use App\Table\Filters\Operators\Contains;
use App\Table\Filters\Operators\EndsWith;
use App\Table\Filters\Operators\Equals;
use App\Table\Filters\Operators\StartsWith;

class Text extends Filter
{

    public function __construct(String $column, String $label)
    {
        $this->column = $column;
        $this->label = $label;

        if (request()->has("filters.$column")) {
            $this->value = request("filters.$column.value");
            $this->setOperator(request("filters.$column.operator"));
        }

        $this->operators = [
            new Equals,
            new Contains,
            new StartsWith,
            new EndsWith,
        ];
    }

}
