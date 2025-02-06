<?php

namespace Api\Repositories;
use Config\Connection;

class Repository
{
    protected $connection;

    public function __construct() {
        $this->connection = new Connection();
    }

    public function __destruct() {
        $this->connection->closeConnection();
    }
}