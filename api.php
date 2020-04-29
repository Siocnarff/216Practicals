<?php

include_once "COS216/P03/scripts/config/Database.php";
include_once "COS216/P03/scripts/validation/KeyValidator.php";

$key = $_POST['key'];
$type = $_POST['type'];
$return = $_POST['return'];
$user_email = $_POST['user_email'];

echo("$key -- $type -- $return");