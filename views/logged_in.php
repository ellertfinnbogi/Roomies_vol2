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

	
	echo "<h2>VERKEFNASKRÁ</h2>";
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
	//$sql = "SELECT todo FROM todo where user_name =". $_SESSION['user_name'] . ";";
	
	$result = $conn->query($sql);
	

	echo 	"<table><tr><th>Hver skáir</th><th>Todo</th><th>Hver á verk</th><th>Klára fyrir</th></tr>";
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			echo "<tr><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']. "</td></tr>";
			
		}

		echo "</table>";
	}

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
	
		$user_function = new UserFunctions();
        if(isset($_POST["savejob"])) {
            $user_function->savejob();
        }




}
else if($_SESSION['user_login_status'] == 1 && $res['room'] == null)
{
	echo 'trausta magic';
}
else 
{
	die('Run you fool!');
}
?>

<a href="../index.php?logout">Logout</a>


