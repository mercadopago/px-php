<?php


namespace MercadoPago\Entities\Insight\DTO;

use MercadoPago\Annotation\Attribute;

class DeviceInfo
{
    const SerialVersionUID = 1;

    /**
     * @var string
     * @Attribute(json = "os-name")
     */
    public $osName;

    /**
     * @var string
     * @Attribute(json = "model-name")
     */
    public $modelName;

    /**
     * @var string
     * @Attribute(json = "cpu-type")
     */
    public $cpuType;

    /**
     * @var string
     * @Attribute(json = "ram-size")
     */
    public $ramSize;

    /**
     * @param mixed $osName
     * @return DeviceInfo
     */
    public function setOsName($osName)
    {
        $this->osName = $osName;
        return $this;
    }

    /**
     * @param mixed $modelName
     * @return DeviceInfo
     */
    public function setModelName($modelName)
    {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * @param mixed $cpuType
     * @return DeviceInfo
     */
    public function setCpuType($cpuType)
    {
        $this->cpuType = $cpuType;
        return $this;
    }

    /**
     * @param mixed $ramSize
     * @return DeviceInfo
     */
    public function setRamSize($ramSize)
    {
        $this->ramSize = $ramSize;
        return $this;
    }
}