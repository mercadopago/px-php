<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class TrafficLightRequest
{
    const SerialVersionUID = 1;

    /**
     * @var ClientInfo $clientInfo
     * @Attribute(json = "client-info")
     */
    public $clientInfo;

    /**
     * @return ClientInfo
     */
    public function getClientInfo()
    {
        return $this->clientInfo;
    }

    /**
     * @param ClientInfo $clientInfo
     * @return TrafficLightRequest
     */
    public function setClientInfo($clientInfo)
    {
        $this->clientInfo = $clientInfo;
        return $this;
    }
}