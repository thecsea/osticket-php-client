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

class TicketRequest extends Request
{
    /**
     * TicketRequest constructor.
     */
    public function __construct(OsticketPhpClient $client)
    {
        $this->client = $client;
        $this->setDefaultData(array(
            'name'      =>      '',
            'email'     =>      '',
            'phone' 	=>		'',
            'subject'   =>      '',
            'message'   =>      '',
            'ip'        =>      isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:'127.0.0.1',
            'topicId'   =>      ''));
    }

    /**
     * @return mixed
     * @throws OsticketPhpClientException
     */
    public function get(){
        return $this->client->request('api/tickets.json', $this->data);
    }
}