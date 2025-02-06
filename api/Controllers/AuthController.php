<?php

namespace Api\Controllers;
use Api\Services\AuthService;
use Exception;

class AuthController extends Controller {

    public function userLogin($data) {

        if(isset($data['email']) && isset($data['password'])) {

            try {

                $email = $data['email'];
                $password = $data['password'];

                $authService = new AuthService();
                $userId = $authService->userLogin($email, $password);

                if(empty($userId)) {
                    throw new Exception('INVALID_LOGIN');
                } else {
                    
                    $data = [
                        'token' => $this->JWTCreate($userId)
                    ];

                    $this->sendResponse($data);
                }
                
            } catch (Exception $e) {
                $this->sendError($e->getMessage());
            }
            
        } else {
            $this->sendError('INVALID_DATA');
        }

    }

}