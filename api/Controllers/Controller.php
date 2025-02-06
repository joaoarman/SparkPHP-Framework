<?php

namespace Api\Controllers;
use Api\Middlewares\Auth;
use Api\Helpers\Errors;
use Exception;

class Controller {

    public function __construct(bool $isProtected) {

        // ** IMPORTANT **  
        // If the child controller defines a __construct method,  
        // it must explicitly call parent::__construct($isProtected)  
        // to ensure proper initialization.

        if($isProtected) {
            $isAtuhenticated = $this->JWTValidate();
            
            if(!$isAtuhenticated) {
                $this->sendError('UNAUTHORIZED');
            }
        }

    }

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

    protected function JWTCreate($userId) {
        return Auth::JWTCreate($userId);
    }

    protected function JWTValidate() {
        return Auth::JWTValidate();
    }

    protected function JWTRefresh() {
        return Auth::JWTRefresh();
    }
}