<?php

namespace App\Table\Filters;

use App\Table\Filters\Operators\Equals;

class Select extends Filter
{
    public $options;

    public function __construct(String $column, String $label, Array $options)
    {
        $this->column = $column;
        $this->label = $label;
        $this->options = $options;

        if (request()->has("filters.$column")) {
            $this->value = request("filters.$column.value");
            $this->setOperator(request("filters.$column.operator"));
        }

        $this->operators = [
            new Equals
        ];
    }

    public function jsonSerialize(): Array
    {
        return [
            'column' => $this->column,
            'label' => $this->label,
            'value' => $this->value,
            'operator' => $this->operator,
            'options' => $this->options
        ];
    }

}
