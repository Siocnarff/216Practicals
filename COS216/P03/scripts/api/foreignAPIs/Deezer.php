<?php


class Deezer
{

    function search($q) {
        $ch = curl_init("https://api.deezer.com/search?q=$q");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_PROXY, "phugeet.cs.up.ac.za:3128");
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response['data'];
    }

    function track($id) {
        $ch = curl_init("https://api.deezer.com/track/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_PROXY, "phugeet.cs.up.ac.za:3128");
        $track = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $this->standardizeTrack($track);
    }

    private function standardizeTrack($track) {
        return [
            'title' => $track['title'],
            'artwork' => $track['album']['cover'],
            'artist' => $track['artist']['name'],
            'album' => $track['album']['title'],
            'duration' => $track['duration'],
            'billRank' => $track['rank'],
            'release' => $track['release_date'],
            'preview' => $track['preview']
        ];
    }
}

//"return": ["title", "artwork", "artist", "album", "duration", "billRank", "release", "preview"]