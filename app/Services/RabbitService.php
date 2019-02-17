<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitService
{
    private $connection;

    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $container->getParameter('rabbit.host'),
            $container->getParameter('rabbit.port'),
            $container->getParameter('rabbit.login'),
            $container->getParameter('rabbit.password'));

        $this->channel =$this->connection->channel();

        $this->channel->queue_declare('posts', false, false, false, false);
    }

    public function sendMessage($body){
        $msg = new AMQPMessage($body);

        $this->channel->basic_publish($msg, '', 'posts');
    }

    public function getMessages(callable $callback)
    {
        $this->channel->basic_consume('posts', '',
            false, true, false, false,
            $callback);
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->connection->close();
        $this->channel->close();
    }
}
