<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class TcpInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "source-address")
     */
    public $sourceAddress;

    /**
     * @var string
     * @Attribute(json = "target-address")
     */
    public $targetAddress;

    /**
     * @var integer
     * @Attribute(json = "handshake-time-millis")
     */
    public $handshakeTime;

    /**
     * @param mixed $sourceAddress
     * @return TcpInfo
     */
    public function setSourceAddress($sourceAddress)
    {
        $this->sourceAddress = $sourceAddress;
        return $this;
    }

    /**
     * @param mixed $targetAddress
     * @return TcpInfo
     */
    public function setTargetAddress($targetAddress)
    {
        $this->targetAddress = $targetAddress;
        return $this;
    }

    /**
     * @param mixed $handshakeTime
     * @return TcpInfo
     */
    public function setHandshakeTime($handshakeTime)
    {
        $this->handshakeTime = $handshakeTime;
        return $this;
    }


}