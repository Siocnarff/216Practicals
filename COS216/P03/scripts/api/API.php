<?php

require_once "foreignAPIs/Deezer.php";
require_once "foreignAPIs/Spotify.php";

class API
{
    private static $instance = null;
    private $deezer;
    private $spotify;

    private function __construct()
    {
        $this->deezer = new Deezer();
        $this->spotify = new Deezer();
    }

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new API();
        }
        return self::$instance;
    }

    function handleRequest($request) {
        if($request['deezer']) {
            $tracks = $this->deezer->searchFullTracks($request['title']);
        } else {
            $tracks = $this->spotify->search($request['title']);
        }
        $data = [];
        for($i = 0; $i < count($tracks); $i++) {
            if($request['return'] == '*') {
                $data[$i] = [$tracks[$i]];
            } else {
                $partialTrack = [];
                for($k = 0; $k < count($request['return']); $k++) {
                    if($this->validField($request['return'][$k])) {
                        $partialTrack += [$request['return'][$k] => $tracks[$i][$request['return'][$k]]];
                    } else {
                        http_response_code(400);
                        return "your return fields are malformed";
                    }
                }
                $data[$i] = $partialTrack;
            }
        }
        return $data;
    }

    private function validField($field)
    {
        $fields = ['title', 'artwork', 'artist', 'album', 'duration', 'billRank', 'release', 'preview'];
        for($i = 0; $i < count($fields); $i++) {
            if($fields[$i] === $field) {
                return true;
            }
        }
        return false;
    }
}