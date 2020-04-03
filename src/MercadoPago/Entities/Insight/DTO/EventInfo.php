<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class EventInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "name")
     */
    public $name;

    /**
     * @param mixed $name
     * @return EventInfo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}