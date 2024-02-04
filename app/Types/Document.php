<?php

namespace App\Types;

class Document {

    private $document;

    public function __construct(String $document)
    {
        if ($this->isValid($document) === false) {
            throw new \Exception('Documento inválido');
        }

        $this->document = preg_replace('/[^0-9]/', '', $document);
    }

    public function isValid($document): bool
    {
        $document = preg_replace('/[^0-9]/', '', $document);

        if (strlen($document) != 11) {
            return false;
        }

        if (preg_match('/^(\d)\1*$/', $document)) {
            return false;
        }

        for ($i = 9; $i < 11; $i++) {
            $digito = 0;
            for ($j = 0; $j < $i; $j++) {
                $digito += $document[$j] * (($i + 1) - $j);
            }
            $digito = (($digito % 11) < 2) ? 0 : 11 - ($digito % 11);
            if ($digito != $document[$i]) {
                return false;
            }
        }

        return true;
    }

    public function getFormated()
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $this->document);
    }

    public function __toString()
    {
        return $this->document;
    }

}
