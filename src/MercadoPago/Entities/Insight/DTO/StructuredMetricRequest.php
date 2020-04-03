<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class StructuredMetricRequest
{
    const SerialVersionUID = 1;

    /**
     * @var ClientInfo
     * @Attribute(json = "client-info")
     */
    public $clientInfo;

    /**
     * @var BusinessFlowInfo
     * @Attribute(json = "business-flow-info")
     */
    public $businessFlowInfo;

    /**
     * @var EventInfo
     * @Attribute(json = "event-info")
     */
    public $eventInfo;

    /**
     * @var ConnectionInfo
     * @Attribute(json = "connection-info")
     */
    public $connectionInfo;

    /**
     * @var DeviceInfo
     * @Attribute(json = "device-info")
     */
    public $deviceInfo;

    /**
     * @var string
     * @Attribute(json = "encoded-data")
     */
    public $base64data;

    /**
     * @param ClientInfo $clientInfo
     * @return StructuredMetricRequest
     */
    public function setClientInfo($clientInfo)
    {
        $this->clientInfo = $clientInfo;
        return $this;
    }

    /**
     * @param BusinessFlowInfo $businessFlowInfo
     * @return StructuredMetricRequest
     */
    public function setBusinessFlowInfo($businessFlowInfo)
    {
        $this->businessFlowInfo = $businessFlowInfo;
        return $this;
    }

    /**
     * @param EventInfo $eventInfo
     * @return StructuredMetricRequest
     */
    public function setEventInfo($eventInfo)
    {
        $this->eventInfo = $eventInfo;
        return $this;
    }

    /**
     * @param ConnectionInfo $connectionInfo
     * @return StructuredMetricRequest
     */
    public function setConnectionInfo($connectionInfo)
    {
        $this->connectionInfo = $connectionInfo;
        return $this;
    }

    /**
     * @param DeviceInfo $deviceInfo
     * @return StructuredMetricRequest
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->deviceInfo = $deviceInfo;
        return $this;
    }

    /**
     * @param string $base64data
     * @return StructuredMetricRequest
     */
    public function setBase64data($base64data)
    {
        $this->base64data = $base64data;
        return $this;
    }


}