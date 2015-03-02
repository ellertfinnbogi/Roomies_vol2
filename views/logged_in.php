<?php/* 
require_once("../classes/Login.php");
// include the configs / constants for the database connection
require_once("../config/db.php");

// load the login class



$login = new Login();

// ... spurt hvort notandi se loggadur inn:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   // include("views/logged_in.php");
    //header("Location:views/logged_in.php");
    echo 'Everything works now!';

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    include("header.html");
}

//Hey, <?php echo $_SESSION['user_name']; ?>

<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="../index.php?logout">Logout</a>*/

Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.
Try to close this browser tab and open it again. Still logged in! ;)
