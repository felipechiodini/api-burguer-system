<?php

namespace App\Table\Filters;

use App\Table\Filters\Operators\Contains;
use App\Table\Filters\Operators\EndsWith;
use App\Table\Filters\Operators\Equals;
use App\Table\Filters\Operators\StartsWith;
use Illuminate\Database\Eloquent\Builder;
use JsonSerializable;

abstract class Filter implements JsonSerializable
{
    protected $column;
    protected $label;
    protected $value;
    protected $operators;
    protected $operator;

    public function apply(Builder $builder)
    {
        $builder->where($this->column, $this->operator->eloquentValue, $this->operator->resolveValue($this->value));
    }

    public function hasValue(): Bool
    {
        return $this->value !== null;
    }

    protected function setOperator(String $operator)
    {
        $operators = [
            'equals' => new Equals,
            'contains' => new Contains,
            'start_with' => new StartsWith,
            'ends_with' => new EndsWith,
        ];

        $this->operator = $operators[$operator];
    }

    public function jsonSerialize(): Array
    {
        return [
            'column' => $this->column,
            'label' => $this->label,
            'value' => $this->value,
            'operators' => $this->operators,
            'operator' => $this->operator
        ];
    }

}
