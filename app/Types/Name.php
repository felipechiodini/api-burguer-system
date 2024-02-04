<?php

namespace App\Types;

class Name {

    private $name;

    public function __construct(String $name)
    {
        if ($this->isValid($name) === false) {
            throw new \Exception('Nome inválido');
        }

        $this->name = $name;
    }

    public function isValid($name): bool
    {
        return true;
    }

    private function captalize($name): string
    {
        $name = explode(' ', mb_strtolower($name));

        $ignore = [
            'de',
            'da',
            'das',
            'dos',
            'do',
            'e'
        ];

        for ($index = 0; $index < count($name); $index++) {
            if (!in_array($name[$index], $ignore)) $name[$index] = ucfirst($name[$index]);
        }

        return implode(' ', $name);
    }

    public function __toString()
    {
        return $this->captalize($this->name);
    }

}
