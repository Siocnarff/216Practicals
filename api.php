<?php

include_once "COS216/P03/scripts/database/Database.php";
include_once "COS216/P03/scripts/validation/RequestValidator.php";

$db = Database::getInstance();
$validator = new RequestValidator($db->connection());
$user_email = $_POST['user'];
$key = $_POST['key'];

if($validator->validate($user_email, $key)) {
    echo("This is a valid user");
} else {
    echo("Error: APIKey or user email address not valid");
}
