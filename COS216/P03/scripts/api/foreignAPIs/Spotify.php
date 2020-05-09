<?php


class Spotify
{
    private $token;

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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch,  CURLOPT_HTTPHEADER, $options);
        //curl_setopt($ch, CURLOPT_PROXY, "phugeet.cs.up.ac.za:3128");
        $data = json_decode(curl_exec($ch), true);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($responseCode == 200) {
            return $data['access_token'];
        } else {
            return false;
        }
    }

    private function getSpotifyKey()
    {
        return base64_encode(parse_ini_file('COS216/vault/key.conf')['spotify']);
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