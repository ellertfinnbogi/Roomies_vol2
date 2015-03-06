<?php 
require_once("../classes/Login.php");
require_once("../config/db.php");



$sess = new Login();

$conn = $sess->getDbConnection();
$null_check = "SELECT room from users where user_name = '". $_SESSION['user_name'] . "';";
$null_check_result = $conn->query($null_check);
$res = $null_check_result->fetch_assoc();
echo $res['room'];

//$sess->function __construct();
echo "<meta charset='utf-8' >";
echo "<link rel='stylesheet' href='../css/look.css'>";
if($_SESSION['user_login_status'] == 1 && $res['room'] != null)
{

	
	echo "<h2> Hérna eru verkin þín </h2>";
	$sql = "SELECT todo,user_name from todo where user_name = '" . $_SESSION['user_name'] ."';";
	//$sql = "SELECT todo FROM todo where user_name =". $_SESSION['user_name'] . ";";
	
	$result = $conn->query($sql);

	echo 	"<table><tr><th>Verkefni</th><th>Hver á verk</th><th>Klára fyrir</th></tr>";
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			echo "<tr><td>". $row['todo'] . "</td><td>". $row['user_name']. "</td></tr>";
			
		}

		echo "</table>";
	}




}
else
{
	//header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');  
    echo "<a href='../index.php?logout'>Logout</a>";
}



?>

<a href="../index.php?logout">Logout</a>


