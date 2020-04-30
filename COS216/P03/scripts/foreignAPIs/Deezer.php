<?php


class Deezer
{
    private static $instance = null;
    private $key;

    static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Deezer();
        }
        return self::$instance;
    }

    private function __construct()
    {

    }
}