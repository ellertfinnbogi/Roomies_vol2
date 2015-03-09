<?php
require_once("../classes/Login.php");
require_once("../config/db.php");
require_once("../classes/user_functions.php");
$sess = new Login();
$conn = $sess->getDbConnection();




$null_check = "SELECT room from users where user_name = '". $_SESSION['user_name'] . "';";
$null_check_result = $conn->query($null_check);
$res = $null_check_result->fetch_assoc();
$_SESSION['room'] = $res['room'];
echo "<meta charset='utf-8' >";
echo "<link rel='stylesheet' href='../css/look.css'>";
if($_SESSION['user_login_status'] == 1 && $res['room'] != null)
{

	
	echo "<h2>VERKEFNASKRÁ fyrir herbergi: ".$_SESSION['room']." </h2>" ;
	?>
	<!-- ***Hérna er formið fyrir að skrá inní todo  *** -->
	<script src="../js/display_functions.js"></script>
	<div class="makejob">
	   <a href="#" onclick="toggle_visibility('list1');">
      <p>Skrá verk</p>
      </a>
	<div id="list1" class="container">
		
	         <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="savejob">
	         <ul>
	         <li>
	            <label for="todo">Todo </label>
	             <input id="todo_list" type="text" name="todo_list" required>
	             </li>
	             <li>
	             
	             <label for="personresponsible">Hver á að gera verk </label>
	             <?php
	             echo "<select name='personresponsible'>";
					echo '<option value="">'.'--- Veldu hérna ---'.'</option>';
					$query = "SELECT user_name FROM users where room = '". $_SESSION['room'] ."';";
					
					$results = $conn->query($query);

					if($results->num_rows > 0)
					{
						while($row = $results->fetch_assoc())
						{
							echo $row['user_name'];
							echo "<option>". $row['user_name']
							 .'</option>';	
						}
					}
					echo '</select>';

	             ?>
	             </li>
	             <li>
	             <label for="date">Dagsetning</label>
	             <input id="date" type="date" name="date" required />
	             </li>
	             
	             <input type="submit"  name="savejob" value="Skrá verk" />
	             </ul>
	         </form>
        </div>
	</div>
	<?php


	$sql = "SELECT user_name,todo,user_resp,do_date from todo where room = '" . $_SESSION['room'] ."';";
	
	$result = $conn->query($sql);
	

	echo 	"<table><tr><th>Hver skáir</th><th id='todo'>Todo</th><th>Hver á verk</th><th>Klára fyrir</th><th>Verk klárað?</th></tr>";
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			echo "<tr><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']. "</td> <td><input type='checkbox'></td></tr>";
			
		}

		echo "</table>";
	}
	else{echo "</table>";}

		//sér um að skrá í gagnagrunn ef klikkað er á Skrá verk
		$user_function = new UserFunctions();
        if(isset($_POST["savejob"])) {
            $user_function->savejob();
        }

// hér búum við til takka sem getur skráð okkur úr rúminu.
$form = <<<EOT
<form action="" method ="POST">
<br /><input type="submit" value="Hætta í room-i" name="quit_room" />
</form>
EOT;

echo $form;
// ef ýtt er á takkan.

if(isset($_POST['quit_room'])){
	$sql = "UPDATE users  SET room = NULL WHERE user_name = '" . $_SESSION['user_name'] ."'; ";                
	$result= $conn->query($sql);
	// ef skipunin virkaði þá refreshum við síðuna.
	if($result){
			printf("<script>location.href='logged_in.php'</script>");
	}

	//hér ætla ég að reyna bæta við pop-up glugga til að athuga hvort þú sért viss um að vilja hætta í room-i....

	}


}
else if($_SESSION['user_login_status'] == 1 && $res['room'] == null)
{
	
// formið join og create room.
$form = <<<EOT
<form action="" method ="POST">
Þú ert ekki skráð/ur í neitt Room. Þú getur tengst Room-i eða búið til nýtt Room. <br />
<input type = "text" name="room" />&emsp;<input type="submit" value="tengjast room numeri" name="join_room" /> <br />

<br /><input type="submit" value="Búa til nýtt room" name="create_room" />

</form>
EOT;

echo $form;
	// ef klikkað er að create room þá generateast 12 stafa random room number.
	if(isset($_POST['create_room'])){
		$random_room = substr(md5(rand()), 0, 12);
		$sql = "UPDATE users  SET room = '$random_room' WHERE user_name = '" . $_SESSION['user_name'] ."'; ";
                    
		$result= $conn->query($sql);
		// ef skipunin virkaði þá refreshum við síðuna.
		if ($result) {
					printf("<script>location.href='logged_in.php'</script>");

		}

		//pretun út error ef það eru einhverjir.
		if (!$result) {
    		$message  = 'Invalid query: ' . mysql_error() . "\n";
    		$message .= 'Whole query: ' . $query;
    		die($message);
		}
	}
	else if(isset($_POST['join_room'])){
		$room_name = $conn->real_escape_string(strip_tags($_POST['room'], ENT_QUOTES));

		$room_exists_check = "SELECT room from users where room = '$room_name'";
		$result = $conn->query($room_exists_check);

		if($result->num_rows > 0){
			$sql = "UPDATE users  SET room = '$room_name' WHERE user_name = '" . $_SESSION['user_name'] ."'; ";       
			$result= $conn->query($sql);
			// ef skipunin virkaði þá refreshum við síðuna.
			if ($result) {
					 printf("<script>location.href='logged_in.php'</script>");

		}

		//pretun út error ef það eru einhverjir.
			if (!$result) {
    			$message  = 'Invalid query: ' . mysql_error() . "\n";
    			$message .= 'Whole query: ' . $query;
    			die($message);
			}
		}
		else{
			echo 'Þetta room er ekki til.';
		}
	}

}
else 
{
	die('Þú hefur ekki aðgang að þessari síðu');
	printf("<script>location.href='../index.php'</script>");
}
?>

<a href="../index.php?logout">Logout</a>


