<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class ProtocolHttp
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "referer-url")
     */
    public $refererUrl;

    /**
     * @var string
     * @Attribute(json = "request-method")
     */
    public $requestMethod;

    /**
     * @var string
     * @Attribute(json = "request-url")
     */
    public $requestUrl;

    /**
     * @var array
     * @Attribute(json = "request-headers")
     */
    public $requestHeaders = array();

    /**
     * @var integer
     * @Attribute(json = "response-status-code")
     */
    public $responseCode;

    /**
     * @var array
     * @Attribute(json = "response-headers")
     */
    public $responseHeaders = array();

    /**
     * @var integer
     * @Attribute(json = "first-byte-time-millis")
     */
    public $firstByteTime;

    /**
     * @var integer
     * @Attribute(json = "last-byte-time-millis")
     */
    public $lastByteTime;

    /**
     * @var boolean
     * @Attribute(json = "was-cached")
     */
    public $wasCached;

    /**
     * @param mixed $refererUrl
     * @return ProtocolHttp
     */
    public function setRefererUrl($refererUrl)
    {
        $this->refererUrl = $refererUrl;
        return $this;
    }

    /**
     * @param mixed $requestMethod
     * @return ProtocolHttp
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * @param mixed $requestUrl
     * @return ProtocolHttp
     */
    public function setRequestUrl($requestUrl)
    {
        $this->requestUrl = $requestUrl;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return ProtocolHttp
     */
    public function addRequestHeaders($name, $value)
    {
        $this->requestHeaders[$name] = $value;
        return $this;
    }

    /**
     * @param mixed $responseCode
     * @return ProtocolHttp
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return ProtocolHttp
     */
    public function addResponseHeaders($name, $value)
    {
        $this->responseHeaders[$name] = $value;
        return $this;
    }

    /**
     * @param mixed $firstByteTime
     * @return ProtocolHttp
     */
    public function setFirstByteTime($firstByteTime)
    {
        $this->firstByteTime = $firstByteTime;
        return $this;
    }

    /**
     * @param mixed $lastByteTime
     * @return ProtocolHttp
     */
    public function setLastByteTime($lastByteTime)
    {
        $this->lastByteTime = $lastByteTime;
        return $this;
    }

    /**
     * @param mixed $wasCached
     * @return ProtocolHttp
     */
    public function setWasCached($wasCached)
    {
        $this->wasCached = $wasCached;
        return $this;
    }



}