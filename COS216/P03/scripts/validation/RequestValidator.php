<?php


class RequestValidator
{
    private $conn;
    private $stmt;

    function __construct($conn)
    {
        $this->conn = $conn;
        $this->stmt = $this->conn->prepare(
            "select IF(exists(select * from User where Email = ? and APIKey = ?), 'T', 'F')"
        );
    }

    function validate($email, $apiKey)
    {
        $this->stmt->bind_param("ss", $email, $apiKey);
        $this->stmt->execute();
        return $this->stmt->get_result()->fetch_all()[0][0] == 'T';
    }

    function kill()
    {
        $this->stmt->close();
    }

    function __destruct()
    {
        $this->kill();
    }
}