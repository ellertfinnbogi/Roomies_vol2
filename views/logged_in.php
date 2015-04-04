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
//echo "<link rel='stylesheet' href='../css/look.css'>";
if($_SESSION['user_login_status'] == 1 && $res['room'] != null)
{
	
	?>
	<script src="../js/display_functions.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/look.css">
<!-- Finally the bootbar CSS and JS -->
<script src="../js/bootbar.js"></script>

<!-- ***Nota seinna fyrir notification**** -->

<script>function nameit() {
	$.bootbar.info("Í dag er skuldadagur,mundu að greiða!! Smelltu á &times; til að loka");
	$('.alert-messages').show();

}; 
</script> 


</head>
<body>
<div class="alert-messages">
</div>
<div class="container">
<div class="row" id="header">
	<div class="col-md-8">
	<?php

	

		echo "<h2 id='change'>Velkomin/n: ".ucfirst($_SESSION['user_name'])."&emsp;&emsp;&emsp;&emsp;&emsp; Herbergi: ".($_SESSION['room'])." </h2>" ;

	?>

	</div>
	<div class="col-md-4" id="logout">

	<a href="../index.php?logout">Logout</a>
	</div>

</div>

<div class="row">
	<div class="col-md-1" id="makejob">
		<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#todo_job" data-whatever="skra_verkefni">Skrá verkefni</button>
	</div>	
	<div class="col-md-1" id="makejob">
		<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#payment" data-whatever="skra_utjold">Skrá útgjöld</button>
	</div>

		<!-- Skrá verkefni -->
		<div class="modal fade" id="todo_job" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h2 id="modals" class="modal-title" id="exampleModalLabel">Settu inn upplýsingar fyrir verkefni<h2 id="modals">
			      </div>
			      <div class="modal-body">
			        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="savejob">

			            
			         <div class="form-group">
			         <label for="recipient-name" class="control-label">Verkefni</label><br>
			            <select name ="todo_list" for="recipient-name" class="control-label">
			            <option value="" type="text" class="form-control" name="todo_list" id="recipient-name">---Veldu---</option>			           
			            <option>Ryksuga</option>
			            <option>Skúra</option>
			            <option>Þrífa klósett</option>
			            <option>Þrífa eldhúsið</option>
			            <option>Þrífa stofu</option>
			            <option>Taka til í eldhúsi</option>
			            <option>Taka til í stofu</option>
			            <option>Annað</option>
			            </select>
			          </div>
			          <div class="form-group">
			            <label for="message-text" name="person_responsible" class="control-label">Ábyrgðarmaður</label><br>

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
	             </div>
	             <div class="form-group">
	             		<label for="date" class="control-label">Dagsetning</label>
			            <input type="date" class="form-control" name="date" id="recipient-name">
			          </div>
			        
			      </div>
			      <div class="modal-footer">
			        
			        <input type="submit"  name="savejob" value="Skrá verk" />
			      </div>
			      </form>
			    </div>
			  </div>
			  </div>
		<!-- Skrá upphæð -->
		<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		 <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h2 id="modals" class="modal-title" id="exampleModalLabel">Settu inn upphæð sem þú hefur lagt út</h2>
			      </div>
			      <div class="modal-body">
			        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="savepayment">

			          <div class="form-group">
			            <label for="recipient-name" class="control-label">Upphæð</label>
			            <input type="number" class="form-control" name="payment_amount" id="recipient-name">
			          </div>
	             <div class="form-group">
	             		<label for="date" class="control-label">Fyrir hverju</label>
			            <input type="text" class="form-control" name="payment" id="recipient-name">
			          </div>
			       
			      <div class="modal-footer">
			        
			        <input type="submit"  name="savepayment" value="Skrá verk" />
			      </div>
			      </form>
			    </div>
			    </div>
			    </div>
			    </div>

			


	      



	<!-- Large modal -->
	<div class="col-md-1" id="assignments">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Verkefnaskrá</button>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 id="modals" class="modal-title" id="greidsluskra">Verkefnaskrá</h2>
     



<!-- Verkefnaskrá -->
	<?php


	$sql = "SELECT id,user_name,todo,user_resp,do_date,done_bool from todo where room = '" . $_SESSION['room'] ."';";
	
	$result = $conn->query($sql);

	echo "<table class='table table-striped'><tr><th>Hver skáir</th><th id='todo'>Todo</th><th>Hver á verk</th><th>Klára fyrir</th></tr>";
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			
			
		
			


			 if($row['done_bool'] == 'X')
			 {
			 ?>
			 <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="setjobnotdone">
			 <?php
			 echo "<input type='hidden' name='todo_id' value='".$row['id']."'>";
			 	echo "<tr class='green'><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']. "</td><td><input type='submit'  name='setjobnotdone' value='Endurvekja'/>";
			 }

			 else
			 {
			 ?>
			 <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="setjobasdone">
			 <?php
			 	echo "<input type='hidden' name='todo_id' value='".$row['id']."'>";
			 	echo "<tr><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']; 
				echo "</td><td><input type='submit'  name='setjobasdone' value='Skrá verk klárað'/>";
			 }

			echo "</td></tr></form>";
		
		}

		echo "</table></div></div></div></div>";
	
	}
	else{echo "</table></div></div></div></div>";}


?>

		<!-- Greiðsluskrá -->
	<div class="col-md-1" id="payments_table">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".payments">Útlagt</button>
</div>
<div class="modal fade payments" tabindex="-1" role="dialog" aria-labelledby="greidsluskra" aria-hidden="true">
  <div class="modal-dialog modal-sm">
  
    <div class="modal-content">
    <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h2 id="modals" class="modal-title" id="greidsluskra">Greiðsluskrá</h2>
<?php
	$sql2 = "SELECT user_name,value,about_pay from payment where room = '" . $_SESSION['room'] ."';";
	
	$result2 = $conn->query($sql2);
	 echo 	"<table class='table table-striped'><tr><th>Hver skáir greiðslu</th><th id='todo'>Upphæð</th><th>Lýsing</th></tr>";

	if($result2->num_rows > 0)
	{
		while($row = $result2->fetch_assoc())
		{
			echo "<tr><td>". $row['user_name'] ."</td><td>". $row['value'] . "</td><td>". $row['about_pay']. "</td></tr>";
			
		}

		echo "</table></div></div></div></div>";
	}
	else{echo "</table></div></div></div></div>";}


		//sér um að skrá í gagnagrunn.
		$user_function = new UserFunctions();
		
        if(isset($_POST["savejob"])) {
        	
            $user_function->savejob();
        }
        if(isset($_POST["savepayment"]))
        {
        	$user_function->savepayment();
        }

        if(isset($_POST["setjobasdone"])) {

        	$user_function->jobsetasdone();
        }
        if(isset($_POST["setjobnotdone"])) {

        	$user_function->jobsetnotdone();
        }







////////// Sjá skuldastöðu milli einstaklinga///////////////////////////////////////

	// höldum utan um fjölda í herbergi svo hægt sé að deila upphæðinni niður.
	$countUsers = "SELECT COUNT(user_name) FROM users WHERE room='". $_SESSION['room']."';";
	$resultCountUsers = $conn->query($countUsers);

	if($resultCountUsers->num_rows >0)
	{
		while($rowcount = $resultCountUsers->fetch_assoc())
		{	// vistum fjölda users í breytuna totalUsers.
    		$totalUsers = $rowcount['COUNT(user_name)'];
		}
	}
	// höldum utan um upphæðina sem "þú"" hefur lagt út. 
	$yourCredit = "SELECT SUM(value) FROM payment WHERE user_name='". $_SESSION['user_name']."';";
	$yourCreditResult = $conn->query($yourCredit);

	if($yourCreditResult->num_rows >0)
	{
		while($rowCredit = $yourCreditResult->fetch_assoc())
		{	// vistum í breytuna.
    		$totalCredit = $rowCredit['SUM(value)'];
 
		}
	}
	// breyta sem heldur utan um hvað hver og einn skuldar "þér".
	$creditPerUser = $totalCredit/$totalUsers;

	$sql = "SELECT user_name FROM users WHERE room ='" . $_SESSION['room']."';";
	$results = $conn->query($sql);
	

	if($results->num_rows > 0)
	{
		echo "<div class='row'><div class='col-md-6'>";
		while($row = $results->fetch_assoc())
		{	
			// prentum ekki út okkar user name.
			if($_SESSION['user_name'] == $row['user_name']){
				continue;

			}
			else{
				echo 	"<table class='table table-striped'><caption><h2>Skuldastaða milli meðleigjenda<h2></caption><tr><th>Nafn Meðleigjanda</th><th id='value'>Þú skuldar</th><th>Hann skuldar þér</th></tr>";
				$sql1 = "SELECT SUM(value) FROM payment WHERE user_name =  '$row[user_name]'  AND room='". $_SESSION['room']."';";
				$results1 = $conn->query($sql1);

				if($results1->num_rows>0){
					
					while ($row1 = $results1->fetch_assoc()) {
						// skuldastaða users.
						$currentDebt = ($row1['SUM(value)']/$totalUsers)- $creditPerUser;
						// ef þú skildar honum
						if($currentDebt>0){
							
							echo "<tr><td>". $row['user_name'] ."</td><td>". $currentDebt. " Kr.</td><td></td></tr>";
						}
						// ef hann skuldar þér 
						else if($currentDebt<0){
							
							echo "<tr><td>". $row['user_name'] ."</td><td></td><td>". abs($currentDebt). " Kr.</td></tr>";
						}
						else if($currentDebt==0){
							
							echo "<tr><td>". $row['user_name'] ."</td><td>0 kr.</td><td>0 kr.</td></tr>";
						}
						else{
							continue;
						}
					}
				}
			}
		}
		echo "</table>";
	}
	

	

	//færð "tilkynningu um 'reikning' ef þú skuldar pening á mánudegi
	date_default_timezone_set("GMT");

	$day_today = date('l');
	if($day_today == "Monday" && $currentDebt > 0)
	{

		echo '<script type="text/javascript">'
   			, 'nameit();'
   			, '</script>'
		;
	}



	//setjum hérna verkefni sem innskráður notandi á


	$sql = "SELECT todo,do_date FROM todo WHERE done_bool IS NULL AND user_resp ='" . $_SESSION['user_name']."' ;";
	$results = $conn->query($sql);
	

	if($results->num_rows > 0)
	{
		echo 	"<table class='table table-striped' id='my_assignments'><caption><h2 id='modals'>Verkefnin mín</h2></caption><tr><th>Verkefni</th><th id='value'>Dagsetning</th></tr>";
		while($row = $results->fetch_assoc())
		{	

			echo "<tr><td>". $row['todo'] ."</td><td>". $row['do_date']. "</td></tr>";
			
			
			
			
		}
		echo "</table></div>";
	}
	else echo "</table></div>";


 require_once('graph_maker.php');

		echo "<div class='col-md-6' id='graphit'>";
		include_once('graph_payments.html');
		include_once('graph_jobs.html');
		echo "</div></div>";







// hér búum við til takka sem getur skráð okkur úr room-inu.
$form = <<<EOT
<br />
<div class="col-md-1" id="quitroom">

<form action="" method ="POST">
	<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#todo_job" name="quit_room" data-whatever="skra_verkefni">Skrá úr herbergi</button>
<br />
</form>
</div>
EOT;

echo $form;
echo '</div></div>';
// ef ýtt er á takkann hætta í room-i.

if(isset($_POST['quit_room'])){
	$sql = "UPDATE users  SET room = NULL WHERE user_name = '" . $_SESSION['user_name'] ."'; ";                
	$result= $conn->query($sql);
	// ef skipunin virkaði þá refreshum við síðuna.
	//hér ætla ég að reyna bæta við pop-up glugga til að athuga hvort þú sért viss um að vilja hætta í room-i....
	
	if($result){
			printf("<script>location.href='logged_in.php'</script>");
	}

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
	?>

		<div class="col-md-4" id="logout">

	<a href="../index.php?logout">Logout</a>
	</div>
	<?php
}
else 
{
	die('Þú hefur ekki aðgang að þessari síðu');
	printf("<script>location.href='../index.php'</script>");
}
?>




