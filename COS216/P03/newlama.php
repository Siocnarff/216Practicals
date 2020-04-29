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
include_once("header.php");
//echo("Appropriate Cost Found " + findAppropriateCost());

include_once("scripts/config/Database.php");
include_once("scripts/validation/validate-signup.php");

$conn = (new Database)->createConnection();
if ($conn->connect_error) {
    echo("<div><h3 class='center'>Could not connect to the database, please try again later.</h3></div>");
} else {
    addUser($conn);
}
include_once("footerDeezer.php");

function addUser($conn)
{
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];


    if (validEmail($email) and validName($name) and validName($surname) and validPassword($password)) {
        if (userExists($conn, $email)) {
            echo("<div class='center key_info'><p>User with email $email already exists. <a href='signup.php'>Try Again.</a></p></div>");
            return;
        }
        $apiKey = generateRandomKey();
        if (setUserInDB($conn, $name, $surname, $email, $password, $apiKey)) {
            echo("<div class='center key_info'><h2>Welcome to BadLama, buddy.</h2><p>Your API key is $apiKey</p></div>");
        } else {
            echo("<div><h2 class='center'>Could Not Register You. <a href='signup.php'>Try Again.</a></h2></div>");
        }
    } else {
        echo("<div><h2 class='center'>User Info Is Not Valid. <a href='signup.php'>Try Again.</a></h2></div>");
    }
}

?>

</body>
</html>
