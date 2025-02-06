<?php

namespace Api\Routes;

class Api {

    public static function ApiRoutes($data) {
        
        Route::$found = false;

        // API Routes
        Route::post('/userLogin', ['AuthController', 'userLogin'], $data, 0);


        // When the received route is not defined. Return 404
        if(!Route::$found) {
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => true, 'message' => 'Not Found', 'status' => 404]);
        }
    }

}



