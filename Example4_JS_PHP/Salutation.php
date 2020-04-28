<?php
    session_start();
    function setSalutations() {
        // Pretend we retrieved the saluation data from database
        $salutation = array("Title","Mr", "Mrs", "Dr", "Prof", "Ms");
        $_SESSION["salutations"] = $salutation;
    }


    function generateSelect($name, $id, $sid) {

        $salutation = $_SESSION[$sid];
        echo "<select name='".$name."' id='".$id."'>";
        foreach($salutation as $value) {
            echo "<option>".$value."</option>";
        }
        echo "</select>";
    }
?>

