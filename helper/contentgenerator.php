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
	$results = $mysqli->query("SELECT p.id as id, p.name as name, c.name as cat FROM product p, category c WHERE c.id = p.category_id and p.deleted = false");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>Kategória</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="createProduct()">Új alapanyag</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="alapkat_'.$row["id"].'">'.$row["cat"].'</td>';
		print '<td><button class="btn btn-sm" id="newRetailer"  onclick="editProduct('.$row["id"].')">Szerkeszt</button></td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="deleteProduct('.$row["id"].')">Töröl</button></td>';
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
	$results = $mysqli->query("SELECT * FROM supplier where deleted = false");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beszállító címe</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="createSupplier()">Új Beszállító</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="besznev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="beszcim_'.$row["id"].'">'.$row["address"].'</td>';
		print '<td ><button class="btn btn-sm" id="newRetailer" onclick="editSupplier('.$row["id"].')">Szerkeszt</button></td>';
		print '<td ><button class="btn btn-sm btn-danger" onclick="deleteSupplier('.$row["id"].')">Töröl</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function listCategory(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM category where deleted = false");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Kategória Neve</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="createCategory()">Új Kategória</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="categoryname_'.$row["id"].'">'.$row["name"].'</td>';		
		print '<td ><button class="btn btn-sm" id="newRetailer" onclick="editCategory('.$row["id"].')">Szerkeszt</button></td>';
		print '<td ><button class="btn btn-sm btn-danger" onclick="deleteCategory('.$row["id"].')">Töröl</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function palletOutput($alapanyag){
	$mysqli = connect();
	if($results = $mysqli->query(
			"select p.id as id, pr.name as product, s.name as supplier,p.time as time, 
IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest 
from pallet p 
INNER JOIN product pr on p.product_id = pr.id
INNER JOIN supplier s on s.id = p.supplier_id
LEFT JOIN (
    select t2.id as id ,t3.amount as trash,t2.amount as output from 
		(
           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
        ) t2 
		LEFT JOIN 
		(
           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
        ) t3 
		ON t2.id = t3.id 
		UNION
	select t2.id as id ,t3.amount as trash,t2.amount as output from 
		(
            SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
        ) t2 
		RIGHT JOIN 
		(
            SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
        ) t3 
		ON t2.id = t3.id 
 ) t1 
 on p.id = t1.id
HAVING rest > 0
			")){
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
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["rest"].'</td>';

		print '<td><button class="btn btn-sm btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	
	$mysqli->close();
}

function palletSpare($alapanyag){
	$mysqli = connect();
	if($results = $mysqli->query(
			"select p.id as id, pr.name as product, s.name as supplier,p.time as time, 
		IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest 
		from pallet p 
		INNER JOIN product pr on p.product_id = pr.id
		INNER JOIN supplier s on s.id = p.supplier_id
		LEFT JOIN (
    select t2.id as id ,t3.amount as trash,t2.amount as output from 
		(
           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
        ) t2 
		LEFT JOIN 
		(
           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
        ) t3 
		ON t2.id = t3.id 
		UNION
	select t2.id as id ,t3.amount as trash,t2.amount as output from 
		(
            SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
        ) t2 
		RIGHT JOIN 
		(
            SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
        ) t3 
		ON t2.id = t3.id 
 ) t1 
 on p.id = t1.id
HAVING rest > 0
			")){
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
			print '<td>'.$row["id"].'</td>';
			print '<td>'.$row["product"].'</td>';
			print '<td>'.$row["supplier"].'</td>';
			print '<td>'.$row["time"].'</td>';
			print '<td>'.$row["rest"].'</td>';
			print '<td><button class="btn btn-sm btn-danger" onclick="trash('.$row["id"].','.$row["rest"].')">Selejt</button></td>';
			print '</tr>';
		}
		print '</table>';
		// Frees the memory associated with a result
		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	$mysqli->close();
}

function supplierOption(){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM supplier WHERE deleted = false order by name")){
		print '<select id="besz" class="form-control">';
		while($row = $results->fetch_assoc()) {
			print '<option value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';
	
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
		
	$mysqli->close();
}

function productOption(){

	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM product where deleted = false order by name");
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

function categoryOption(){

	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM category where deleted = false order by name");
	print '<select id="category_option" class="form-control">';
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
	if($results = $mysqli->query(
				"SELECT p.id as a0, pr.name as a1, s.name as a2, p.amount as a3
	 				FROM supplier s, pallet p, product pr
				where pr.id=p.product_id and p.supplier_id = s.id
				 and p.time >= CURDATE()  and p.deleted = false and pr.deleted = false order by a2")){
	
		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr>';
		print '<th>Alapanyag</th>';
		print '<th>Beszállító Neve</th>';
		print '<th>Mennyiség</th>';
		print '</tr>';
		print '</thead>';
		$i = false;
		while($row = $results->fetch_assoc()) {
			print '<tr>';
			print '<td>'.$row["a1"].'</td>';
			print '<td>'.$row["a2"].'</td>';
			print '<td>'.$row["a3"].'</td>';
			print '</tr>';
			$i = true;
		}
		print '</table>';
	
		if(!$i){
			print('Ma még nem érkezett be semmi a raktárba');
		}
		
		// Frees the memory associated with a result
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function dailyOutput(){
	$mysqli = connect();
	if($results = $mysqli->query(
				"SELECT p.id as a0, pr.name as a1, p.amount as a2, o.time as a3
	 				FROM  pallet p, product pr, output o
				where pr.id=p.product_id and o.pallet_id = p.id
				 and o.time >= CURDATE() and p.deleted = false and pr.deleted = false and o.deleted = false order by a2")){
		$str =  '<table class="table table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>ID</th>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Kiadási idő</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$i =false;
		while($row = $results->fetch_assoc()) {
			$str .= '<tr>';
			$str .= '<td>'.$row["a0"].'</td>';
			$str .= '<td>'.$row["a1"].'</td>';
			$str .= '<td>'.$row["a2"].'</td>';
			$str .= '<td>'.$row["a3"].'</td>';
			$str .= '</tr>';
			$i =true;
		}
		print '</table>';
		
		if($i){
			print $str;
			
		}else{
			print ("Ma még semmmit nem adtak ki a raktárból");
		}
				
		$results->free();
	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}
	
	$mysqli->close();
}

function listOld(){
	$mysqli = connect();
	if($results = $mysqli->query(
				"SELECT p.id as a0, pr.name as a1, p.amount as a2, p.time as a3
	 			FROM  pallet p, product pr
				where pr.id=p.product_id
				and p.time < CURDATE() and p.deleted = false order by a3 ")){
	
		$str =  '<table class="table table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>ID</th>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Bevétel ideje</th>';
		$str .= '</tr>';
		$str .= '</thead>';
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
	
	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}
	// close connection
	$mysqli->close();
}

function listUser(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * from User where deleted = false");
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Felhasználó Név</th>';
	print '<th>Jogosultság</th>';
	print '<th>Szerkeszt</th>';
	print '<th><button class="btn btn-sm" id="newRetailer" onclick="createUser()">Új Felhasználó</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="username_'.$row["id"].'">'.$row["name"].'</td>';
		if($row["type"] === "0"){
			print '<td id="usertype_'.$row["id"].'">Admin</td>';
		}else if($row["type"] === "1"){
			print '<td id="usertype_'.$row["id"].'">Raktáros</td>';
		}
		print '<td><button class="btn btn-sm" onclick="editUserName('.$row["id"].')">Név Szerkeszés</button></td>';
		print '<td><button class="btn btn-sm" onclick="editUserPass('.$row["id"].')">Új Jelszó</button></td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="deleteUser('.$row["id"].')">Törlés</button></td>';
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}
?>