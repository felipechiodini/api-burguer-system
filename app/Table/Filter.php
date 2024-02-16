<?php

namespace App\Table;

use Illuminate\Database\Eloquent\Builder;
use JsonSerializable;

class Filter implements JsonSerializable
{
    protected $column;
    protected $label;
    protected $value;
    protected $operator;

    public function __construct(String $column, String $label)
    {
        $this->column = $column;
        $this->label = $label;
        $this->value = request("filters")[$column] ?? null;
        $this->operator = request("filters")['operator'] ?? null;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where($this->column, $this->resolverOperator(), $this->resolveValue());
    }

    public function hasValue(): Bool
    {
        return $this->value !== null;
    }

    protected function resolverOperator(): String
    {
        $operators = [
            'equals' => '=',
            'contains' => 'LIKE',
            'start_with' => 'LIKE',
            'ends_with' => 'LIKE',
        ];

        return $operators[$this->operator];
    }

    protected function resolveValue(): String
    {
        $parsers = [
            'equals' => fn($value) => $value,
            'contains' => fn($value) => "%$value%",
            'starts_with' => fn($value) => "$value%",
            'ends_with' => fn($value) => "%$value"
        ];

        return $parsers[$this->operator]($this->value);
    }

    protected function setValue(String $value): Self
    {
        $this->value = $value;
        return $this;
    }

    protected function setOperator(String $operator): Self
    {
        $this->operator = $operator;
        return $this;
    }

    public function jsonSerialize(): Array
    {
        return [
            'label' => $this->label,
            'column' => $this->column,
            'value' => $this->value,
            'operator' => $this->operator
        ];
    }

}
