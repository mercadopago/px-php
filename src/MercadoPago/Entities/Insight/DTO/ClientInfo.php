<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;
use MercadoPago\Entity;

class ClientInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "name")
     */
    public $name;

    /**
     * @var string
     * @Attribute(json = "version")
     */
    public $version;


}