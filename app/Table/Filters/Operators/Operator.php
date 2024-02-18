<?php

namespace App\Table\Filters\Operators;

use JsonSerializable;

abstract class Operator implements JsonSerializable
{
    public String $label;
    public String $value;
    public String $eloquentValue;

    abstract public function resolveValue(String $value): String;

    public function jsonSerialize(): Array
    {
        return [
            'label' => $this->label,
            'value' => $this->value
        ];
    }

}
