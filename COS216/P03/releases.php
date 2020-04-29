<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P03 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,new,releases,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/releases.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/script.js"></script>
    <title>BadLama Music</title>
</head>
<body onload="populateAlbums(7)">
<?php
include_once("components/header.php");
?>
<div class="inner_body">
    <div class="album_blocks" id="album_blocks"></div>
</div>
<?php
include_once("components/footerDeezer.php");
?>
</body>
</html>