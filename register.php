<?php


// Skodum her lagmarks PHP utgafu

//virðist vera vesen að skrá sig inn á gamla notendur eftir að ég hef commentað þetta út. Hash aðferðin örugglega eh öðurvísi.

/*if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else*/ if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // Ef vid stydjumst vid PHP 5.3 eda 5.4 verdum vid ad includa password_api_compatibility_library.php
    // Tilgangur tessa safns er ad baeta PHP5.5 password hashing fyrir function i eldri utgafum af PHP
    //ekki í notkun eins og er.
require_once("libraries/password_compatibility_library.php");
}
//require_once("views/header.html");

// include configid fyrir breyturnar i tengingunni vid database
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
        }
    }
}
?>

     <meta charset="utf-8" >
     <link rel="stylesheet" href="css/look.css">
     <link rel='shortcut icon' type='image/x-icon' href='img/roomies.ico' />
<form method="post" action="register.php" name="registerform">

    
    <label for="login_input_username">Notendanafn (aðeins stafir og tölusaftir, 2 til 64 slög)</label>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
    <br />

    
    <label for="login_input_email">Netfang notenda</label>
    <input id="login_input_email" class="login_input" type="email" name="user_email" required />
    <br />
    <label for="login_input_password_new">Lykilorð (lágmark 6 stafir)</label>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
    <br />
    <label for="login_input_password_repeat">Endurtaka lykilorð</label>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    <br />
    <input type="submit"  name="register" value="Búa til aðgang" />

</form>


<a href="index.php">Tilbaka á innskráningarsíðu</a>
