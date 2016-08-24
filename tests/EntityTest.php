<?php

namespace MercadoPago;

/**
 * EntityTest Class Doc Comment
 *
 * @package MercadoPago
 */
class EntityTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $config;
    protected $_entity;

    /**
     *
     */
    protected function setUp()
    {
        $restClient = new RestClient();
        $config = new Config(null, $restClient);

        $manager = new Manager($restClient, $config);
        Entity::setManager($manager);

        $this->_entity = new DummyEntity();
    }

    /**
     *
     */
    protected function tearDown()
    {
    }

    /**
     */
    public function testSetVariables()
    {
        $this->_entity->title = 'Title';
        $this->_entity->desc = 'Description';
        $this->_entity->price =100.5;
        $this->_entity->quantity = 3;
        $this->_entity->registered_at = '02/14/2015';
        $object = new \stdClass();
        $this->_entity->object = $object;
        $this->_entity->other = 'other';

        $expectedValues = [
            "id"            => null,
            "title"         => "Title",
            "desc"          => "Description",
            "price"         => 100.5,
            "quantity"      => 3,
            "registered_at" => "2015-02-14T00:00:00+0000",
            "object"        => $object,
            "other"        => 'other'
        ];

        $this->assertEquals($expectedValues, $this->_entity->toArray());
    }

    /**
     */
    public function testGetVariables()
    {
        $this->_entity->title = 'Title';
        $this->_entity->desc = 'Description';
        $this->_entity->price =100.5;
        $this->_entity->quantity = 3;
        $this->_entity->registered_at = '02/14/2015';
        $object = new \stdClass();
        $this->_entity->object = $object;
        $this->_entity->other = 'other';

        $expectedValues = [
            "id"            => null,
            "title"         => "Title",
            "desc"          => "Description",
            "price"         => 100.5,
            "quantity"      => "3",
            "registered_at" => "2015-02-14T00:00:00+0000",
            "object"        => $object,
            "other"        => 'other'
        ];

        $actualValues = [
            "id"            => $this->_entity->id,
            "title"         => $this->_entity->title,
            "desc"          => $this->_entity->desc,
            "price"         => $this->_entity->price,
            "quantity"      => $this->_entity->quantity,
            "registered_at" => $this->_entity->registered_at,
            "object"        => $this->_entity->object,
            "other"        => $this->_entity->other,
        ];

        $this->assertEquals($expectedValues, $actualValues);
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Wrong type object. It should be int for property quantity
     */
    public function testInvalidType()
    {
        $this->_entity->quantity = new \stdClass();
    }

    /**
     */
    public function testLoadAll()
    {
        $hub = new FakeApiHub();
        $request = $this->getMockBuilder('MercadoPago\Http\CurlRequest')->getMock();
        $request->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($hub->getJson('GET', '/dummies')));
        $request->expects($this->once())
            ->method('getInfo')->withAnyParameters()
            ->will($this->returnValue('200'));

        $restClient = new RestClient();
        $restClient->setHttpRequest($request);
        $config = new Config(null, $restClient);

        $manager = new Manager($restClient, $config);
        Entity::setManager($manager);

        $this->_entity = new DummyEntity();

        $this->assertEquals((array)json_decode($hub->getJson('GET', '/dummies')), $this->_entity->loadAll()['body']);

    }

    /**
     */
    public function testSave()
    {
        $hub = new FakeApiHub();
        $request = $this->getMockBuilder('MercadoPago\Http\CurlRequest')->getMock();
        $request->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($hub->getJson('POST', '/v1/payments')));
        $request->expects($this->once())
            ->method('getInfo')->withAnyParameters()
            ->will($this->returnValue('200'));

        $restClient = new RestClient();
        $restClient->setHttpRequest($request);
        $config = new Config(null, $restClient);

        $manager = new Manager($restClient, $config);
        Entity::setManager($manager);

        $this->_entity = new DummyEntity();

        $this->_entity->save();
        $this->assertEquals('1340404', $this->_entity->id);

    }

    /**
     */
    public function testDynamicAttributes()
    {
        $this->_entity->dynamicAttribute = 100;

        $this->assertEquals(100, $this->_entity->dynamicAttribute);
    }


    /**
     */
    public function testLoad()
    {

    }

    /**
     */
    public function testAddNew()
    {

    }

    /**
     */
    public function testUpdate()
    {

    }

    /**
     */
    public function testDestroy()
    {

    }

    /**
     */
    public function save()
    {

    }

}