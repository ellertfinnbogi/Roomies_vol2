<?php 
require_once("../classes/Login.php");
$sess = new Login();
//$sess->function __construct();

if($_SESSION['user_login_status'] == 1)
{
	echo 'great success';
}
else
{
	header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');  
}




?>



