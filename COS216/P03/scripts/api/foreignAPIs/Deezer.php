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

    function searchFullTracks($q) {
        $tracks = $this->search($q);
        $fullTracks = [];
        for($i = 0; $i < count($tracks); $i++) {
            $fullTracks[$i] = $this->track($tracks[$i]['id']);
        }
        return $fullTracks;
    }

    private function standardizeTrack($track) {
        return [
            'title' => $track['title'],
            'artwork' => $track['album']['cover'],
            'artist' => $track['artist']['name'],
            'album' => $track['album']['title'],
            'duration' => $track['duration'],
            'billRank' => $track['rank'],
            'release' => $this->standardizeDate($track['release_date']),
            'preview' => $track['preview']
        ];
    }

    private function standardizeDate($date) {
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        return $this->dropLeadingZeros($day) . " " . $this->getMonthName((int)$month) . " " . $year;
    }

    private function getMonthName($index) {
        $names = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
        return $names[$index];
    }

    private function dropLeadingZeros($s) {
        if($s[0] == '0') {
            return substr($s, 1);
        } else {
            return $s;
        }
    }
}

//"return": ["title", "artwork", "artist", "album", "duration", "billRank", "release", "preview"]