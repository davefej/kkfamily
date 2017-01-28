<?php
require('mysqli.php');
require('datepicker.php');

function listStore($id){
	
	if($id === ""){
		$filter  = "";
	}else{
		$filter  = "and pr.id = '".$id."' ";
	}
	
	
	$labels = array();
	$data = array();
	$mysqli = connect();
	if($results = $mysqli->query(
			"select p.id as id, pr.name as product, s.name as supplier,p.time as time, u.name as user,
IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest 
from pallet p 
INNER JOIN product pr on p.product_id = pr.id ".$filter."
INNER JOIN supplier s on s.id = p.supplier_id
INNER JOIN user u on u.id = p.user_id
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
HAVING rest > 0")){
	
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>';
	productOptionStore($id);
	print 'Alapanyag név</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Raktáros</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		if(in_array($row["product"],$labels))
		{
			$key = array_search($row["product"],$labels);
			$data[$key] = $data[$key]+(int)$row["rest"]; 
		}else{
			array_push($labels,$row["product"]);
			array_push($data,(int)$row["rest"]);
		}
		
		print '<tr>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		print '<td>'.$row["user"].'</td>';
		print '</tr>';
	}
	print '</table>';
	
	$colors = array( 'rgba(255, 99, 132, 0.8)',
			'rgba(54, 162, 235, 0.8)',
			'rgba(255, 206, 86, 0.8)',
			'rgba(75, 192, 192, 0.8)',
			'rgba(153, 102, 255, 0.8)');
	
	$backgroundColor = array();
	for($i=0; $i < count($labels); $i++){
		$num = $i%count($colors);
		array_push($backgroundColor,$colors[$num]);
	}
	
	$datasets = array(
			"label" => "Raktárkészletek",
			"backgroundColor" => $backgroundColor,
			"borderWidth" => 0,
			"data" => $data
	);
	$datasetsarray = array($datasets);
	$json = array(
		"labels" => $labels,
		"datasets" => $datasetsarray
	);
	
	$json_str = json_encode($json,True);
	
	print '<div id="storage_json" class="hiddendiv">'.$json_str.'</div>';
	// Frees the memory associated with a result
	$results->free();
	
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
}

function listProduct(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT p.id as id, p.name as name, c.name as cat FROM product p, category c WHERE c.id = p.category_id and p.deleted = false");
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>Kategória</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createProduct()">Új alapanyag</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="alapkat_'.$row["id"].'">'.$row["cat"].'</td>';
		print '<td><button class="btn btn-sm btn-default" id="newRetailer"  onclick="editProduct('.$row["id"].')">Szerkeszt</button></td>';
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
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beszállító címe</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createSupplier()">Új Beszállító</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="besznev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="beszcim_'.$row["id"].'">'.$row["address"].'</td>';
		print '<td ><button class="btn btn-sm btn-default" id="newRetailer" onclick="editSupplier('.$row["id"].')">Szerkeszt</button></td>';
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
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Kategória Neve</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createCategory()">Új Kategória</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="categoryname_'.$row["id"].'">'.$row["name"].'</td>';		
		print '<td ><button class="btn btn-sm btn-default" id="newRetailer" onclick="editCategory('.$row["id"].')">Szerkeszt</button></td>';
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
	print '<table class="table table-hover sortable">';
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
		print '<table class="table table-hover sortable">';
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

function productOptionStore($filter){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM product where deleted = false order by name");
	print '<select id="prod_select" onchange="filterProd()" class="form-control">';
	print '<option  value=""> - </option>';
	print '<option  value=""> Összes </option>';
	while($row = $results->fetch_assoc()) {
		if($filter === $row["id"]){
			print '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
		}else{
			print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		
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
	print '<select id="#_#" class="form-control">';
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
	$labels = array();
	$data = array();
	
	$mysqli = connect();
	if($results = $mysqli->query(
			"SELECT p.id as id, pr.name as product, s.name as supplier, p.amount as amount, u.name as user
	 				FROM supplier s, pallet p, product pr, user u
				where pr.id=p.product_id and p.supplier_id = s.id and u.id = p.user_id 
				
				 and p.time >= CURDATE()  and p.deleted = false and pr.deleted = false order by supplier")){
	
		$str = '<table class="table table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Beszállító Neve</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Raktáros</th>';
		$str .= '</tr>';
		$str .= '</thead>';

		$i = false;
		while($row = $results->fetch_assoc()) {
			if(in_array($row["product"],$labels))
			{
				$key = array_search($row["product"],$labels);
				$data[$key] = $data[$key]+(int)$row["amount"];
			}else{
				array_push($labels,$row["product"]);
				array_push($data,(int)$row["amount"]);
			}

			$str .= '<tr>';
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["supplier"].'</td>';
			$str .= '<td>'.$row["amount"].'</td>';
			$str .= '<td>'.$row["user"].'</td>';
			$str .= '</tr>';
			$i = true;

		}
		$str .= '</table>';

/*
					 $str =  '<table class="table table-hover sortable">';
					 $str .= '<thead>';
					 $str .= '<tr>';
					 $str .= '<th>ID</th>';
					 $str .= '<th>Alapanyag</th>';
					 $str .= '<th>Mennyiség</th>';
					 $str .= '</tr>';
					 $str .= '</thead>';
					 $i = false;
					 while($row = $results->fetch_assoc()) {
					 	if(in_array($row["product"],$labels))
					 	{
					 		$key = array_search($row["product"],$labels);
					 		$data[$key] = $data[$key]+(int)$row["amount"];
					 	}else{
					 		array_push($labels,$row["product"]);
					 		array_push($data,(int)$row["amount"]);
					 	}
					 	$str .= '<tr>';
					 	$str .= '<td>'.$row["id"].'</td>';
					 	$str .= '<td>'.$row["product"].'</td>';
					 	$str .= '<td>'.$row["amount"].'</td>';
					 	$str .= '</tr>';
					 	$i =true;
					 }
					 print '</table>';
*/
	
					 if($i){
					 	print $str;
					 }
					 else{
					 	print('Ma még nem érkezett be semmi a raktárba');
					 }
	
					 $colors = array( 'rgba(255, 99, 132, 0.8)',
					 		'rgba(54, 162, 235, 0.8)',
					 		'rgba(255, 206, 86, 0.8)',
					 		'rgba(75, 192, 192, 0.8)',
					 		'rgba(153, 102, 255, 0.8)');
	
					 $backgroundColor = array();
					 for($i=0; $i < count($labels); $i++){
					 	$num = $i%count($colors);
					 	array_push($backgroundColor,$colors[$num]);
					 }
	
					 $hoverBackgroundColor = array();
					 for($i=0; $i < count($labels); $i++){
					 	$num = $i%count($colors);
					 	array_push($hoverBackgroundColor,$colors[$num]);
					 }
	
					 $datasets = array(
					 		"data" => $data,
					 		"backgroundColor" => $backgroundColor,
					 		"hoverBackgroundColor" => $hoverBackgroundColor
					 );
					 $datasetsarray = array($datasets);
					 $json = array(
					 		"labels" => $labels,
					 		"datasets" => $datasetsarray
					 );
	
					 $json_str = json_encode($json,True);
	
					 print '<div id="dailyInput_json" class="hiddendiv">'.$json_str.'</div>';
	
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
	$labels = array();
	$data = array();

	$mysqli = connect();
	if($results = $mysqli->query(
			
			"SELECT p.id as id, pr.name as product, p.amount as amount, o.time as time, u.name as user
 				FROM  pallet p, product pr, output o, user u
			where pr.id=p.product_id and o.pallet_id = p.id and p.user_id = u.id
			 and o.time >= CURDATE() and p.deleted = false and pr.deleted = false and o.deleted = false order by product")){
			 
		$str =  '<table class="table table-hover sortable">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>ID</th>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Kiadási idő</th>';
		$str .= '<th>Raktáros</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$i =false;
		
		while($row = $results->fetch_assoc()) {
			if(in_array($row["product"],$labels))
			{
				$key = array_search($row["product"],$labels);
				$data[$key] = $data[$key]+(int)$row["amount"];
			}else{
				array_push($labels,$row["product"]);
				array_push($data,(int)$row["amount"]);
			}
			$str .= '<tr>';

			$str .= '<td>'.$row["id"].'</td>';
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["amount"].'</td>';
			$str .= '<td>'.$row["time"].'</td>';
			$str .= '<td>'.$row["user"].'</td>';
			$str .= '</tr>';
			$i = true;
		}
		
		$str.= "</table>";
		 if($i){
		 	print $str;
		 		
		 }else{
		 	print ("Ma még semmmit nem adtak ki a raktárból");
		 }

				 $colors = array( 'rgba(255, 99, 132, 0.8)',
				 		'rgba(54, 162, 235, 0.8)',
				 		'rgba(255, 206, 86, 0.8)',
				 		'rgba(75, 192, 192, 0.8)',
				 		'rgba(153, 102, 255, 0.8)');


				 $backgroundColor = array();
				 for($i=0; $i < count($labels); $i++){
				 	$num = $i%count($colors);
				 	array_push($backgroundColor,$colors[$num]);
				 }

				 $hoverBackgroundColor = array();
				 for($i=0; $i < count($labels); $i++){
				 	$num = $i%count($colors);
				 	array_push($hoverBackgroundColor,$colors[$num]);
				 }

				 $datasets = array(
				 		"data" => $data,
				 		"backgroundColor" => $backgroundColor,
				 		"hoverBackgroundColor" => $hoverBackgroundColor
				 );
				 $datasetsarray = array($datasets);
				 $json = array(
				 		"labels" => $labels,
				 		"datasets" => $datasetsarray
				 );

				 $json_str = json_encode($json,True);

				 print '<div id="dailyOutput_json" class="hiddendiv">'.$json_str.'</div>';

				 $results->free();
	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}

	$mysqli->close();
}


function periodOutput($day,$last){
	$labels = array();
	$data = array();

	
	
	
	$mysqli = connect();
	if($results = $mysqli->query(

			"SELECT p.id as id, pr.name as product, p.amount as amount, o.time as time, u.name as user
 				FROM  pallet p, product pr, output o, user u
			where pr.id=p.product_id and o.pallet_id = p.id and p.user_id = u.id
			 and 
			o.time >= '".$day." 00:00:00' and
			o.time <= '".$last." 23:59:59' 
			and p.deleted = false and pr.deleted = false and o.deleted = false order by product")){

			 $str =  '<table class="table table-hover">';
			 $str .= '<thead>';
			 $str .= '<tr>';
			 $str .= '<th>'.$day." -> ".$last.'</th>';
			 $str .= '<th class="dateth">'.datepicker(true) .'</th>';
			 $str .= '<th><button class="btn btn-sm btn-default"  onclick="dailyOutput()">Napi Szűrés</button></th>';
			 $str .= '<th><button class="btn btn-sm btn-default"  onclick="monthlyOutput()">Havi Szűrés</button></th>';
			 $str .= '<th></th>';
			 $str .= '</tr>';
			 $str .= '<tr>';
			 $str .= '<th>ID</th>';
			 $str .= '<th>Alapanyag</th>';
			 $str .= '<th>Mennyiség</th>';
			 $str .= '<th>Kiadási idő</th>';
			 $str .= '<th>Raktáros</th>';
			 $str .= '</tr>';
			 $str .= '</thead>';
			 $i =false;
			 while($row = $results->fetch_assoc()) {
			 	if(in_array($row["product"],$labels))
			 	{
			 		$key = array_search($row["product"],$labels);
			 		$data[$key] = $data[$key]+(int)$row["amount"];
			 	}else{
			 		array_push($labels,$row["product"]);
			 		array_push($data,(int)$row["amount"]);
			 	}
			 	$str .= '<tr>';

			$str .= '<td>'.$row["id"].'</td>';
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["amount"].'</td>';
			$str .= '<td>'.$row["time"].'</td>';
			$str .= '<td>'.$row["user"].'</td>';
			 	

			 	$str .= '</tr>';
			 	$i =true;
			 }
			

			 if($i){
			 	$str .= '</table>';
			 	print $str;
			 		
			 }else{
			 	$str .= '<tr><td>Semmmit nem adtak ki a raktárból</td></tr>';
			 	$str .= '</table>';
			 	print $str;
			 	
			 }

			 $colors = array( 'rgba(255, 99, 132, 0.8)',
			 		'rgba(54, 162, 235, 0.8)',
			 		'rgba(255, 206, 86, 0.8)',
			 		'rgba(75, 192, 192, 0.8)',
			 		'rgba(153, 102, 255, 0.8)');

			 $backgroundColor = array();
			 for($i=0; $i < count($labels); $i++){
			 	$num = $i%count($colors);
			 	array_push($backgroundColor,$colors[$num]);
			 }

			 $hoverBackgroundColor = array();
			 for($i=0; $i < count($labels); $i++){
			 	$num = $i%count($colors);
			 	array_push($hoverBackgroundColor,$colors[$num]);
			 }

			 $datasets = array(
			 		"data" => $data,
			 		"backgroundColor" => $backgroundColor,
			 		"hoverBackgroundColor" => $hoverBackgroundColor
			 );
			 $datasetsarray = array($datasets);
			 $json = array(
			 		"labels" => $labels,
			 		"datasets" => $datasetsarray
			 );

			 $json_str = json_encode($json,True);

			 print '<div id="dailyOutput_json" class="hiddendiv">'.$json_str.'</div>';

			 $results->free();
	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}

	$mysqli->close();
}

function periodInput($day,$last){
	$labels = array();
	$data = array();

	
	
	$mysqli = connect();
	if($results = $mysqli->query(
			"SELECT p.id as id, pr.name as product, s.name as supplier, p.amount as amount, u.name as user
	 				FROM supplier s, pallet p, product pr, user u
				where pr.id=p.product_id and p.supplier_id = s.id and u.id = p.user_id
				 and  p.time >= '".$day." 00:00:00' and
			p.time <= '".$last." 23:59:59' 
			and p.deleted = false and pr.deleted = false order by supplier")){


				 $str = '<table class="table table-hover">';
				 $str .= '<thead>';
				 $str .= '<tr>';
				 $str .= '<th>'.$day." -> ".$last.'</th>';
				 $str .= '<th class="dateth">'.datepicker(true) .'</th>';
				 $str .= '<th><button class="btn btn-sm btn-default" onclick="dailyInput()">Napi Szűrés</button></th>';
				 $str .= '<th><button class="btn btn-sm btn-default"  onclick="monthlyInput()">Havi Szűrés</button></th>';
				
				 $str .= '</tr>';
				 $str .= '<tr>';
				 $str .= '<th>Alapanyag</th>';
				 $str .= '<th>Beszállító Neve</th>';
				 $str .= '<th>Mennyiség</th>';
				 $str .= '<th>Raktáros</th>';
				 $str .= '</tr>';
				 $str .= '</thead>';

				 $i = false;
				 while($row = $results->fetch_assoc()) {
				 	if(in_array($row["product"],$labels))
				 	{
				 		$key = array_search($row["product"],$labels);
				 		$data[$key] = $data[$key]+(int)$row["amount"];
				 	}else{
				 		array_push($labels,$row["product"]);
				 		array_push($data,(int)$row["amount"]);
				 	}

				 	$str .= '<tr>';
				 	$str .= '<td>'.$row["product"].'</td>';
				 	$str .= '<td>'.$row["supplier"].'</td>';
				 	$str .= '<td>'.$row["amount"].'</td>';
				 	$str .= '<td>'.$row["user"].'</td>';
				 	$str .= '</tr>';
				 	$i = true;

				 }
				 
				$str .= '</table>';

				if($i){
				 	$str .= '</table>';
				 	print $str;
			 		
				 }else{
				 	$str .= '<tr><td>Semmmit nem adtak ki a raktárból</td></tr>';
				 	$str .= '</table>';
				 	print $str;
				 	
				 }
				 
				 $colors = array( 'rgba(255, 99, 132, 0.8)',
				 		'rgba(54, 162, 235, 0.8)',
				 		'rgba(255, 206, 86, 0.8)',
				 		'rgba(75, 192, 192, 0.8)',
				 		'rgba(153, 102, 255, 0.8)');

				 $backgroundColor = array();
				 for($i=0; $i < count($labels); $i++){
				 	$num = $i%count($colors);
				 	array_push($backgroundColor,$colors[$num]);
				 }

				 $hoverBackgroundColor = array();
				 for($i=0; $i < count($labels); $i++){
				 	$num = $i%count($colors);
				 	array_push($hoverBackgroundColor,$colors[$num]);
				 }

				 $datasets = array(
				 		"data" => $data,
				 		"backgroundColor" => $backgroundColor,
				 		"hoverBackgroundColor" => $hoverBackgroundColor
				 );
				 $datasetsarray = array($datasets);
				 $json = array(
				 		"labels" => $labels,
				 		"datasets" => $datasetsarray
				 );

				 $json_str = json_encode($json,True);

				 print '<div id="dailyInput_json" class="hiddendiv">'.$json_str.'</div>';

				 // Frees the memory associated with a result
				 $results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function listOld(){
	$mysqli = connect();
	if($results = $mysqli->query(
				"SELECT p.id as a0, pr.name as a1, p.amount as a2, p.time as a3
	 			FROM  pallet p, product pr
				where pr.id=p.product_id
				and p.time < CURDATE() and p.deleted = false order by a3 ")){
	
		$str =  '<table class="table table-hover  sortable">';
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
	if($results = $mysqli->query("SELECT * from user where deleted = false")){
		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr>';
		print '<th>Felhasználó Név</th>';
		print '<th>Jogosultság</th>';
		print '<th>Szerkeszt</th>';
		print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createUser()">Új Felhasználó</button></th>';
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
			print '<td><button class="btn btn-sm btn-default" onclick="editUserName('.$row["id"].')">Név Szerkeszés</button></td>';
			print '<td><button class="btn btn-sm btn-default" onclick="editUserPass('.$row["id"].')">Új Jelszó</button></td>';
			print '<td><button class="btn btn-sm btn-danger" onclick="deleteUser('.$row["id"].')">Törlés</button></td>';
			print '</tr>';
		}
		print '</table>';
		// Frees the memory associated with a result
		$results->free();

	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}
	// close connection
	$mysqli->close();
}
?>