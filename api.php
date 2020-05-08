<?php

include_once "COS216/P03/scripts/database/Database.php";
include_once "COS216/P03/scripts/api/API.php";

$db = Database::getInstance();
$request = json_decode(file_get_contents('php://input'), true);

if($db->validSession($request['key'])) {
    $api = API::getInstance();
    echo json_encode($api->handleRequest($request));
} else {
    echo(json_encode("{error: invalid key}"));
}