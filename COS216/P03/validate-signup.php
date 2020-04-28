<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P03 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,ranking,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>BadLama Music</title>
</head>
<body>
<?php
session_start();
include_once("header.php");
$conn = createConnection();
if ($conn->connect_error) {
    echo("<div><h3 class='center'>Could not connect to the database, please try again later.</h3></div>");
} else {
    addUser($conn);
}
include_once("footerDeezer.php");

function addUser($conn)
{
    $name = strtolower($_POST['name']);
    $surname = strtolower($_POST['surname']);
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    if (validEmail($email) and validName($name) and validName($surname) and validPassword($password)) {
        if (userExists($conn, $email)) {
            echo("<div class='center key_info'><p>User with email $email already exists. <a href='signup.php'>Try Again.</a></p></div>");
            return;
        }
        $apiKey = generateRandomKey();
        if (setUserInDB($conn, $name, $surname, $email, $password, $apiKey)) {
            echo("<div class='center key_info'><p>Your API Key: $apiKey</p> <h2 class='welcome_image'>You Have Been Registered!</h2></div>");
        } else {
            echo("<div><h2 class='center welcome_image'>Could Not Register You. <a href='signup.php'>Try Again.</a></h2></div>");
        }
    } else {
        echo("<div><h2 class='center welcome_image'>User Info Is Not Valid. <a href='signup.php'>Try Again.</a></h2></div>");
    }
}

function createConnection()
{
    $servername = "localhost";
    $username = "siocnarff";
    $serverPassword = "varkedansniemooi";
    $db = "u19138182_cos216";
    // Create connection
    return new mysqli($servername, $username, $serverPassword, $db);
}

function userExists($conn, $email)
{
    $query = "select IF(exists(select * from User where Email = '$email'), 'TRUE', 'FALSE');";
    return $conn->query($query)->fetch_all()[0][0] == 'TRUE';
}

function setUserInDB($conn, $name, $surname, $email, $password, $apiKey)
{
    $salt = generateRandomKey();
    $pwdHashed = hash_hmac("sha256", $password . $salt, getPepper(), false);
    $user = "insert into User (Name, Surname, Email, Password, Salt, APIKey) values ('$name', '$surname', '$email', '$pwdHashed', '$salt', '$apiKey');";
    return $conn->query($user);
}

function generateRandomKey()
{
    srand(microtime(true));
    $s = str_shuffle('ABCDEFGHIJKLMNOPabcdefghijklmnop1234567890!@#$%^&*()``?');
    return hash("sha256", getKeyPepper() . (rand(0, 1000000000000000) . microtime() . $s));
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

?>
</body>
</html>