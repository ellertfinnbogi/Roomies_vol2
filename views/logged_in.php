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




<<<<<<< HEAD
?>
=======
// ... spurt hvort notandi se loggadur inn:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   // include("views/logged_in.php");
    //header("Location:views/logged_in.php");
    echo 'Everything works now!';
>>>>>>> 5f11c09be418af0d151e69204e22907b3218942a



