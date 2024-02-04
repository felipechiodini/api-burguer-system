<?php

namespace App\Order;

use App\Models\StoreCustomer;
use App\Types\Cellphone;
use App\Types\Document;
use App\Types\Name;

class CreateCustomer {

    public $name;
    public $document;
    public $cellphone;

    public static function make()
    {
        return new static();
    }

    public function setName(Name $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDocument(Document $document)
    {
        $this->document = $document;
        return $this;
    }

    public function setCellphone(Cellphone $cellphone)
    {
        $this->cellphone = $cellphone;
        return $this;
    }

    public function create(): StoreCustomer
    {
        return StoreCustomer::query()
            ->create([
                'user_store_id' => 1,
                'name' => $this->name,
                'document' => $this->document,
                'cellphone' => $this->cellphone
            ]);
    }

}
