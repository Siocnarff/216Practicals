<?php


class Database
{
    private static $instance = null;
    private $servername = "localhost";
    private $username = "siocnarff";
    private $serverPassword = "varkedansniemooi";
    private $db = "u19138182_cos216";
    private $connection;

    private function __construct()
    {
        $this->connection = $this->createConnection();
    }

    private function createConnection()
    {
        return new mysqli($this->servername, $this->username, $this->serverPassword, $this->db);
    }

    public function connection()
    {
        if ($this->connection->connect_error) {
            $this->connection = $this->createConnection();
        }
        return $this->connection;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}