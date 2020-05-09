<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P01 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,trending,hottest,hits,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/trending.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/script.js"></script>
    <title>BadLama Music</title>
</head>
<body onload="populateTrending(15)">
<?php
include_once("components/header.php");
?>
<div class="inner_body">
    <div id="album_blocks" class="album_blocks_three_wide"></div>
    <div class="right_column">
        <div class="page_tools">
            <div class="search">
                <label for="searchTrending"></label>
                <input id="searchTrending" type="search" placeholder="Search" value="">
                <button onclick="searchTrending()">
                    <img alt="Search" src="images/icons/search-white-24px.svg">
                </button>
            </div>
            <div class="filters">
                <p class="small_text grey">Search Depth</p>
                <label for="search_depth"></label>
                <select class="filter" id="search_depth" name="date">
                    <option value="1">1</option>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
        </div>
    </div>
</div>
<?php
include_once("components/footerDeezer.php");
?>
</body>
</html>