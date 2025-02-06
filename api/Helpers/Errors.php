<?php

namespace Api\Helpers;

class Errors {

    public const ERRORS = [

        'GENERIC_ERROR' => [
            'message' => 'Undefined Error',
            'code' => 500
        ],

        'NOT_FOUND' => [
            'message' => 'Not Found',
            'code' => 404
        ],

        'UNAUTHORIZED' => [
            'message' => 'Unauthorized',
            'code' => 401
        ],

        'INVALID_LOGIN' => [
            'message' => 'Invalid login',
            'code' => 401
        ],

        'INVALID_DATA' => [
            'message' => 'Email and password are required',
            'code' => 400
        ],


        ];

}