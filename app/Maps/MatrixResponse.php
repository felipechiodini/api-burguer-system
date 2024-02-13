<?php

namespace App\Maps;

class MatrixResponse {

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getDistanceFake()
    {
        return (object) [
            'text' => '13km',
            'value' => '1300'
        ];
    }

    public function getDistance()
    {
        return $this->data->rows[0]->elements[0]->distance;
    }

    public function getDuration()
    {
        return $this->data->rows[0]->elements[0]->duration;
    }

}
