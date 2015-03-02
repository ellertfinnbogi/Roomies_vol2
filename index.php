<?php

// Skodum her lagmarks PHP utgafu
if (version_compare(PHP_VERSION, '5.3.3', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // Ef vid stydjumst vid PHP 5.3 eda 5.4 verdum vid ad includa password_api_compatibility_library.php
    // Tilgangur tessa safns er ad baeta PHP5.5 password hashing fyrir function i eldri utgafum af PHP
    require_once("libraries/password_compatibility_library.php");
}

// include configid fyrir breyturnar i tengingunni vid database
require_once("config/db.php");

// Hlada load i login class
require_once("classes/Login.php");

// buum til login object. Tegar tetta object er buid til ser tad sjalft um login/logout virknina
// svo tessi eina lina ser um allt login processid. 
$login = new Login();

// ... athuga hvort tu sert loggadur inn her:
if ($login->isUserLoggedIn() == true) {
    // notandinn er loggadur inn, tu getur gert tad sem tu vilt her.
    // til ad athuga rett getur madur einfaldlega synt "tu ert loggadur inn" view
   // include("views/logged_in.php");
    header("Location:views/logged_in.php");

} else {
    // notandinn er ekki loggadur inn, tu getur gert tad sem tu vilt her
    // til ad athuga getur tu skrifad her "tu ert ekki loggadur inn" view.
    include("views/header.html");
}
