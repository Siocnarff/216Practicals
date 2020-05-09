<?php

require_once "foreignAPIs/Deezer.php";
require_once "foreignAPIs/Spotify.php";

class API
{
    private static $instance = null;
    private $deezer;
    private $spotify;
    private $db;

    private function __construct($database)
    {
        $this->deezer = new Deezer();
        $this->spotify = new Deezer();
        $this->db = $database;
    }

    public static function getInstance($database)
    {
        if (self::$instance == null) {
            self::$instance = new API($database);
        }
        return self::$instance;
    }

    function handleRequest($request) {
        if($this->db->validSession($request['key'])) {
            return json_encode(
                $this->getForeignData($_POST)
            );
        } else {
            http_response_code(400);
            return json_encode(
                ["timestamp" => microtime(true), "status" => "error", "data" => "invalid key"]
            );
        }
    }

    private function getForeignData($request)
    {
        if (in_array('genre', $request['return'])) {
            return [
                "timestamp" => microtime(true),
                "status" => "error",
                "data" => "spotify is not available"
            ];
        } else {
            $tracks = $this->deezer->searchFullTracks($request['title']);
        }
        $data = [];
        for ($i = 0; $i < count($tracks); $i++) {
            if ($request['return'][0] == '*') {
                $data[$i] = [$tracks[$i]];
            } else {
                $partialTrack = [];
                for ($k = 0; $k < count($request['return']); $k++) {
                    if ($this->validField($request['return'][$k])) {
                        $partialTrack += [$request['return'][$k] => $tracks[$i][$request['return'][$k]]];
                    } else {
                        http_response_code(400);
                        return [
                            "timestamp" => microtime(true),
                            "status" => "error",
                            "data" => "your return parameters are malformed"
                        ];
                    }
                }
                $data[$i] = $partialTrack;
            }
        }
        return ["timestamp" => microtime(true), "status" => "success", "data" => $data];
    }

    private function validField($field)
    {
        $fields = [
            'title', 'artwork', 'artist', 'album', 'duration', 'billRank', 'release', 'preview', 'rating', 'genre'
        ];
        for ($i = 0; $i < count($fields); $i++) {
            if ($fields[$i] === $field) {
                return true;
            }
        }
        return false;
    }
}