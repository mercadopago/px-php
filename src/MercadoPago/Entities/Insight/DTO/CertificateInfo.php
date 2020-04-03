<?php


namespace MercadoPago\Entities\Insight\DTO;
use MercadoPago\Annotation\Attribute;

class CertificateInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "certificate-type")
     */
    public $certificateType;

    /**
     * @var string
     * @Attribute(json = "certificate-version")
     */
    public $certificateVersion;

    /**
     * @var string
     * @Attribute(json = "certificate-expiration")
     */
    public $certificateExpiration;

    /**
     * @var int
     * @Attribute(json = "handshake-time-millis")
     */
    public $handshakeTime;

    /**
     * @param string $certificateType
     * @return CertificateInfo
     */
    public function setCertificateType($certificateType)
    {
        $this->certificateType = $certificateType;
        return $this;
    }

    /**
     * @param string $certificateVersion
     * @return CertificateInfo
     */
    public function setCertificateVersion($certificateVersion)
    {
        $this->certificateVersion = $certificateVersion;
        return $this;
    }

    /**
     * @param string $certificateExpiration
     * @return CertificateInfo
     */
    public function setCertificateExpiration($certificateExpiration)
    {
        $this->certificateExpiration = $certificateExpiration;
        return $this;
    }

    /**
     * @param int $handshakeTime
     * @return CertificateInfo
     */
    public function setHandshakeTime($handshakeTime)
    {
        $this->handshakeTime = $handshakeTime;
        return $this;
    }


}