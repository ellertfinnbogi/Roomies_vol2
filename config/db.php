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


//CLEARDB_DATABASE_URL: mysql://b5ff330ecc5d82:b4f10d5b@us-cdbr-iron-east-01.cleardb.net/
// heroku_fe4c3f7fd3aac4d?reconnect=true


$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

/*$server = $url["us-cdbr-iron-east-01.cleardb.net"];
$username = $url["b5ff330ecc5d82"];
$password = $url["b4f10d5b"];
$db = substr($url["heroku_fe4c3f7fd3aac4d"], 1);*/

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);


$conn = new mysqli($server, $username, $password, $db);
if ($conn->ping()) {
    printf ("Our connection is ok!\n");
}
else {
    printf ("Error: %s\n", $conn->error);
}
$sql = "SELECT user_name, user_email
        FROM users
        where user_name like 'ellertfinnbogi'";
$dave = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_assoc(($dave))
{
	foreach($row as $cname => $cvalue)
	{
		print "$cname: $cvalue\t":
	}
	print "\r\n";
}

                     ?> 

/*$conn = new mysqli($server, $username, $password, $db);

if ($conn->ping()) {
    printf ("Our connection is ok!\n");
}
else {
    printf ("Error: %s\n", $conn->error);
}*/

