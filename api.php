<?php

include_once "COS216/P03/scripts/database/Database.php";

$db = Database::getInstance();
$request = json_decode(file_get_contents('php://input'), true);

if($db->validSession($request['key'])) {
    echo("This is a valid user");
} else {
    echo("Error: APIKey or user email address not valid");
}
