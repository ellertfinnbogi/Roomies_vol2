<?php 
require_once("../classes/Login.php");
$sess = new Login();
//$sess->function __construct();
echo "<link rel='stylesheet' href='../css/look.css'>";
if($_SESSION['user_login_status'] == 1)
{
	echo "great success <br \>";

	echo "<table>";
		echo "<td>".$_SESSION['user_name']."<tr>";
	
echo "</table>";

}
else
{
	header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');  
}



?>

<a href="../index.php?logout">Logout</a>


