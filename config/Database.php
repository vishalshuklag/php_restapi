<?php
    class Database {
        // properties -> DB params
        private $host = 'localhost';
        private $dbname = 'sample';
        private $username = 'root';
        private $password = 'root';
        private $conn ;

        public function connect() {
            $this->conn =null;
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $err) {
                echo 'Connection Error : ' .$err->getMessage();
            }

            return $this->conn;
        }
        
    }