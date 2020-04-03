<?php
namespace MercadoPago;

/**
 * MercadoPagoSdk Class Doc Comment
 *
 * @package MercadoPago
 */
class SDK
{

    const DEFAULT_METRICS_SCOPE = 'prod';
    const TEST_METRICS_SCOPE = 'test';
    const PRODUCT_ID = 'BC32A7RU643001OI3940';

    /**
     * @var Config
     */
    protected static $_config;
    /**
     * @var Manager
     */
    protected static $_manager;

    /**
     * @var
     */
    protected static $_restClient;

    protected static $metricsScope = self::DEFAULT_METRICS_SCOPE;

    /**
     * MercadoPagoSdk constructor.
     */
    public static function initialize()
    {
        self::$_restClient = new RestClient();
        self::$_config = new Config(null, self::$_restClient);
        self::$_restClient->setHttpParam('address', self::$_config->get('base_url'));
        self::$_manager = new Manager(self::$_restClient, self::$_config);
        Entity::setManager(self::$_manager);
    }
    
    /**
     * Set Access Token for SDK .
     */
    public static function setAccessToken($access_token){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['ACCESS_TOKEN' => $access_token]);
      
    }

    public static function getAccessToken(){
      return self::$_config->get('ACCESS_TOKEN');
    }

    public static function getCountryId(){
        return self::$_config->get('COUNTRY_ID');
    }

    public static function cleanCredentials(){
      if (self::$_config == null) {
        // do nothing
      } else {
        self::$_config->clean();
      }
    }
    
    public static function setMultipleCredentials($array){
        foreach($array as $key => $values) {
          self::$_config->configure([$key => $values]); 
        }
    }

    /**
     * Set Access ClientId for SDK .
     */
    public static function setClientId($client_id){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['CLIENT_ID' => $client_id]); 
    }

    public static function getClientId(){
      return self::$_config->get('CLIENT_ID');
    }
    
    /**
     * Set Access ClientSecret for SDK .
     */
    public static function setClientSecret($client_secret){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['CLIENT_SECRET' => $client_secret]); 
    }

    public static function getClientSecret(){
      return self::$_config->get('CLIENT_SECRET');
    }

    /**
     * Set Access ClientSecret for SDK .
     */
    public static function setPublicKey($public_key){ 
      self::$_config->configure(['PUBLIC_KEY' => $public_key]); 
    }

    public static function getPublicKey(){
      return self::$_config->get('PUBLIC_KEY');
    }
    
    public static function configure($data=[])
    {
      self::initialize();
      self::$_config->configure($data);
    }

    /**
     * @return Config
     */
    public static function config()
    {
      return self::$_config;
    }
    
    public static function addCustomTrackingParam($key, $value)
    {
      self::$_manager->addCustomTrackingParam($key, $value);
    }
    
    
    // Publishing generic functions 
    
    public static function get($uri, $options=[])
    {
      if ($token = self::$_config->get('ACCESS_TOKEN')) {
        $uri = $uri . "?access_token=" . $token;
      }
      return self::$_restClient->get($uri, $options);
    }
    
    public static function post($uri, $options=[])
    {
      if ($token = self::$_config->get('ACCESS_TOKEN')) {
        $uri = $uri . "?access_token=" . $token;
      }
      return self::$_restClient->post($uri, $options);
    }
    
    public static function put($uri, $options=[])
    {
      if ($token = self::$_config->get('ACCESS_TOKEN')) {
        $uri = $uri . "?access_token=" . $token;
      }
      return self::$_restClient->put($uri, $options);
    }
    
    public static function delete($uri, $options=[])
    {
      if ($token = self::$_config->get('ACCESS_TOKEN')) {
        $uri = $uri . "?access_token=" . $token;
      }
      return self::$_restClient->delete($uri, $options);
    }

    /**
     * Set Platform Id for SDK .
     */
    public static function setPlatformId($platform_id){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['x-platform-id' => $platform_id]);
      self::addCustomTrackingParam('x-platform-id', $platform_id);
    }

    public static function getPlatformId(){
      return self::$_config->get('x-platform-id');
    }

    /**
     * Set Corporation Id for SDK .
     */
    public static function setCorporationId($corporation_id){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['x-corporation-id' => $corporation_id]);
      self::addCustomTrackingParam('x-corporation-id', $corporation_id);
    }

    public static function getCorporationId(){
      return self::$_config->get('x-corporation-id');
    }

    /**
     * Set Integrator Id for SDK .
     */
    public static function setIntegratorId($integrator_id){
      if (!isset(self::$_config)){
        self::initialize();
      }
      self::$_config->configure(['x-integrator-id' => $integrator_id]);
      self::addCustomTrackingParam('x-integrator-id', $integrator_id);
    }

    public static function getIntegratorId(){
      return self::$_config->get('x-integrator-id');
    }

    /**
     * Get the CRE metrics scope
     * @return string
     */
    public static function getMetricsScope(){
        return self::$metricsScope;
    }

    /**
     * Set CRE metrics scope
     * @param $value string
     */
    public static function setMetricsScope($value) {
        self::$metricsScope = strval($value);
    }

    public static function setTestMetricsScope(){
        self::setMetricsScope(self::TEST_METRICS_SCOPE);
    }
}

