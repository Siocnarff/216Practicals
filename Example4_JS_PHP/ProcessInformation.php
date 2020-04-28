<?php
    
    /* Construct the message to be emailed
       Note, PHP uses the name assigned to the XHTML element while JavaScript the ID
     */
    $messageToEmail =
      "From: ".$_POST['salutation']." "
              .$_POST['firstName']." "
              .$_POST['surname']."\r\n".
      "eMail address: ".$_POST['email']."\r\n".
      "Phone number: ".$_POST['phone']."\r\n\r\n".
      $_POST['message']."\r\n\r\n";
    
    $comm = $_POST['comm'];
    
    $communicationMeans = "Your selected communication method for promotions is: ";
    if (count($comm) == 0) {
        $communicationMeans .= "None selected";
    } else {
        foreach ($comm as $value)
          $communicationMeans .= $value." ";
    }
    
    $messageToEmail .= $communicationMeans."\r\n";

    
    /* Email the form to the company. This will only work if you have an email server set up
     */
    $headerForEmail = "From: ".$_POST['email'];
    mail("lmarshall@cs.up.ac.za","Feedback message",$messageToEmail,$headerForEmail);
    
    /* Show the message on the web page
     */
    $display = str_replace("\r\n","<br />\r\n",$messageToEmail);
    $display =
    "<html><head><title>Your message</title></head><body>".
    $display.
    "</body></html>";
    echo $display;
    
    /* Log the message in a file - It would be best to write this to a database rather than a file
     */
    date_default_timezone_set('Africa/Johannesburg');
    $fileVar = fopen("feedback.txt","a") or die("Error: Could not open the log file");
    fwrite($fileVar,"\n--------------[New record]--------------\n") or die("Error: Could not write to the log file");
    fwrite($fileVar,"Data received: ".date("jS \of F, Y \a\\t H:i:s\n")) or die("Error: Could not write to the log file");
    fwrite($fileVar,$messageToEmail) or die("Error: Could not write to the log file");
    fclose($fileVar);
    
    
?>
