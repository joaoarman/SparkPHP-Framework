<?php

namespace Config;
use Api\Helpers\Env;
use PDO;

class Connection
{
    private $pdo;

    public function __construct() {
        $DB_CONNECTION = Env::get('DB_CONNECTION');
        $MYSQL_HOST = Env::get('MYSQL_HOST');
        $MYSQL_DATABASE = Env::get('MYSQL_DATABASE');
        $MYSQL_USER = Env::get('MYSQL_USER');
        $MYSQL_PASSWORD = Env::get('MYSQL_PASSWORD');

        try {
            $this->pdo = new PDO("$DB_CONNECTION:host=$MYSQL_HOST;dbname=$MYSQL_DATABASE", $MYSQL_USER, $MYSQL_PASSWORD);
        } catch(Exception $e) {
            echo "Erro de conexão (Arquivo: connection.php) <br><br> " . $e->getMessage();
            exit();
        }
    }

    public function closeConnection() {
        $this->pdo = null;
    }

    // -----
    // -----
    // -----
    // ------------------------------ Helpers Methods ------------------------------
    public function querySingleResult(String $sql, Array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if($params) {
            foreach($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            $stmt->execute();
        }
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function querySingleArrayResult(String $sql, Array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if($params) {
            foreach($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            $stmt->execute();
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($rows)) {
            return [];
        } else {
            $result = [];
            foreach ($rows[0] as $key => $row) {
                $result[$key] = $row; 
            }

            return $result;
        }
    }

    public function queryMultipleArrayResult(String $sql, Array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if($params) {
            foreach($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            $stmt->execute();
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insertSQL(String $sql, Array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if($params) {
            foreach($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            $stmt->execute();
        }
    }

    public function updateSQL(String $sql, Array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if($params) {
            foreach($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            $stmt->execute();
        }
    }
}
