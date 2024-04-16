<?php
require '../../config.php';

define('DB_HOST', 'localhost');
define('DB_NAME', 'yellow');
define('DB_USER', 'computify');
define('DB_PASSWORD', 'com321test@123');
class Database {
    private $conn; //store PDO object 

    public function getConnection() {
        $this->conn = null;

        try {
            //mysql:host={$this->host};dbname={$this->dbname} SQL connection string 
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

            // $this->conn = new PDO($dsn, DB_USER, DB_PASSWORD) ; 

            $this->conn = new PDO($dsn, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true
            ]);

        } catch (PDOException $e) {
           
            throw $e; 
            
        }

        return $this->conn;
    }


}

