<?php

function hashPassword($salt, $password,  $pepper, $cost = 10) {
    $pwdPeppered = hash_hmac("sha256",  $password, $pepper, false);
    return password_hash($pwdPeppered,PASSWORD_BCRYPT, ["salt" => $salt, "cost" => $cost]);
}

function generateRandomKey()
{
    //return bin2hex(mcrypt_create_iv(32, MCRYPT_RAND));
    $crypto_strong = true;
    return bin2hex(openssl_random_pseudo_bytes(32, $crypto_strong));
}

function getPepper($file)
{
    $configVars = parse_ini_file($file);
    return $configVars["pepper"];
}