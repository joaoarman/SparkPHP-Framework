<?php

namespace Api\Helpers;
use Dotenv\Dotenv;

class Env {

    public static function get($key) {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        return $_ENV[$key];
    }

}