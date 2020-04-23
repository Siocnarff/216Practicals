<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P03 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,tour,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="   text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/calendar.css">
    <script type="text/javascript" src="js/script.js"></script>
    <title>BadLama Music</title>
</head>
<body onload="storeSpotifyPlaylist()">
<?php
include_once("header.php");
?>
<div class="inner_body">
    <div class="calendar" id="calendar">
        <div class="calendar_nav">
            <h2 id="full_date">Today</h2>
            <button class="button" onclick="popPrevMonth()">&lt;</button>
            <button class="button" onclick="popNextMonth()">&gt;</button>
            <button class="button float_right" onclick="gotToToday()">Today</button>
        </div>
        <div id="calendar_main"></div>
    </div>
</div>
<?php
include_once("footerSpotify.php");
?>
</body>
</html>