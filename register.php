<?php

/**
 * PHP login script / Vid reynum ad nota audveldan hreinan koda.
 * Getum notad www.php-login.net til frekari adstodar vid log in.
 *
 * Notkun a PHP Session og password-hashing kemur fram her sem er naudsynlegt fyrir kerfid.
 *
 * @author Panique hofundur
 * @link https://github.com/panique/php-login-minimal/ github kennsla
 * @license http://opensource.org/licenses/MIT MIT License - leyfid 
 */

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

// include configid fyrir breyturnar i tengingunni vid database
require_once("config/db.php");

// hlada the registration class
require_once("classes/Registration.php");

// buum til registration object. tegar tad er til ser tad um skraninguna sjalfvirkt
// svo tessi eina lina ser um allt registartion ferlid
$registration = new Registration();

// synir register view, med registration form, skilabod og villuskilabod
include("views/register.php");
