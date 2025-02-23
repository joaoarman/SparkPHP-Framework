<?php

namespace Api\Middlewares;
use Api\Helpers\Auth;

class AuthMiddleware {

    public static function AuthValidate() {
        return Auth::JWTValidate();
    }

}