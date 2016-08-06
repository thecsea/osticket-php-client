<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 06/08/16
 * Time: 17.12
 */
namespace it\thecsea\osticket_php_client;

class osticketPhpClient
{
    private $client;
    /**
     * @var string
     */
    private $apiKey;

    /**
     * osticketPhpClient constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new \GuzzleHttp\Client();
    }


}