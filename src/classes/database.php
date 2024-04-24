<?php
require '../../config.php';

ini_set("log_errors", 1);
ini_set("error_log", "/path/to/php-error.log");

define('DB_HOST', 'localhost');
define('DB_NAME', 'yellow');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

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

/*
<?php

class Database {
    private $host = "localhost";
    private $db_name = "blue";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
*/