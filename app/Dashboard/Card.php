<?php

namespace App\Dashboard;

use JsonSerializable;

abstract class Card implements JsonSerializable {
    abstract public function getName(): string;
    abstract public function getValue();

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue()
        ];
    }

}
