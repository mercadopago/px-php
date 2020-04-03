<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class BusinessFlowInfo
{
    const serialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "name")
     */
    public $name;

    /**
     * @var string
     * @Attribute(json = "uid")
     */
    public $uid;

    /**
     * @param string $name
     * @return BusinessFlowInfo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $uid
     * @return BusinessFlowInfo
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }


}