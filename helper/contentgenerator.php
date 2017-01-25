<?php
require('mysqli.php');

function listStore(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, s.name as a2, p.amount as a3,
 				p.time as a4 FROM supplier s, pallet p, product pr
			where pr.id=p.product_id and p.supplier_id = s.id
			and p.deleted = 0 and pr.deleted = 0
			order by a2");
	//and a.nev='".$alapanyag."'
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a0"].'</td>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="trash('.$row["a0"].','.$row["a3"].')">Selejt</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listProduct(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT p.id as id, p.name as name, c.name as cat FROM product p, category c WHERE c.id = p.category_id");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>Kategória</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="ujalap()">Új alapanyag</button></th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="alapkat_'.$row["id"].'">'.$row["cat"].'</td>';
		print '<td><button class="btn btn-sm" onclick="editproduct('.$row["id"].')">Szerkeszt</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listSupplier(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM supplier");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beszállító címe</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="ujbesz()">Új Beszállító</button></th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="besznev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="beszcim_'.$row["id"].'">'.$row["address"].'</td>';
		print '<td ><button class="btn btn-sm" onclick="editbeszallito('.$row["id"].')">Szerkeszt</button></td>';
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

function palletOutput($alapanyag){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, s.name as a2, p.amount as a3,
 				p.time as a4 FROM supplier s, pallet p, product pr
			where pr.id=p.product_id and p.supplier_id = s.id
			and p.deleted = 0 and pr.deleted = 0
			order by a2");
	//and a.nev='".$alapanyag."'
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';

	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a0"].'</td>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a3"].'</td>';

		print '<td><button class="button" onclick="output('.$row["a0"].','.$row["a3"].')">Kiadás</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function palletSpare($alapanyag){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, s.name as a2, p.amount as a3,
 				p.time as a4 FROM supplier s, pallet p, product pr
			where pr.id=p.product_id and p.supplier_id = s.id
			and p.deleted = 0 and pr.deleted = 0
			order by a2");
	//and a.nev='".$alapanyag."'
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Selejt</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a0"].'</td>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a4"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '<td><button class="btn btn-sm" onclick="trash('.$row["a0"].','.$row["a3"].')">Selejt</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function supplierOption(){
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

function productOption(){

	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM product order by name");
	print '<select id="alap" class="form-control">';
	while($row = $results->fetch_assoc()) {
		print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
	}
	print '</select>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function dailyInput(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, s.name as a2, p.amount as a3
 				FROM supplier s, pallet p, product pr
			where pr.id=p.product_id and p.supplier_id = s.id
			 and p.time >= CURDATE()  order by a2");

	print '<table class="table table-inverse">';
	print '<tr>';
	print '<th>Alapanyag</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Mennyiség</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '</tr>';
	}
	print '</table>';

	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function dailyOutput(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, p.amount as a2, o.time as a3
 				FROM  pallet p, product pr, output o
			where pr.id=p.product_id and o.pallet_id = p.id
			 and o.time >= CURDATE()  order by a2");
	print '<table class="table table-inverse">';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>Alapanyag</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiadási idő</th>';
	print '</tr>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["a0"].'</td>';
		print '<td>'.$row["a1"].'</td>';
		print '<td>'.$row["a2"].'</td>';
		print '<td>'.$row["a3"].'</td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listOld(){
	$mysqli = connect();
	$results = $mysqli->query(
			"SELECT p.id as a0, pr.name as a1, p.amount as a2, p.time as a3
 				FROM  pallet p, product pr
			where pr.id=p.product_id
			 and p.time < CURDATE()-5  order by a3");

	$str =  '<table class="table table-inverse">';
	$str .= '<tr>';
	$str .= '<th>ID</th>';
	$str .= '<th>Alapanyag</th>';
	$str .= '<th>Mennyiség</th>';
	$str .= '<th>Bevétel ideje</th>';
	$str .= '</tr>';
	$i = false;
	while($row = $results->fetch_assoc()) {
		$i = true;
		$str .= '<tr>';
		$str .= '<td>'.$row["a0"].'</td>';
		$str .= '<td>'.$row["a1"].'</td>';
		$str .= '<td>'.$row["a2"].'</td>';
		$str .= '<td>'.$row["a3"].'</td>';
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

function listUser(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * from User");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Felhasználó Név</th>';
	print '<th>Jogosultság</th>';
	print '<th>Szerkeszt</th>';
	print '<th><button class="btn btn-sm" onclick="newUser()">Új Felhasználó</button></th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="usernev_'.$row["id"].'">'.$row["name"].'</td>';
		if($row["type"] === "0"){
			print '<td id="usertype_'.$row["id"].'">Admin</td>';
		}else if($row["type"] === "1"){
			print '<td id="usertype_'.$row["id"].'">Raktáros</td>';
		}
		print '<td><button class="btn btn-sm" onclick="editUserName('.$row["id"].')">Név Szerkeszés</button></td>';
		print '<td><button class="btn btn-sm" onclick="editUserPass('.$row["id"].')">Új Jelszó</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}
?>