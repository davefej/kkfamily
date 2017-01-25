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


function insert($sql){
	$mysqli = connect();
	$var = $mysqli->query($sql);
	return $var; 
}

function update($sql){
	$mysqli = connect();
	$var = $mysqli->query($sql);
	return $var;
}

function listallraklap(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3 
			, r.idopont as a4, r.mennyiseg as a5, r.statusz 
			as a6 FROM supplier s, raklap r, alapanyag a 
			where a.id=r.alapanyag_id and r.beszallito_id = s.id order by a1");

	print '<table align="center"class="raklaptable" border="1">';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Hely</th>';
	
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a5"].'</td>';
		
		if($row["a6"] == "0"){
			print '<td>Raktar</td>';
		}else{
			print '<td>Ăśzem</td>';
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


	print '<table align="center"class="alapanyagtable" border="1">';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>KategĂłria</th>';
	print '<th><button onclick="ujalap()">Ăšj alapanyag</button></th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["nev"].'</td>';
		print '<td id="alapkat_'.$row["id"].'">'.$row["kategoria"].'</td>';
		print '<td><button onclick="editalap('.$row["id"].')">Szerkeszt</button></td>';
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listallsupplier(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM supplier");

	print '<table align="center" class="suppliertable" border="1">';
	print '<tr>';
	print '<th>BeszĂˇllĂ­tĂł Neve</th>';
	print '<th>BeszĂˇllĂ­tĂł CĂ­me</th>';
	print '<th><button onclick="ujbesz()">Ăšj Beszallito</button></th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="besznev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="beszcim_'.$row["id"].'">'.$row["address"].'</td>';
		print '<td ><button onclick="editbeszallito('.$row["id"].')">szerkeszt</button></td>';
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}


function tablegen($results,$type,$headers){
	print '<table  align="center" class="'.$type.'table" border="1">';
	print '<tr>';
		for($i = 0; $i < count($headers); $i++){
			print '<th>'.$headers[$i].'</th>';
		}
		
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';		
		for($i = 0; $i < count($headers); $i++){			
			print '<td>'.$row["a".strval($i)].'</td>';
		}		
		
		print '</tr>';
	}
	print '</table>';
}



function listkiadas($alapanyag){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3
			, r.idopont as a4, r.mennyiseg as a5, r.statusz
			as a6 FROM supplier s, raklap r, alapanyag a
			where a.id=r.alapanyag_id and r.beszallito_id = s.id  
			 and r.statusz = 0  order by a1");
	//and a.nev='".$alapanyag."'

	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Hely</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';
	
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a5"].'</td>';

		if($row["a6"] == "0"){
			print '<td>Raktár</td>';
		}else{
			print '<td>Ăśzem</td>';
		}
		print '<td><button class="button" onclick="kiad('.$row["a1"].')">Kiadás</button></td>';

		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}


function beszallitokoption(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM supplier order by name");
	print '<select id="besz" class="form-control">';
	while($row = $results->fetch_assoc()) {
		print '<option value="'.$row["id"].'">'.$row["name"].'</option>';		
	}
	print '</select>';
	
// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function alapanyagoption(){
	
		$mysqli = connect();
		$results = $mysqli->query("SELECT * FROM alapanyag order by nev");
		print '<select id="alap" class="form-control">';
		while($row = $results->fetch_assoc()) {
			print '<option  value="'.$row["id"].'">'.$row["nev"].'</option>';
		}
		print '</select>';
	
		// Frees the memory associated with a result
		$results->free();
		// close connection
		$mysqli->close();
	}
	
function listnapibevetel(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3
			, r.idopont as a4, r.mennyiseg as a5, r.statusz
			as a6 FROM supplier s, raklap r, alapanyag a
			where a.id=r.alapanyag_id and r.beszallito_id = s.id
			 and r.statusz = 0 and idopont >= CURDATE()  order by a2");
	
	print '<table class="table table-inverse">';
	print '<tr>';
	print '<th>Alapanyag</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Mennyiség</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';		
		print '<td>'.$row["a5"].'</td>';
		print '</tr>';
	}
	print '</table>';
	
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listnapikiadas(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3
			, r.idopont as a4, r.mennyiseg as a5, r.kiadasido
			as a6 FROM supplier s, raklap r, alapanyag a
			where a.id=r.alapanyag_id and r.beszallito_id = s.id
			 and r.statusz = 1 and idopont >= CURDATE()  order by a2");

	print '<table class="table table-inverse">';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiadási idő</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a5"].'</td>';
		print '<td>'.$row["a6"].'</td>';
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listlejar(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT r.id as a1, a.nev as a2,s.name as a3
			, r.idopont as a4, r.mennyiseg as a5, r.kiadasido
			as a6 FROM supplier s, raklap r, alapanyag a
			where a.id=r.alapanyag_id and r.beszallito_id = s.id
			 and r.statusz = 1 and idopont <= CURDATE()-5  order by a2");
	
	$str =  '<table class="table table-inverse">';
	$str .= '<tr>';
	$str .= '<th>ID</th>';
	$str .= '<th>Alapanyag</th>';
	$str .= '<th>Mennyiség</th>';
	$str .= '<th>Kiadási idő</th>';
	$str .= '</tr>';
	$i = false;
	while($row = $results->fetch_assoc()) {
		$i = true;
		$str .= '<tr>';
		$str .= '<td>'.$row["a1"].'</td>';
		$str .= '<td>'.$row["a2"].'</td>';
		$str .= '<td>'.$row["a5"].'</td>';
		$str .= '<td>'.$row["a6"].'</td>';
		$str .= '</tr>';
	}
	$str .= '</table>';
	
	if($i){
		print $str;
	}else{
		print "<br/>NINCS LEJÁRÓ TERMÉK :)";
	}
	
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

?>


