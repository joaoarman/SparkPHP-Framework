<?php

use Api\Routes\Api;

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$input = file_get_contents('php://input');
$requestData = json_decode($input, true);

Api::ApiRoutes($requestData);





