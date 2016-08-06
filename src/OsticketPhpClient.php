<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 06/08/16
 * Time: 17.12
 */
namespace it\thecsea\osticket_php_client;

class OsticketPhpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $url;

    /**
     * osticketPhpClient constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey, $url)
    {
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    public function request($path, $data){
        //TODO ...
    }
}