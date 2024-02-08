<?php

namespace App\Table;

class WhereResolver {

    private $operator;
    private $value;

    public function __construct($operator, $value)
    {
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getOperator()
    {
        $operators = [
            'equals' => '=',
            'contains' => 'LIKE'
        ];

        return $operators[$this->operator];
    }

    public function getValue()
    {
        $resolvers = [
            'equals' => function($value) {
                return $value;
            },
            'contains' => function($value) {
                return "%{$value}%";
            }
        ];

        return $resolvers[$this->operator]($this->value);
    }

}
