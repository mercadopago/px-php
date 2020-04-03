<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class TrafficLightResponse
{
    const SerialVersionUID = 1;

    /**
     * @var boolean
     * @Attribute(json = "send-data")
     */
    private $sendDataEnabled;

    /**
     * @var int
     * @Attribute(json = "ttl")
     */
    private $sendTTL;

    /**
     * @var array
     * @Attribute(json = "endpoint-whitelist")
     */
    private $endpointWhiteList = [];

    /**
     * @var boolean
     * @Attribute(json = "base64-encode-data")
     */
    private $base64encodingEnabled;

    public function isSendDataEnabled()
    {
        return $this->sendDataEnabled;
    }

    public function setSendDataEnabled($sendDataEnabled)
    {
        $this->sendDataEnabled = $sendDataEnabled;
    }

    public function getSendTTL()
    {
        return $this->sendTTL;
    }

    public function setSendTTL($sendTTL)
    {
        $this->sendTTL = $sendTTL;
    }

    public function getEndpointWhiteList()
    {
        return $this->endpointWhiteList;
    }

    public function setEndpointWhiteList($endpointWhiteList)
    {
        $this->endpointWhiteList = $endpointWhiteList;
    }

    public function isBase64encodingEnabled()
    {
        return $this->base64encodingEnabled != null && $this->base64encodingEnabled;
    }

    public function setBase64encodingEnabled($base64encodingEnabled)
    {
        $this->base64encodingEnabled = $base64encodingEnabled;
    }

}