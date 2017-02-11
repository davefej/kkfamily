<?php
require('mysqli.php');

$mysqli = connect();
$results = $mysqli->query("SELECT count(*) as amount from alert where seen = false ");
$i = false;
while($row = $results->fetch_assoc()) {	
	if(!$i){
		print $row["amount"];
	}		
	$i = true;
}
if(!$i){
	print '0';
}

$results->free();
// close connection
$mysqli->close();
?>