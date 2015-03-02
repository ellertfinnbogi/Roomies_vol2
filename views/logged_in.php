

Hey, <?php echo $_SESSION['user_name']; 
require_once("classes/Login.php");

$temp;
$temp->isUserLoggedIn();

if($temp)
{
	echo 'successs!!';

}
else
{
	echo 'failed';
}


?>. You are logged in.

Try to close this browser tab and open it again. Still logged in! ;)
