<?php

namespace App\Dashboard;

use JsonSerializable;

abstract class Chart implements JsonSerializable {
    abstract public function getName(): string;
    abstract public function getConfiguration(): array;
    abstract public function getOptions(): array;
    abstract public function getSeries(): array;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'config' => $this->getConfiguration(),
            'options' => $this->getOptions(),
            'series' => $this->getSeries()
        ];
    }

}
