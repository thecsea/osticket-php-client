<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 07/08/16
 * Time: 0.40
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \it\thecsea\osticket_php_client\OsticketPhpClient
     */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = new \it\thecsea\osticket_php_client\OsticketPhpClient('http://127.0.0.1');
    }

    public function testApiKey(){
        //test key get by env
        $this->assertEquals('AAAA', $this->client->getApiKey());

        //set
        $this->client->setApiKey('BBB');
        $this->assertEquals('BBB', $this->client->getApiKey());
    }

    public function testUrl(){
        //test url set constructor
        $this->assertEquals('http://127.0.0.1', $this->client->getUrl());

        //set
        $this->client->setUrl('http://example.com');
        $this->assertEquals('http://example.com', $this->client->getUrl());
    }

    public function testClient(){
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, ['X-Foo' => 'Bar']),
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->assertNotEquals($client, $this->client->getClient());

        //set
        $this->client->setClient($client);
        $this->assertEquals($client, $this->client->getClient());
    }

    public function testOkRequest(){
        $data = ['test'=>'pippo'];
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200,[], json_encode($data)),
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setClient($client);

        $response = $this->client->request('test', []);
        $this->assertEquals($data, $response);
    }

    public function testWrongRequest(){
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new  GuzzleHttp\Exception\RequestException("Error Communicating with Server", new GuzzleHttp\Psr7\Request('GET', 'test'))
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setClient($client);

        $message = '';
        try {
            $this->client->request('test', []);
        }catch(\Exception $e){
            $message = $e->getMessage();
        }
        $this->assertEquals('Request error: Error Communicating with Server', $message);
    }

    public function testRequestServerError(){
        $data = ['test'=>'pippo'];
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(202,[], json_encode($data)),
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setClient($client);

        $message = '';
        try {
            $this->client->request('test', []);
        }catch(\Exception $e){
            $message = $e->getMessage();
        }
        $this->assertEquals('Server error: 202', $message);
    }

    public function testRequestJSONError(){
        $data = ['test'=>'pippo'];
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200,[], json_encode($data).'test'),
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setClient($client);

        $message = '';
        try {
            $this->client->request('test', []);
        }catch(\Exception $e){
            $message = $e->getMessage();
        }
        $this->assertEquals('Error during parsing response', $message);
    }
}
