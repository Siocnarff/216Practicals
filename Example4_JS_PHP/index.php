<?php
    session_start();  // Added
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script type="text/javascript" src="Validation.js">
  </script>
  <title>Feedback form</title>
</head>
<body>
  <form id="personalInfo" name="personalInfo"  onsubmit="return validateForm()" action="ProcessInformation.php" method="post">
    <fieldset>
        <legend>Enter your information</legend>
        Title :
        <?php
            include "Salutation.php"; //Added
            setSalutations(); //Added
            generateSelect("salutation","id_salutation",'salutations');  // Added
        ?>
        <br />
        
        First Name : <input type="text" name="firstName" id="id_firstName"><br />
        Surname : <input type="text" name="surname" id="id_lastName"> <br />
        Email : <input type="text" name="email" id="id_email"> <br />
        Phone : <input type="text" name="phone" id="id_phone"> <br />
    </fieldset>
    <fieldset>
        <legend>Your message</legend>
        <textarea id="id_comments" name="message" rows=10 cols="30"></textarea>
    </fieldset>
    <fieldset>
        <input type="submit" value="Send">
        <input type="reset" value="Reset">
    </fieldset>
    <fieldset>
		<legend>Advertising request:</legend>
		Please inform us by which means you would prefer to receive promotions.<br />
		<input type="checkbox" name="comm[]" value="SnailMail"> Postal service
		<input type="checkbox" name="comm[]" value="Email">Email
		<input type="checkbox" name="comm[]" value="Phone">Telephone
	</fieldset>
  </form>
</body>
</html>