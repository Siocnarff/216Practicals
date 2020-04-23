<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P03 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,ranking,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/top.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/script.js"></script>
    <title>BadLama Music</title>
</head>
<body onload="populateTopTracks(5)">
<?php
include_once("header.php");
?>
<div class="inner_body">
    <div id="ranked_songs" class="ranked_songs">
    </div>
</div>
<?php
include_once("footerDeezer.php");
?>
</body>
</html>