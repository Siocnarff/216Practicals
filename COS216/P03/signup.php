<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="P03 for COS216 at UP 2020">
    <meta name="author" content="Josua Botha (u19138182)">
    <meta name="keywords" content="music,featured,UP,COS216,logopond">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/validation.js"></script>
    <title>BadLama Music</title>
</head>
<body>
<?php
include_once("header.php");
?>
<div class="inner_body">
    <div class="register_form center">
        <form
                name="register"
                id="register"
                action="scripts/register.php"
                onsubmit="return validate()"
                method="post"
                accept-charset="UTF-8"
        >
            <label for="name">Name</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Surname</label><br>
            <input type="text" id="surname" name="surname" required><br>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password</label><br>
            <input id="password" minlength="9" name="password" type="password" required><br>
        </form>
        <button id="submit" class="button" type="submit" form="register">Submit</button>
    </div>
</div>

<?php
include_once("footer.php");
?>
</body>
