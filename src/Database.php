<?php

namespace Azcend\Core;


use PDO;

class Database
{
    private $host;
    private $username;
    private $password;
    private $db_name;
    private $conn;

    public function __construct() {
        $this->host = $_ENV['MYSQL_HOST'];
        $this->username = $_ENV['MYSQL_USER'];
        $this->password = $_ENV['MYSQL_PASSWORD'];
        $this->db_name = $_ENV['MYSQL_DATABASE'];

        $this->conn = new PDO("mysql:host=". $this->host .";dbname=". $this->db_name, $this->username, $this->password);
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function insert($sql, $data) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }
    public function close() {
        $this->conn = null;
    }
}