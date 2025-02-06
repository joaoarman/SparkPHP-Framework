<?php

namespace Api\Services;
use Api\Repositories\AuthRepository;

class AuthService extends Service
{

    public function userLogin($email, $password) {

        $authRepository = new AuthRepository();
        $userId = $authRepository->userLogin($email, $password);

        return $userId;
    }

    


} 