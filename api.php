<?php

include_once "COS216/P03/scripts/database/Database.php";
include_once "COS216/P03/scripts/foreignAPIs/Spotify.php";

$db = Database::getInstance();
$request = json_decode(file_get_contents('php://input'), true);

//curl_setopt($ch, CURLOPT_PROXY, "phugeet.cs.up.ac.za:3128");

if($db->validSession($request['key'])) {
    echo("This is a valid user");
    $spotify = Spotify::getInstance();
    $key = $spotify->getToken();
    if($key) {
        echo($key);
    }
} else {
    echo("Error: APIKey or user email address not valid");
}
