<?php


// Skodum her lagmarks PHP utgafu

 if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // Ef vid stydjumst vid PHP 5.3 eda 5.4 verdum vid ad includa password_api_compatibility_library.php
    // Tilgangur tessa safns er ad baeta PHP5.5 password hashing fyrir function i eldri utgafum af PHP.
require_once("libraries/password_compatibility_library.php");
}
//
//require_once("views/header.html");

// include config fyrir breyturnar i tengingunni vid database
require_once("config/db.php");

// hlada the registration class
require_once("classes/Registration.php");

// buum til registration object. tegar tad er til ser tad um skraninguna sjalfvirkt
// svo tessi eina lina ser um allt registartion ferlid
$registration = new Registration();

// synir register view, med registration form, skilabod og villuskilabod
//include("views/register.php");

//Mogulegar villur
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
            printf("<script>location.href='index.php'</script>");
        }
    }
}
?>


<!-- <a href="index.php">Tilbaka á innskráningarsíðu</a> -->
