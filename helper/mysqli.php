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
	
	print '<table align="center" style="width:80%;text-align:center;font-size:110%;" border="1">';
	print '<tr>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beszállító Címe</th>';
	print '</tr>';
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


function listallraklap(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3 
			, r.idopont as a4, r.mennyiseg as a5, r.statusz 
			as a6 FROM supplier s, raklap r, alapanyag a 
			where a.id=r.alapanyag_id and r.beszallito_id = s.id order by a1");

	print '<table align="center" style="width:80%;text-align:center;font-size:110%;" border="1">';
	print '<tr>';
	print '<th>Raklap azonosító</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító</th>';
	print '<th>Érkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Raktárban?</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a5"].' kg</td>';
		if($row["a6"] == "0"){
			print '<td>Igen</td>';
		}else{
			print '<td>Nem</td>';
		}
		
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listallalapanyag(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM alapanyag");

	print '<table align="center" style="width:80%;text-align:center;font-size:110%;" border="1">';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>kategória</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["nev"].'</td>';
		print '<td>'.$row["kategoria"].'</td>';
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

?>


