<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class ConnectionInfo
{
    const serialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "network-type")
     */
    public $networkType;

    /**
     * @var string
     * @Attribute(json = "network-speed")
     */
    public $networkSpeed;

    /**
     * @var string
     * @Attribute(json = "user-agent")
     */
    public $userAgent;

    /**
     * @var boolean
     * @Attribute(json = "was-reused")
     */
    public $wasReused;

    /**
     * @var DnsInfo
     * @Attribute(json = "dns-info")
     */
    public $dnsInfo;

    /**
     * @var CertificateInfo
     * @Attribute(json = "certificate-info")
     */
    public $certificateInfo;

    /**
     * @var TcpInfo
     * @Attribute(json = "tcp-info")
     */
    public $tcpInfo;

    /**
     * @var ProtocolInfo
     * @Attribute(json = "protocol-info")
     */
    public $protocolInfo;

    /**
     * @var boolean
     * @Attribute(json = "is-complete")
     */
    public $completeData;

    /**
     * @param string $networkType
     * @return ConnectionInfo
     */
    public function setNetworkType($networkType)
    {
        $this->networkType = $networkType;
        return $this;
    }

    /**
     * @param string $networkSpeed
     * @return ConnectionInfo
     */
    public function setNetworkSpeed($networkSpeed)
    {
        $this->networkSpeed = strval($networkSpeed);
        return $this;
    }

    /**
     * @param string $userAgent
     * @return ConnectionInfo
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = strval($userAgent);
        return $this;
    }

    /**
     * @param bool $wasReused
     * @return ConnectionInfo
     */
    public function setWasReused($wasReused)
    {
        $this->wasReused = $wasReused;
        return $this;
    }

    /**
     * @param DnsInfo $dnsInfo
     * @return ConnectionInfo
     */
    public function setDnsInfo($dnsInfo)
    {
        $this->dnsInfo = $dnsInfo;
        return $this;
    }

    /**
     * @param CertificateInfo $certificateInfo
     * @return ConnectionInfo
     */
    public function setCertificateInfo($certificateInfo)
    {
        $this->certificateInfo = $certificateInfo;
        return $this;
    }

    /**
     * @param TcpInfo $tcpInfo
     * @return ConnectionInfo
     */
    public function setTcpInfo($tcpInfo)
    {
        $this->tcpInfo = $tcpInfo;
        return $this;
    }

    /**
     * @param ProtocolInfo $protocolInfo
     * @return ConnectionInfo
     */
    public function setProtocolInfo($protocolInfo)
    {
        $this->protocolInfo = $protocolInfo;
        return $this;
    }

    /**
     * @param bool $completeData
     * @return ConnectionInfo
     */
    public function setCompleteData($completeData)
    {
        $this->completeData = $completeData;
        return $this;
    }


}