<?php

namespace App\Types;

use App\Utils\Helper;

class Cep {

    public $cep;

    public function __construct(String $cep)
    {
        $this->cep = Helper::clearAllIsNotNumber($cep);
    }

    public function getFormated()
    {
        $cep = $this->cep;

        if (strlen($cep) != 8) {
            return false;
        }

        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }

    public static function format(String $cep)
    {
        return (new static($cep))->getFormated();
    }

    public function __toString()
    {
        return $this->cep;
    }

}
