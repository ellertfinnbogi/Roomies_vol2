<?php

/**
 * Configuration for: Database Connection
 *
 * For more information about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */
//define("DB_HOST", "127.0.0.1");
/*define("DB_HOST", "sql3.freemysqlhosting.net:3306");
define("DB_NAME", "sql367320");
define("DB_USER", "sql367320");
define("DB_PASS", "eN1*wP5%");*/


$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["b5ff330ecc5d82"];
$password = $url["b4f10d5b"];
$db = substr($url["path"], 1);

//$conn = new mysqli($server, $username, $password, $db);
?>
