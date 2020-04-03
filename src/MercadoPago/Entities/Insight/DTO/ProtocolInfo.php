<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class ProtocolInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "name")
     */
    public $name;

    /**
     * @var ProtocolHttp
     * @Attribute(json = "protocol-http")
     */
    public $protocolHttp;

    /**
     * @var integer
     * @Attribute(json = "retry-count")
     */
    public $retryCount;

    /**
     * @param mixed $name
     * @return ProtocolInfo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $protocolHttp
     * @return ProtocolInfo
     */
    public function setProtocolHttp($protocolHttp)
    {
        $this->protocolHttp = $protocolHttp;
        return $this;
    }

    /**
     * @param mixed $retryCount
     * @return ProtocolInfo
     */
    public function setRetryCount($retryCount)
    {
        $this->retryCount = $retryCount;
        return $this;
    }


}