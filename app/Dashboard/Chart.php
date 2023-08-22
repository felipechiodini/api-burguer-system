<?php

namespace App\Dashboard;

class Chart {

    private $value;
    private $name;

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function serialize()
    {
        return [
            'name' => $this->name,
            'value' => $this->value
        ];
    }

}
