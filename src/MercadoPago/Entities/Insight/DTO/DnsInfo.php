<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class DnsInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "nameserver-address")
     */
    public $nameServerAddress;

    /**
     * @var integer
     * @Attribute(json = "total-lookup-time-millis")
     */
    public $lookupTime;

    /**
     * @param mixed $nameServerAddress
     * @return DnsInfo
     */
    public function setNameServerAddress($nameServerAddress)
    {
        $this->nameServerAddress = $nameServerAddress;
        return $this;
    }

    /**
     * @param integer $lookupTime
     * @return DnsInfo
     */
    public function setLookupTime($lookupTime)
    {
        $this->lookupTime = intval($lookupTime);
        return $this;
    }


}