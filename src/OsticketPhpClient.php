<?php

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 06/08/16
 * Time: 17.12
 */
namespace it\thecsea\osticket_php_client;

use it\thecsea\osticket_php_client\requests\TicketRequest;

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
     * @param string $url
     * @param string $apiKey
     */
    public function __construct($url = '', $apiKey = '')
    {
        if($apiKey == '')
           $apiKey = getenv('OSTICKET_KEY');
        if($url == '')
            $url = getenv('OSTICKET_URL');
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

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }


    /**
     * @param string $path
     * @param array $data
     * @return mixed
     * @throws OsticketPhpClientException
     */
    public function request($path, $data){
        try {
            $res = $this->client->request('POST', $this->url . '/' . $path, [
                'json' => $data,
                'headers' => [
                    'User-Agent' => 'OsticketPhpClient/1.0',
                    'Accept' => 'application/json',
                    'Expect' => '',
                    'X-API-Key' => $this->apiKey
                ]
            ]);

        }catch(\Exception $e){
            throw new OsticketPhpClientException("Request error: ".$e->getMessage(),0,$e);
        }
        if ($res->getStatusCode() != 201)
            throw new OsticketPhpClientException("Server error: " . $res->getStatusCode());
        try {
            return \GuzzleHttp\Utils::jsonDecode($res->getBody(), true);
        }catch(\Exception $e){
            throw new OsticketPhpClientException("Error during parsing response",0,$e);
        }
    }

    /**
     * @return TicketRequest
     */
    public function newTicket(){
        return new TicketRequest($this);
    }
}