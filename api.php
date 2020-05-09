<?php

require_once "COS216/P03/scripts/database/Database.php";
require_once "COS216/P03/scripts/api/API.php";

$api = API::getInstance(Database::getInstance());
echo $api->handleRequest($_POST);