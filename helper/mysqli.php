<?php

require('configuration.php');

function connect(){
	
	$mysql_host = getconfig('dbhost');
	$mysql_database = getconfig('dbname');
	$mysql_user = getconfig('dbuser');
	$mysql_password = getconfig('dbpass');
	$db = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);

	if($db->connect_errno > 0){
		errorlog('error not connected to database');
	}
	
	if(!mysqli_set_charset($db, "utf8")){
		errorlog('error charset not loading');
	}
	return $db;
}

function listallsupplier(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM supplier");
	
	print '<table align="center" border="1">';
	while($row = $results->fetch_assoc()) {		
		print '<tr>';		
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["address"].'</td>';		
		print '</tr>';
	}
	print '</table>';
	
	// Frees the memory associated with a result
	$results->free();	
	// close connection
	$mysqli->close();
}


?>


