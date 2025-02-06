<?php

namespace Api\Repositories;

class AuthRepository extends Repository
{
    
    public function userLogin($email, $password) {
        
        $sql = "SELECT id FROM user WHERE email = :email AND password = :password";
        $userId = $this->connection->querySingleResult($sql, ['email' => $email, 'password' => $password]);
        
        return $userId;
    }
}