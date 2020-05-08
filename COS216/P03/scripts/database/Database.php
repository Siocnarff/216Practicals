<?php

class Database
{
    private static $instance = null;
    private $connection;

    private $database;
    private $servername;
    private $username;
    private $serverPassword;

    private $userExistsStmt;
    private $insertUserStmt;
    private $verifySessionKeyStmt;

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $dbConfig = require("config.php");

        $this->servername = $dbConfig['servername'];
        $this->username = $dbConfig['username'];
        $this->serverPassword = $dbConfig['serverPassword'];
        $this->database = $dbConfig['database'];

        $this->connection = $this->createConnection();
        $this->prepStatements($this->connection);
    }

    private function prepStatements($conn)
    {
        $this->userExistsStmt = $conn->prepare(
            "select IF(exists(select * from User where Email = ?), 'T', 'F')"
        );
        $this->insertUserStmt = $conn->prepare(
            "insert into User (Name, Surname, Email, Password, Salt, APIKey) values (?, ?, ?, ?, ?, ?)"
        );
        $this->verifySessionKeyStmt = $conn->prepare(
            "select IF(exists(select * from User where APIKey = ?), 'T', 'F')"
        );
    }

    function userExists($email)
    {
        $this->userExistsStmt->bind_param('s', $email);
        $this->userExistsStmt->execute();
        $result = $this->userExistsStmt->get_result();
        return $result->fetch_all()[0][0] == 'T';
    }

    function insertIntoUser($name, $surname, $email, $pwdHashed, $salt, $apiKey)
    {
        $this->insertUserStmt->bind_param("ssssss", $name, $surname, $email, $pwdHashed, $salt, $apiKey);
        return $this->insertUserStmt->execute();
    }

    function validSession($apiKey)
    {
        $this->verifySessionKeyStmt->bind_param("s", $apiKey);
        $this->verifySessionKeyStmt->execute();
        return $this->verifySessionKeyStmt->get_result()->fetch_all()[0][0] == 'T';
    }

    function connectionIsDead()
    {
        if ($this->connection->connect_error) {
            $this->connection = $this->createConnection();
        }
        return $this->connection->connect_error;
    }

    private function createConnection()
    {
        return new mysqli($this->servername, $this->username, $this->serverPassword, $this->database);
    }

    function __destruct()
    {
        $this->connection->close();
    }
}