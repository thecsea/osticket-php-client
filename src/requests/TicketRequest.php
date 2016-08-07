<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 06/08/16
 * Time: 18.44
 */
namespace it\thecsea\osticket_php_client\requests;

use it\thecsea\osticket_php_client\OsticketPhpClient;
use it\thecsea\osticket_php_client\OsticketPhpClientException;

class TicketRequest
{
    /**
     * @var OsticketPhpClient
     */
    private $client;
    /*
     * string[]
     */
    private $data = [];

    /**
     * TicketRequest constructor.
     */
    public function __construct(OsticketPhpClient $client)
    {
        $this->client = $client;
        $this->data = array(
            'name'      =>      '',
            'email'     =>      '',
            'phone' 	=>		'',
            'subject'   =>      '',
            'message'   =>      '',
            'ip'        =>      '127.0.0.1',//$_SERVER['REMOTE_ADDR'],
            'topicId'   =>      '');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function withData($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws OsticketPhpClientException
     */
    function __call($name, $arguments)
    {
        $nameData = substr($name,strlen('with'));
        if(strtolower(substr($name,0,strlen('with'))) == "with" && isset($this->data[lcfirst($nameData)]) && count($arguments) == 1 && is_string($arguments[0])) {
            $this->data[lcfirst($nameData)] = $arguments[0];
            return $this;
        }
        throw new OsticketPhpClientException("Method invalid: ".$name);
    }

    public function get(){
        return $this->client->request('api/tickets.json', $this->data);
    }

}