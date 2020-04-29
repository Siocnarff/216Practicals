<?php


class Database
{
    private $servername = "localhost";
    private $username = "siocnarff";
    private $serverPassword = "varkedansniemooi";
    private $db = "u19138182_cos216";

    public function createConnection()
    {
        // Create connection
        return new mysqli($this->servername, $this->username, $this->serverPassword, $this->db);
    }
}