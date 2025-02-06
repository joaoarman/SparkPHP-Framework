<?php

namespace Api\Middlewares;
use Api\Helpers\Env;

class Auth {

    public static function JWTCreate($userId) {

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            "iss" => Env::get('API_URL'),
            "iat" => time(),
            "nbf" => time(), 
            "exp" => time() + (60 * 60 * 24 * 2), // Expiration in 2 days
            "data" => [
                "user" => [
                    "id" => $userId,
                ],
            ]
        ];

        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", Env::get('JWT_SECRET_KEY'), true);

        $signatureEncoded = self::base64UrlEncode($signature);

        $jwt = "$headerEncoded.$payloadEncoded.$signatureEncoded";
        
        return $jwt;
    }

    public static function JWTValidate() {

        $headers = getallheaders();
        if(!isset($headers['Authorization'])) {
            return false;
        }

        $authorization = $headers['Authorization'];

        if (strpos($authorization, 'Bearer ') !== 0) {
            return false;
        }

        $jwt = str_replace('Bearer ', '', $authorization);

        if (!$jwt) {
            return false;
        }

        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) !== 3) {
            return false;
        }

        $headerEncoded = $tokenParts[0];
        $payloadEncoded = $tokenParts[1];
        $signatureReceived = $tokenParts[2];

        $header = json_decode(self::base64UrlDecode($headerEncoded), true);
        $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);

        if (!$header || !$payload) {
            return false;
        }

        $signatureCalculated = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", Env::get('JWT_SECRET_KEY'), true);
        $signatureCalculatedEncoded = self::base64UrlEncode($signatureCalculated);

        if (!hash_equals($signatureCalculatedEncoded, $signatureReceived)) {
            return false;
        }

        
        // Checking payload data

        if ($payload['iss'] !== Env::get('API_URL')) {
            return false;
        }

        if ($payload['exp'] < time()) {
            return false;
        }

        if ($payload['nbf'] > time()) {
            return false;
        }

        return true;

    }

    public static function JWTrefresh() {

        if(self::JWTValidate()) {

            $headers = getallheaders();
            $authorization = $headers['Authorization'];
            $jwt = str_replace('Bearer ', '', $authorization);
            $tokenParts = explode('.', $jwt);
            $headerEncoded = $tokenParts[0];
            $payloadEncoded = $tokenParts[1];

            $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);
            
            $userId = $payload['data']['user']['id'];

            $newJWT = self::JWTCreate($userId);
            
            return $newJWT;
        } else {
            return false;
        }
    }

    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data) {
        $padding = 4 - (strlen($data) % 4);
        if ($padding < 4) {
            $data .= str_repeat('=', $padding);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}