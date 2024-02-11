<?php

namespace App\Dashboard;

use JsonSerializable;

abstract class BaseDashboard implements JsonSerializable {

    public function getCharts(): Array
    {
        throw new \Exception("Function " . __FUNCTION__ . " was not implemented");
    }

    public function getCards(): Array
    {
        throw new \Exception("Function " . __FUNCTION__ . " was not implemented");
    }

    public function jsonSerialize(): Array
    {
        return [
            'charts' => $this->getCharts(),
            'cards' => $this->getCards()
        ];
    }

}
