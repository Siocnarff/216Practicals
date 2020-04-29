<?php

function userExists($conn, $email)
{
    $stmt = $conn->prepare("select IF(exists(select * from User where Email = ?), 'TRUE', 'FALSE')");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_all()[0][0] == 'TRUE';
}

function setUserInDB($conn, $name, $surname, $email, $password, $apiKey)
{
    $salt = generateRandomKey();
    $pwdPeppered = hash_hmac("sha256",  $password, getPepper(), false);
    $pwdHashed = password_hash($pwdPeppered,PASSWORD_BCRYPT, ["salt" => $salt, "cost" => 10]);
    $stmt = $conn->prepare("insert into User (Name, Surname, Email, Password, Salt, APIKey) values (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $email, $pwdHashed, $salt, $apiKey);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

function generateRandomKey()
{
    //return bin2hex(mcrypt_create_iv(32, MCRYPT_RAND));
    $crypto_strong = true;
    return bin2hex(openssl_random_pseudo_bytes(32, $crypto_strong));
}

function getPepper()
{
    $configVars = parse_ini_file("conf/config.conf");
    return $configVars["pepper"];
}

function getKeyPepper()
{
    $configVars = parse_ini_file("conf/config.conf");
    return $configVars["keyPepper"];
}

function validName($name)
{
    return preg_match(
        "/^[a-zA-Z\s]{1,40}$/",
        $name
    );
}


function validPassword($password)
{
    return preg_match(
        "/(?=^.{9,}$)((?=.*\w)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[|!\"@#$%&\/()?^'+\-*]))^.*/",
        $password
    );
}

function validEmail($email)
{
    // RFC5322 compliant
    return preg_match(
        "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)])/",
        $email
    );
}

function findAppropriateCost() {
    $timeTarget = 0.05; // 50 milliseconds
    $cost = 8;
    do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);

    return $cost;
}

?>