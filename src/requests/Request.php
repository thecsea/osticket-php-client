<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 07/08/16
 * Time: 14.34
 */

namespace it\thecsea\osticket_php_client\requests;

use it\thecsea\osticket_php_client\OsticketPhpClientException;

abstract class Request
{

    /*
     * string[]
     */
    protected $data = [];

    /**
     * @var string[]
     */
    private $keys = [];

    /**
     * @var OsticketPhpClient
     */
    protected $client;

    /**
     * @param $data
     */
    protected function setDefaultData($data){
        $this->data = $data;
        $this->keys = array_keys($this->data);
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
        $data = array_merge($this->data, $data);
        foreach ($this->keys as $key)
            $this->data[$key] = $data[$key];
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

    /**
     * @return mixed
     * @throws OsticketPhpClientException
     */
    abstract public function get();
}