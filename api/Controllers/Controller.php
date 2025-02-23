<?php

namespace Api\Controllers;
use Api\Helpers\Errors;
use Exception;

class Controller {

    protected function sendResponse(array $data, int $status = 200) {
        
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
        exit;
    }

    protected function sendError(string $errorKey) {

        $error = [];

        if(!isset(Errors::ERRORS[$errorKey])) {
            $error['message'] = $errorKey;
            $error['code'] = 500;
        } else {
            $error = Errors::ERRORS[$errorKey];
        }

        $data = [
            'error' => true,
            'message' => $error['message'],
            'status' => $error['code']
        ];

        $this->sendResponse($data, $error['code']);
    }

}