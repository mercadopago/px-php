<?php


namespace MercadoPago\Entities\Insight;


use MercadoPago\Config;
use MercadoPago\Entities\Insight\DTO\BusinessFlowInfo;
use MercadoPago\Entities\Insight\DTO\CertificateInfo;
use MercadoPago\Entities\Insight\DTO\ClientInfo;
use MercadoPago\Entities\Insight\DTO\ConnectionInfo;
use MercadoPago\Entities\Insight\DTO\DeviceInfo;
use MercadoPago\Entities\Insight\DTO\DnsInfo;
use MercadoPago\Entities\Insight\DTO\EventInfo;
use MercadoPago\Entities\Insight\DTO\ProtocolHttp;
use MercadoPago\Entities\Insight\DTO\ProtocolInfo;
use MercadoPago\Entities\Insight\DTO\StructuredMetricRequest;
use MercadoPago\Entities\Insight\DTO\TcpInfo;
use MercadoPago\Entities\Insight\DTO\TrafficLightRequest;
use MercadoPago\Entities\Insight\DTO\TrafficLightResponse;
use MercadoPago\Entity;
use MercadoPago\Http\CurlRequest;
use MercadoPago\Manager;
use MercadoPago\MetaDataReader;
use MercadoPago\RestClient;
use MercadoPago\SDK;
use MercadoPago\Version;

/**
 * RestMethod(resource="traffic-light", method="create")
 */
class InsightDataManager
{
    const INSIGHT_DEFAULT_BASE_URL = "https://events.mercadopago.com/v2/";
    const HEADER_X_INSIGHTS_BUSINESS_FLOW = "X-Insights-Business-Flow";
    const HEADER_X_INSIGHTS_EVENT_NAME = "X-Insights-Event-Name";
    const HEADER_X_INSIGHTS_METRIC_LAB_SCOPE = "X-Insights-Metric-Lab-Scope";
    const HEADER_X_INSIGHTS_DATA_ID = "X-Insights-Data-Id";
    const HEADER_X_PRODUCT_ID = "x-product-id";
    const HEADER_ACCEPT_TYPE = "Accept";
    const INSIGHTS_API_ENDPOINT_TRAFFIC_LIGHT = "traffic-light";
    const INSIGHTS_API_ENDPOINT_METRIC = "metric";

    const DEFAULT_TTL = 600;
    const DEFAULT_MAX_CONNECTIONS = 10;
    const DEFAULT_CONNECTION_TIMEOUT_MS = 3000;
    const VALIDATE_INACTIVITY_INTERVAL_MS = 30000;
    const DEFAULT_CONNECTION_REQUEST_TIMEOUT_MS = 5000;
    const DEFAULT_SOCKET_TIMEOUT_MS = 5000;

    /**
     * @var CurlRequest
     */
    private static $restClient;

    /**
     * @var TrafficLightResponse
     */
    private static $trafficLight;

    /**
     * @var int
     */
    private static $sendDataDeadlineMillis = PHP_INT_MIN;

    /**
     * @var InsightDataManager
     */
    private static $insightDataManager = null;

    /**
     * @var string
     */
    private static $osName = '';

    /**
     * @var string
     */
    private static $deviceRam = '';

    /**
     * @var string
     */
    private static $cpuType = '';

    public static function getInstance()
    {
        if (is_null(self::$insightDataManager)) {
            self::$insightDataManager = new InsightDataManager();
        }
        return self::$insightDataManager;
    }

    /**
     * InsightDataManager constructor.
     */
    public function __construct()
    {
        self::$restClient = new CurlRequest();
        $this->initializeDeviceInfo();
        self::$trafficLight = $this->callTrafficLight();
    }

    private function callTrafficLight()
    {
        $clientInfo = new ClientInfo();
        $clientInfo->name = 'MercadoPago-DX-PHP';
        $clientInfo->version = Version::$_VERSION;

        $trafficLightRequest = new TrafficLightRequest();
        $trafficLightRequest->clientInfo = $clientInfo;

        self::$restClient->setOption(CURLOPT_RETURNTRANSFER, 1);
        self::$restClient->setOption(CURLOPT_CUSTOMREQUEST, "POST");
        self::$restClient->setOption(CURLOPT_POSTFIELDS, $this->serialize($trafficLightRequest));
        self::$restClient->setOption(CURLOPT_URL, self::INSIGHT_DEFAULT_BASE_URL . self::INSIGHTS_API_ENDPOINT_TRAFFIC_LIGHT);
        self::$restClient->setOption(CURLOPT_HTTPHEADER, $this->getDefaultHeaders());

        $response = self::$restClient->execute();
        $trafficLightResponse = $this->deserialize(json_decode($response, true), TrafficLightResponse::class);
        self::$sendDataDeadlineMillis = round((microtime(true) + $trafficLightResponse->getSendTTL()) * 1000);

        return $trafficLightResponse;
    }

    private function initializeDeviceInfo()
    {
        $availableCPU = self::getNumberOfLogicalCPUCores();
        $osName = PHP_OS;
        $osVersion = php_uname('r');
        $modelName = "";
        $ram = $this->getSystemMemInfo();

        if(!is_null($ram) && !empty($ram)) {
            self::$deviceRam = ram;
        }

        if(!is_null($osName . " " . $osVersion) && !empty($osName . " " . $osVersion)) {
            self::$osName = $osName . " " . $osVersion;
        }

        if(!is_null($modelName) && !empty($modelName)) {
            self::$cpuType = $modelName;
            if($availableCPU != 0){
                self::$cpuType .= " - " . $availableCPU . " core";
            }
        }
    }

    public static function getNumberOfLogicalCPUCores() {
        // Needs a different implementation for each OS
        return 0;
    }

    public function getSystemMemInfo()
    {
        // Needs a different implementation for each OS
        return false;
    }

    public function isInsightMetricsEnable($url)
    {
        if (round(microtime(true) * 1000) > self::$sendDataDeadlineMillis) {
            self::$trafficLight = $this->callTrafficLight();
        }
        if (self::$trafficLight->isSendDataEnabled() && $this->isEndpointInWhiteList(self::$trafficLight, $url)) {
            return true;
        }
        return false;
    }

    public function isEndpointInWhiteList($trafficLightResponse, $requestUrl)
    {
        if (is_null(self::$trafficLight->getEndpointWhiteList()) || empty(self::$trafficLight->getEndpointWhiteList())) {
            return false;
        }

        foreach ($trafficLightResponse->getEndpointWhiteList() as $pattern) {
            if ($pattern === "*") { //todo check if there is a better way to check this
                return true;
            }

            $matched = true;
            $parts = split("\\*", $pattern);
            foreach ($parts as $part) {
                if (sizeof($part) == 0){
                    continue;
                }
                $matched = $matched && (strpos(strtolower($requestUrl), $part) !== false);
            }
            if ($matched) {
                return true;
            }
        }
        return false;
    }

    public function sendInsightMetrics($request, $response, $startMillis, $endMillis, $startRequestMillis)
    {
        $clientInfo = new ClientInfo();
        $clientInfo->name = 'MercadoPago-DX-PHP';
        $clientInfo->version = Version::$_VERSION;

        $businessFlowInfo = new BusinessFlowInfo();
        $businessFlowID = !is_null($request['headers'][self::HEADER_X_PRODUCT_ID]) ? $request['headers'][self::HEADER_X_PRODUCT_ID] : '';
        $businessFlowName = !is_null($request['headers'][self::HEADER_X_INSIGHTS_BUSINESS_FLOW]) ? $request['headers'][self::HEADER_X_INSIGHTS_BUSINESS_FLOW] : '';
        if(!empty($businessFlowID) || !empty($businessFlowName)) {
            $businessFlowInfo
                ->setName($businessFlowName)
                ->setUid($businessFlowID);
        }

        $eventInfo = new EventInfo();
        $eventName = !is_null($request['headers'][self::HEADER_X_INSIGHTS_EVENT_NAME]) ? $request['headers'][self::HEADER_X_INSIGHTS_EVENT_NAME] : '';
        if(!empty($eventName)) {
            $eventInfo->setName($eventName);
        }

        $protocolHttp = new ProtocolHttp();
        $protocolHttp->setRequestUrl($request['url'])
            ->setResponseCode($request['http_code'])
            ->setRequestMethod($request['method'])
            ->setFirstByteTime($startMillis - $startRequestMillis)
            ->setLastByteTime($endMillis - $startMillis);

        if (!empty($request['headers']) && !is_null($request['headers'])) {
            foreach ($request['headers'] as $key => $value) {
                if(strtolower($key) === strtolower(self::HEADER_X_INSIGHTS_DATA_ID)){
                    continue;
                }
                if (strtolower($key) === 'user_agent'){
                    continue;
                }
                $protocolHttp->addRequestHeaders($key, $value);
            }
        }

        if (!empty($response['headers']) && !is_null($response['headers'])) {
            foreach ($response['headers'] as $key => $value) {
                $protocolHttp->addResponseHeaders($key, $value);
            }
        }

        $protocolInfo = new ProtocolInfo();
        $protocolInfo
            ->setName('http')
            ->setProtocolHttp($protocolHttp);

        $dnsInfo = new DnsInfo();
        $dnsInfo
            ->setLookupTime($request['namelookup_time'])
            ->setNameServerAddress($_SERVER['SERVER_NAME'])
        ;

        $certificateInfo = new CertificateInfo();
        $certificateInfo
            ->setCertificateVersion($request['certinfo'][1]['Version'])
            ->setCertificateExpiration(date("d-m-Y", strtotime($request['certinfo'][1]['Expire date'])))
        ;

        $tcpInfo = new TcpInfo();
        $tcpInfo
            ->setSourceAddress($_SERVER['REMOTE_ADDR'])
        ;

        $connectionInfo = new ConnectionInfo();
        $connectionInfo
            ->setProtocolInfo($protocolInfo)
            ->setCompleteData($endMillis > 0)
            ->setNetworkSpeed($request['speed_download'])
            ->setDnsInfo($dnsInfo)
            ->setCertificateInfo($certificateInfo)
            ->setUserAgent($_SERVER["HTTP_USER_AGENT"])
        ;

        $deviceInfo = new DeviceInfo();
        if ((!empty(self::$osName) && !is_null(self::$osName)) ||
            (!empty(self::$deviceRam) && !is_null(self::$deviceRam)) ||
            (!empty(self::$cpuType) && !is_null(self::$cpuType))
        ) {
            $deviceInfo
                ->setCpuType(self::$cpuType)
                ->setOsName(self::$osName)
                ->setRamSize(self::$deviceRam);
        }

        $structuredMetricRequest = new StructuredMetricRequest();
        $structuredMetricRequest
            ->setEventInfo($eventInfo)
            ->setClientInfo($clientInfo)
            ->setBusinessFlowInfo($businessFlowInfo)
            ->setConnectionInfo($connectionInfo)
            ->setDeviceInfo($deviceInfo);

        self::$restClient->setOption(CURLOPT_RETURNTRANSFER, 1);
        self::$restClient->setOption(CURLOPT_POST, 1);
        self::$restClient->setOption(CURLOPT_URL, self::INSIGHT_DEFAULT_BASE_URL . self::INSIGHTS_API_ENDPOINT_METRIC);
        $json = $this->serialize($structuredMetricRequest);
        self::$restClient->setOption(CURLOPT_POSTFIELDS, $json);

        return self::$restClient->execute();
    }

    public function getDefaultHeaders()
    {
        return [
            self::HEADER_X_INSIGHTS_METRIC_LAB_SCOPE . ':' . SDK::getMetricsScope(),
            self::HEADER_ACCEPT_TYPE . ':application/json',
            'Content-Type:application/json'
        ];
    }

    public function serialize($entity){
        $reader = new MetaDataReader();
        $metadata = $reader->getMetaData($entity);
        $json = [];
        if (isset($metadata->attributes)){
            foreach ($metadata->attributes as $attributeName => $attribute) {
                if (!is_null($attribute['json']) && !empty($attribute['json'])) {
                    $key = $attribute['json'];
                }else{
                    $key = $attributeName;
                }

                if (!empty($entity->$attributeName) && !is_null($entity->$attributeName)){
                    if(is_object($entity->$attributeName)){
                        $value = json_decode($this->serialize($entity->$attributeName));
                    }else {
                        $value = $entity->$attributeName;
                    }
                    if (!empty($value)){
                        $json[$key] = $value;
                    }
                }
            }
        }
        return json_encode($json);
    }

    public function deserialize($json, $class) {
        $reader = new MetaDataReader();
        $object = new $class();
        $metadata = $reader->getMetadata($object);

        foreach ($metadata->attributes as $attributeName => $attributeValue) {
            $setMethod = 'set'.ucfirst($attributeName);
            if (method_exists($object, $setMethod)) {
                if (!is_null($attributeValue['json']) && !empty($attributeValue['json'])) {
                    $object->$setMethod($json[$attributeValue['json']]);
                }else{
                    $object->$setMethod($json[$attributeName]);
                }
            }
        }
        return $object;
    }
}
