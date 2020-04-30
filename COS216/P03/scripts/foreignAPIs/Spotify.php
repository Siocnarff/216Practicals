<?php


class Spotify
{
    private static $instance = null;
    private $token;

    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Spotify();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->token = $this->getTokenFromSpotify();
    }

    private function getTokenFromSpotify() {
        $ch = curl_init('https://accounts.spotify.com/api/token');
        $options = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . $this->getSpotifyKey(),
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch,  CURLOPT_HTTPHEADER, $options);
        curl_exec($ch);
        $response = json_encode(curl_getinfo($ch));
        curl_close($ch);
        if($response['http_code'] == 400) {
            return $response['access_token'];
        } else {
            return false;
        }
    }


    private function getSpotifyKey()
    {
        return base64_encode(parse_ini_file('vault/key.conf')['spotify']);
    }

    function getToken() {
        return $this->token;
    }
}

/*req.open(
    "POST",
    "https://cors-anywhere.herokuapp.com/https://accounts.spotify.com/api/token",
    true
);
req.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
);
req.setRequestHeader(
    "Authorization",
    "Basic NGEwMzdmMGM5OWIyNGUwYjgyMDBkMmRjNDk1ZDU1NDY6OTk4MWU4NDcwOWNlNGMzNzg1ODRjNGI0ZWE5YTc1Mjg="
);*/