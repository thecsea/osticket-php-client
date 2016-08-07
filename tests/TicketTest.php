<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 07/08/16
 * Time: 0.40
 */
class TicketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \it\thecsea\osticket_php_client\OsticketPhpClient
     */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = new \it\thecsea\osticket_php_client\OsticketPhpClient('127.0.0.1');
    }

    public function testSettingOfData(){
        $ticket = $this->client->newTicket()
            ->withName('test')
            ->withEmail('test@test.com')
            ->withPhone('0123456789')
            ->withSubject('subject')
            ->withMessage('message')
            ->withTopicId('1');
        $this->assertEquals([
            'name'=>'test',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'subject' => 'subject',
            'message' => 'message',
            'topicId' => '1',
            'ip' => '127.0.0.1'
        ], $ticket->getData());
    }

    public function testSettingOfDataViaSetter(){
        $data = [
            'name'=>'test',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'subject' => 'subject',
            'message' => 'message',
            'topicId' => '1',
            'ip' => '127.0.0.1'
        ];
        $ticket = $this->client->newTicket();
        $this->assertNotEquals($data, $ticket->getData());
        $ticket->withData($data);
        $this->assertEquals($data, $ticket->getData());
    }


    public function testWrongSettingOfDataViaSetter(){
        $data = [
            'name'=>'test',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'subject' => 'subject',
            'message' => 'message',
            'topicId' => '1',
            'ip' => '127.0.0.1',
            'ipAAA' => '127.0.0.1'
        ];
        $ticket = $this->client->newTicket();
        $this->assertNotEquals($data, $ticket->getData());
        $ticket->withData($data);
        $this->assertNotEquals($data, $ticket->getData());
        unset($data['ipAAA']);
        $this->assertEquals($data, $ticket->getData());
    }

    public function testMethodInvalid(){
        $thrown = false;
        try {
            $ticket = $this->client->newTicket()->withTest('test');
        }catch(\Exception $e){
            $thrown = true;
        }
        $this->assertTrue($thrown);
    }

    public function testOkRequest(){
        $data = ['test'=>'pippo'];
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200,[], json_encode($data)),
        ]);
        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setClient($client);

        $ticket = $this->client->newTicket();
        $this->assertEquals($data, $ticket->get());
    }
}
