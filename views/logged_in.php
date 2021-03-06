<?php
require_once("../classes/Login.php");
require_once("../config/db.php");
require_once("../classes/user_functions.php");

$sess = new Login();
$conn = $sess->getDbConnection();


$null_check = "SELECT * from users where user_name = '". $_SESSION['user_name'] . "';";
$null_check_result = $conn->query($null_check);
$res = $null_check_result->fetch_assoc();
$_SESSION['room'] = $res['room'];
$_SESSION['room_name'] = $res['room_name'];

$conn->set_charset("utf8");
echo "<meta charset='utf-8' >";

// dagsetningabreytur
date_default_timezone_set("GMT");

$month_today = intval(substr(date('d-m-y'), 3,2));
$day_today = substr(date('d-m-y'), 0,2);
$_months = array(null,"Janúar","Febrúar","Mars","Apríl","Maí","Júní","Júlí","Ágúst","September","Október","Nóvember","Desember" );

//possum að næsti mánuður á eftir desember sé janúar.
if($month_today==12){
	$next_month=1;
}

else{
	$next_month=$month_today+1;
}

//possum að mánuðurinn á undan janúar sé desember.
if($month_today==1){
	$prev_month=12;
}
else{
	$prev_month=$month_today-1;
}
?>

<title>Roomies</title>
<script src="../js/display_functions.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/look.css">
<!-- Finally the bootbar CSS and JS -->
<script src="../js/bootbar.js"></script>
<link rel='shortcut icon' type='image/x-icon' href='../img/roomies.ico' />
<!-- ***Nota seinna fyrir notification**** -->
<script>function nameit() {
	$.bootbar.info("Í dag er skuldadagur, mundu að greiða!! <?php 
	echo "<a href='' data-toggle='modal' data-target='#skuldastada'>Hér getur þú séð skuldastöðu $_months[$prev_month] mánaðar </a>"; ?> Smelltu á &times; til að loka");
	$('.alert-messages').show();
	
}; 
</script> 

<?php
if($_SESSION['user_login_status'] == 1 && $res['room'] != null)
{
	?>
</head>
<body>
	<div class="alert-messages">
</div>
<div class="container">
	<div class="row" id="header">
		<div class="col-md-8">
			<?php
			echo "<h2 id='change'>Velkomin/n: ".ucfirst($_SESSION['user_name'])." - Herbergisnafn: ".($_SESSION['room_name'])." </h2>" ;
			$form = <<<EOT
			<form action="" method ="POST">
				<button type="submit" class="btn btn-danger" name="quit_room">Skrá úr herbergi</button>
			</form>
EOT;

			echo $form;

			// ef ýtt er á takkann hætta í room-i.
			if(isset($_POST['quit_room'])){
				$sql = "UPDATE users  SET room = NULL WHERE user_name = '" . $_SESSION['user_name'] ."'; ";                
				$result= $conn->query($sql);
				$sql2 = "DELETE FROM todo WHERE user_resp = '" . $_SESSION['user_name'] ."'; ";
				$result2= $conn->query($sql2);
				$sql3 = "DELETE FROM payment WHERE user_name = '" . $_SESSION['user_name'] ."'; ";
				$result3= $conn->query($sql3);
	// ef skipunin virkaði þá refreshum við síðuna.
	//hér ætla ég að reyna bæta við pop-up glugga til að athuga hvort þú sért viss um að vilja hætta í room-i....
	
				if($result){
					printf("<script>location.href='logged_in.php'</script>");
				}

			}
	?>
	<!-- Takkar til að útskrá notenda og breyta upplýsingum um herbergi -->
		</div>
	<div class="col-md-4" id="logout">
		<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#change_info" data-whatever="skra_upplysingar">Breyta upplýsingum</button>
		<button class="btn btn-default btn-sm" onclick="location.href='../index.php?logout'">Útskrá</button>
    </div>

	</div>
	<div class="row">
		<div class="form-group">
			<div class="col-md-5" id="temp">
				<button type="button" class="btn btn-primary col-md-3"  data-toggle="modal" data-target="#todo_job" data-whatever="skra_verkefni">Skrá verkefni</button>
				<button type="button" class="btn btn-primary col-md-3" data-toggle="modal" data-target="#payment" data-whatever="skra_utjold">Skrá útgjöld</button>
				<button type="button" class="btn btn-primary col-md-3" data-toggle="modal" data-target=".assignments" data-whatever="skra_verkefni">Verkefnaskrá</button>
				<button type="button" class="btn btn-primary col-md-2" data-toggle="modal" data-target=".payments" data-whatever="skra_utjold">Útlagt</button>

			</div>
		</div>
	</div>

	<div class="modal fade" id="change_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			  	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h2 id="modals" class="modal-title" id="exampleModalLabel">Hér getur þú breytt nafni og leigu</h2>
			   	</div>
			  	<div class="modal-body">
			        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="change_info">
			       		<div class="form-group">
			            <?php
			            	echo '<h4>Lykill fyrir herbergi: </h4><h4 id="orange">'. $_SESSION['room'].'</h4>';
			            ?>
			          	</div>
			          	<div class="form-group">
			            	<label for="recipient-name" class="control-label">Upphæð leigu</label>
			            	<input type="number" class="form-control" name="update_rent" id="recipient-name">
			          	</div>
	             		<div class="form-group">
	             			<label for="date" class="control-label">Herbergisnafn</label>
			            	<input type="text" class="form-control" name="update_room_name" id="recipient-name">
			          	</div>
			       
			      		<div class="modal-footer">
			        
			        		<input type="submit"  name="change_info" value="Breyta" />
			      		</div>
			      	</form>
			    </div>
			</div>
		</div>
	</div>


<!-- sjá skuldastöðu frá síðasta mánuði -->
	<div class="modal fade" id="skuldastada"  tabindex="-1" role="dialog" aria-labelledby="greidsluskra" aria-hidden="true">
		<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h2 id="modals" class="modal-title" id="greidsluskra">Skuldastaða meðleigjanda í <?php echo $_months[$prev_month]; ?> </h2>
						<?php
						echo 	"<table class='table table-striped'><tr><th>Nafn Meðleigjanda</th><th id='value'>Skuld</th></tr>";

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

						$temp1= $_SESSION['user_name'];
						$temp = $_SESSION['room'];

						$sql ="SELECT user_name,SUM(value) FROM payment  WHERE room='$temp' AND user_name != '$temp1'ANd c_date > '2015/$prev_month/01' AND c_date < '2015/$month_today/01' group by user_name";
						$results= $conn->query($sql);
	
						if ($results->num_rows>0) {

							while($row = $results->fetch_assoc()){
								echo "<tr><td>". $row['user_name'] ."</td><td>".intval($row['SUM(value)']/$totalUsers)." Kr.</td></tr>";

							}
						}
	
						echo "</table>";
						?>

						<h2 class="modal-title">Leiguverð fyrir <?php echo $_months[$month_today]; ?> mánuð </h2>
						<?php 
						//leiguverð og leigu hlutur.
	 					echo 	"<table class='table table-striped'><tr><th>Heildar Leiguverð</th><th>Þinn hlutur</th></tr>"; //---------------------------------------------------------------------------------------
	 					$sql = "SELECT room_rent FROM users Where user_name = '". $_SESSION['user_name']."';";
	 					$results = $conn->query($sql);
	 					if($results->num_rows > 0){
	 						while ($row = $results->fetch_assoc()) {
	 							echo "<tr><td>" .$row['room_rent']." kr.</td><td>".intval($row['room_rent']/$totalUsers)." kr.</td></tr>";

	 						}
	 					}
					?>
						</table>
				</div>
			</div>
		</div>
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
			        
			        <input type="submit"  name="savejob" value="Skrá útgjöld" />
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

			
	<!-- Verkefnaskrá -->
<div class="modal fade assignments" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 id="modals" class="modal-title" id="greidsluskra">Verkefnaskrá</h2>
     




	<?php


	$temp = $_SESSION['room'];
	$sql = "SELECT id,user_name,todo,user_resp,do_date,done_bool from todo where room = '$temp'  order by do_date limit 30 ";
	
	$result = $conn->query($sql);

	echo "<table class='table table-striped'><tr><th>Hver skáir</th><th id='todo'>Todo</th><th>Hver á verk</th><th>Klára fyrir</th></tr>";
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if($_SESSION['user_name'] == $row['user_resp'])
			{
				 if($row['done_bool'] == 'X')
				 {
				 ?>
				 <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="setjobnotdone">
				 <?php
				 echo "<input type='hidden' name='todo_id' value='".$row['id']."'>";
				 	echo "<tr id='green'><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']. "</td><td><input type='submit'  name='setjobnotdone' value='Endurvekja'/>";
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
			else
			{
				if($row['done_bool'] == 'X')
				 {
				 echo "<input type='hidden' name='todo_id' value='".$row['id']."'>";
				 	echo "<tr id='green'><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']. "</td><td>";
				 }

				 else
				 {
				 ?>
				 
				 <?php
				 	echo "<input type='hidden' name='todo_id' value='".$row['id']."'>";
				 	echo "<tr><td>". $row['user_name'] ."</td><td>". $row['todo'] . "</td><td>". $row['user_resp']. "</td><td>". $row['do_date']; 
					echo "</td><td>";
				 }
			} 


			
		
		}

		echo "</table></div></div></div></div>";
	
	}
	else{echo "</table></div></div></div></div>";}


?>

		<!-- Greiðsluskrá -->
<div class="modal fade payments" tabindex="-1" role="dialog" aria-labelledby="greidsluskra" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  
    <div class="modal-content">
    <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h2 id="modals" class="modal-title" id="greidsluskra">Greiðsluskrá</h2>
<?php
	//temp breyta til að nota í sql skipuninni.
	$temp=$_SESSION['room']; 
	$sql2 = "SELECT user_name,value,about_pay,reg_date from payment where room = '$temp' order by reg_date /*limit 20*/";
	
	$result2 = $conn->query($sql2);
	 echo 	"<table class='table table-striped'><tr><th>Hver skáir greiðslu</th><th id='todo'>Upphæð</th><th>Lýsing</th><th>Dagsetning</th></tr>";

	if($result2->num_rows > 0)
	{

		while($row = $result2->fetch_assoc())
		{
			$monthofpay= substr($row['reg_date'], 3,2);
			if ($monthofpay==$month_today) {

				$_SESSION['value'] = $row['value'];
			echo "<tr><td>". $row['user_name'] ."</td><td>". $row['value'] . "</td><td>". $row['about_pay']. "</td><td>". $row['reg_date']. "</td></tr>";
			}
			
		}

		echo "</table></div></div></div></div>";
	}
	else{echo "</table></div></div></div></div>";}


		//USER functions
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
         if(isset($_POST["change_info"])) {

        	$user_function->updateroominfo();
        }






    $countUsers = "SELECT COUNT(user_name) FROM users WHERE room='". $_SESSION['room']."';";
	$resultCountUsers = $conn->query($countUsers);

	if($resultCountUsers->num_rows >0)
	{
		while($rowcount = $resultCountUsers->fetch_assoc())
		{	// vistum fjölda users í breytuna totalUsers.
    		$totalUsers = $rowcount['COUNT(user_name)'];
		}
	}

	// prentum út hver skuldar hverjum í þessum mánuði.

	$temp1= $_SESSION['user_name'];
	$temp = $_SESSION['room'];
	echo "<div class='row'><div class='col-md-6' id='prump'>";
	echo "<table class='table table-striped'><caption><h2>Skuldastaða milli meðleigjenda í núverandi mánuði<h2></caption><tr><th>Nafn Meðleigjanda</th><th id='value'>Heildarskuld</th></tr>";


	$sql ="SELECT user_name,SUM(value) FROM payment  WHERE room='$temp'AND user_name != '$temp1' ANd  c_date > '2015/$month_today/01' AND c_date < '2015/$next_month/01' group by user_name";
	$results= $conn->query($sql);
	
	if ($results->num_rows>0) {

		while($row = $results->fetch_assoc()){
			
			echo "<tr><td>". $row['user_name'] ."</td><td>".intval($row['SUM(value)']/$totalUsers)." Kr.</td></tr>";
		}
	}

	echo "</table>";

?>
	<!-- takki fyrir neðan skuldastöðu sem opnar glugga fyrir skuldastöðu frá síðasta tímabili.-->
	<a href="" data-toggle="modal" data-target="#skuldastada">Sjá skuldastöðu frá síðasta mánuði </a>

	<?php

	//færð "tilkynningu um 'reikning' ef þú skuldar pening á mánudegi
	
	if(($day_today == 14) ||($day_today == 2) ||($day_today == 3)||($day_today == 1) )
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

if($_SESSION['value'] != null)
{

		echo "<div class='col-md-6' id='graph'>";
		require('graph_maker.php');
		include_once('graph_payments.html');
		include_once('graph_jobs.html');
		echo "</div>";
}


echo "</div>";


}
else if($_SESSION['user_login_status'] == 1 && $res['room'] == null)
{
?>
	<div class="container">
<div class="row" id="header">
	<div class="col-md-8">
	<?php
		echo "<h2 id='change'>Velkomin/n: ".ucfirst($_SESSION['user_name'])." - Herbergi: ".($_SESSION['room'])." </h2>" ;
		$form = <<<EOT
<form action="" method ="POST">
	<button type="submit" class="btn btn-danger"  data-toggle="modal" data-target="#todo_job" name="quit_room" data-whatever="skra_verkefni">Skrá úr herbergi</button>
</form>

EOT;



	?>
	</div>
	<div class="col-md-4" id="logout">
	<button class="btn btn-default btn-sm" onclick="location.href='../index.php?logout'">
     Útskrá</button>
	</div>

</div>




<?php
	
// formið join og create room.
$form = <<<EOT

<form action="" class="form-inline" method ="POST">
<div class="form-group">
Þú ert ekki skráð/ur í neitt Room. Þú getur tengst Room-i eða búið til nýtt Room. <br />
<button type="button" class="btn btn-primary col-md-3" data-toggle="modal" data-target="#createroom" data-whatever="skra_utjold">Búa til herbergi</button>&emsp;
<input type = "text" class="form-control" name="room" placeholder="herbergislykill" />&emsp;<button type="submit" class="btn btn-primary col-md-4" value="tengjast room numeri" name="join_room">Tengjast herbergi</button>&emsp;
</div>


EOT;
?>
		<div class="modal fade" id="createroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		 <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h2 id="modals" class="modal-title" id="exampleModalLabel">Settu inn viðeigandi upplýsingar</h2>
			      </div>
			      <div class="modal-body">
			        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']?>" name="create_room">

			          <div class="form-group">
			            <label for="recipient-name" class="control-label">Nafn á herbergi</label>
			            <input type="text" class="form-control" name="roomname" id="recipient-name">
			          </div>
	             <div class="form-group">
	             		<label for="rent" class="control-label">Leiga á mánuði</label>
			            <input type="number" class="form-control" name="rent" id="recipient-name">
			          </div>
			       
			      <div class="modal-footer">
			        
			        <input type="submit"  name="create_room" value="Skrá verk" />
			      </div>
			      </form>
			    </div>
			    </div>
			    </div>
			    </div>

			    <?php

echo $form;
	$user_functions = new UserFunctions();
	if(isset($_POST["create_room"])) {

       $user_functions->createroom();
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
	
	echo 'Þú hefur ekki aðgang að þessari síðu, þú þarft að skrá þig inn. Færi tilbaka eftir 2 sekúndur';
	sleep(2);
	 printf("<script>location.href='../index.php'</script>");
	 die();
}
?>

