<?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
/**
 * Configuration for: Database Connection
 */


$url = parse_url(getenv("CLEARDB_DATABASE_URL"));



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
/*$sql = "SELECT user_name, user_email
        FROM heroku_fe4c3f7fd3aac4d.users
        where user_name like 'ellertfinnbogi'";
if($result = $conn->query($sql))
{
	printf($result->num_rows);
}

printf($result)
?> 


