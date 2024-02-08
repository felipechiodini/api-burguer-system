<?php

namespace App\Types;

class Cellphone {

    private $cellphone;

    public function __construct(String $cellphone)
    {
        $this->cellphone = preg_replace('/[^0-9]/', '', $cellphone);
    }

    public function isValid(): Bool
    {
        $phone = preg_replace('/[^0-9]/', '', $this->cellphone);
        return strlen($phone) === 10 || strlen($phone) === 11;
    }

    public function getFormated(): String
    {
        return preg_replace("/(\d{2})(\d{1})(\d{4})(\d{4})/", "($1) $2 $3-$4", $this->cellphone);
    }

    public function __toString()
    {
        return $this->cellphone;
    }

}
