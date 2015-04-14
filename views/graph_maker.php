<?php
//spýtum úr gagnagrunn í json til að útbua graf.
	$room = $_SESSION['room'];
	$sql4 = "SELECT user_name,sum(value) FROM payment WHERE room = '$room' group by user_name;";
	$results4 = $conn->query($sql4);
	
	$table= array();
	$table['cols'] = array(
		array('label' => 'username','type' => 'string'),
		array('label' => 'total', 'type' => 'number'));
	$rows = array();
	while($r = $results4->fetch_assoc())
	{
		$temp = array();
		$temp[] = array('v' => $r['user_name']);
   		$temp[] = array('v' => (int) $r['sum(value)']); 
   		$rows[] = array('c' => $temp);

	}
	$table['rows'] = $rows;
	
	
$fp = fopen('../data/data.json', 'w+');
fwrite($fp, json_encode($table));
fclose($fp);










//verkefnagraf

	$room1 = $_SESSION['room'];
	$sql = "SELECT user_resp,count(todo),count(done_bool) FROM todo WHERE room = '$room1'  group by user_resp";
	$results = $conn->query($sql);
	
	$table1= array();
	$table1['cols'] = array(
		array('label' => 'username','type' => 'string'),
		array('label' => 'total', 'type' => 'number'),
		array('label' => 'done', 'type' => 'number'),
		);
	$rows1 = array();
	while($r1 = $results->fetch_assoc())
	{
		$temp1 = array();
		$temp1[] = array('v' => $r1['user_resp']);
   		$temp1[] = array('v' => (int) $r1['count(todo)']);
   		$temp1[] = array('v' => (int) $r1['count(done_bool)']);  
   		$rows1[] = array('c' => $temp1);

	}
	$table1['rows'] = $rows1;
	
	
$fp1 = fopen('../data/data2.json', 'w+');
fwrite($fp1, json_encode($table1));
fclose($fp1);

?>