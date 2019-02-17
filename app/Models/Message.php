<?php

namespace App\Models;

class Message
{
    /** @var string  */
    private $address;

    /** @var string  */
    private $body;

    /**
     * Message constructor.
     * @param $address
     * @param $body
     */
    public function __construct(string $address, string $body)
    {
        $this->address = $address;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }



}
