<?php


namespace MercadoPago\Entities\Insight;


use MercadoPago\Entities\Insight\InsightDataManager;
use MercadoPago\Http\HttpRequest;

class Stats
{

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var mixed
     */
    private $httpResponse;

    /**
     * @var int
     */
    private $startMillis;

    /**
     * @var int
     */
    private $endMillis;

    /**
     * @var int
     */
    private $startRequestMillis;

    /**
     * @var string
     */
    private $httpVerb;

    private $requestHeaders;
    /**
     * Stats constructor.
     * @param HttpRequest $httpRequest
     * @param mixed $httpResponse
     * @param int $startMillis
     * @param int $endMillis
     * @param int $startRequestMillis
     * @param mixed $context
     */
    public function __construct($httpRequest, $httpResponse, $startMillis, $endMillis, $startRequestMillis)
    {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->startMillis = $startMillis;
        $this->endMillis = $endMillis;
        $this->startRequestMillis = $startRequestMillis;
    }

    public function run()
    {
        $insightDataManager = InsightDataManager::getInstance();

        if ($insightDataManager->isInsightMetricsEnable($this->httpReques['url'])) {
            $insightDataManager->sendInsightMetrics($this->httpRequest, $this->httpResponse, $this->startMillis, $this->endMillis, $this->startRequestMillis);
        }
    }
}