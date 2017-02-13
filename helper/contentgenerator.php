<?php
require('mysqli.php');
require('datepicker.php');

function getSupplies($id){
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL3(""," GROUP BY product "))){
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>';
		productOptionStorage($id);
		print 'Alapanyag név</th>';
		print '<th>Mennyiség</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
			print '<tr>';
			print '<td>'.$row["product"].'</td>';
			print '<td>'.$row["rest"].'</td>';
			print '</tr>';
		}
		print '</table>';
		
		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
}

function listForChart(){
	
	$labels = array();
	$data = array();
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL())){
			
			while($row = $results->fetch_assoc()) {
				if(in_array($row["product"],$labels))
				{
					$key = array_search($row["product"],$labels);
					$data[$key] = $data[$key]+(int)$row["rest"];
				}else{
					array_push($labels,$row["product"]);
					array_push($data,(int)$row["rest"]);
				}
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
			
			$results->free();
	}
	else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
}

function listStorage($id){
	
	if($id === ""){
		getSupplies($id);
		listForChart();
	}else{
		$filter  = "and pr.id = '".$id."' ";
	
		$labels = array();
		$data = array();
		$mysqli = connect();
		if($results = $mysqli->query(palletSQL2($filter))){
		
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>ID</th>';
		print '<th>';
		productOptionStorage($id);
		print 'Alapanyag név</th>';
		print '<th>Beszállító Neve</th>';
		print '<th>Beérkezés ideje</th>';
		print '<th>Mennyiség</th>';
		print '<th>Raktáros</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
			array_push($labels,$row["product"]);
			array_push($data,(int)$row["rest"]);
			
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
}

function listProduct(){
	$mysqli = connect();
	$results = $mysqli->query("SELECT p.id as id, p.name as name, p.minimum as minimum, c.name as cat FROM product p, category c WHERE c.id = p.category_id and p.deleted = false");
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';
	print '<th>Kategória</th>';
	print '<th>Jelzési Mennyiség</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createProduct()">Új alapanyag</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="alapkat_'.$row["id"].'">'.$row["cat"].'</td>';
		print '<td id="alapmin_'.$row["id"].'">'.$row["minimum"].'</td>';
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

function palletOutput($id){
	
	if($id === ""){
		$filter  = "";
	}else{
		$filter  = "and pr.id = '".$id."' ";
	}
	
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL2($filter))){

	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>';
	productOptionOutput($id);			
	print 'Alapanyag név';
	print '</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';
	$firstprods = array();
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		
		if(in_array($row["product"],$firstprods))
		{
			print '<td><button class="btn btn-sm btn-danger" onclick="olderOutput('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
		}else{
			print '<td><button class="btn btn-sm btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
			array_push($firstprods,$row["product"]);
		}
		
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

function palletSpare(){
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL())){
			
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

function productOptionStorage($filter){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM product where deleted = false order by name");
	print '<select id="prod_select" onchange="filterProd()" class="form-control">';
	
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

function productOptionOutput($filter){
	$mysqli = connect();
	$results = $mysqli->query("SELECT * FROM product where deleted = false order by name");
	print '<select id="prod_select" onchange="filterProdOutput()" class="form-control">';

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
			"SELECT p.id as id, pr.name as product, s.name as supplier, sum(p.amount) as amount
	 				FROM supplier s, pallet p, product pr
				where pr.id=p.product_id and p.supplier_id = s.id
				
				 and p.time >= CURDATE()  and p.deleted = false and pr.deleted = false 
			group by pr.id
			order by supplier")){
	
		$str = '<table class="table table-hover sortable">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Beszállító Neve</th>';
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
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["supplier"].'</td>';
			$str .= '<td>'.$row["amount"].'</td>';
			
			$str .= '</tr>';
			$i = true;

		}
		$str .= '</table>';
	
		 if($i){
		 	print $str;
		 }
		 else{
		 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Ma még nem érkezett be semmi a raktárba</strong></div>';
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
			
			"SELECT p.id as id, pr.name as product, sum(o.amount) as amount
 				FROM  pallet p, product pr, output o
			where pr.id=p.product_id and o.pallet_id = p.id 
			 and o.time >= CURDATE() and p.deleted = false and pr.deleted = false and o.deleted = false 
			group by pr.id order by product")){
			 
		$str =  '<table class="table table-hover sortable">';
		$str .= '<thead>';
		$str .= '<tr>';
		
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
	
		
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

			
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["amount"].'</td>';
			
			

			$str .= '</tr>';
			$i = true;
		}
		
			$str.= "</table>";
		 if($i){
		 	print $str;
		 		
		 }else{
		 	print ('<div class="alert alert-danger text-center centerBlock" role="alert" 
		 	style="width: 90%"><strong>Ma még semmmit nem adtak ki a raktárból</strong></div>');
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

function periodOutput($day,$last,$detail){

	$labels = array();
	$data = array();

	if($detail){
		$groupby = "";
	}else{
		$groupby = " group by pr.id ";
	}
	
	
	$mysqli = connect();
	if($results = $mysqli->query(

			"SELECT p.id as id, pr.name as product, o.amount as amount, o.time as time, u.name as user,o.id as o_id
 				FROM  pallet p, product pr, output o, user u
			where pr.id=p.product_id and o.pallet_id = p.id and o.user_id = u.id
			 and 
			o.time >= '".$day." 00:00:00' and
			o.time <= '".$last." 23:59:59' 
			and p.deleted = false and pr.deleted = false and o.deleted = false ".$groupby." order by product")){

			 $str =  '<table class="table table-hover">';
			 $str .= '<thead>';
			 $str .= '<tr>';
			 
			 if($detail){
			 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></th>';
			 }else{
			 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" ></th>';
			 }
			 
			 
			 $str .= '<th class="dateth">'.datepicker(true) .'</th>';

			 $str .= '<th><button class="btn btn-sm btn-default"  onclick="dailyOutput()">Napi Szűrés</button></th>';
			 $str .= '<th><button class="btn btn-sm btn-default"  onclick="monthlyOutput()">Havi Szűrés</button></th>';

			 $str .= '<th></th>';
			 $str .= '<th></th>';
			 $str .= '</tr>';
			 $str .= '<tr>';
			 $str .= '<th>Kiadás ID</th>';
			 $str .= '<th>Raklap ID</th>';
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
			 
				$str .= '<td>'.$row["o_id"].'</td>';
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
			 	$str .= '</table>';
			 	print $str;
			 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
			 	
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

function periodSpare($day,$last,$detail){

	$labels = array();
	$data = array();

	if($detail){
		$groupby = "";
	}else{
		$groupby = " group by pr.id ";
	}
	

	$mysqli = connect();
	if($results = $mysqli->query(

			"SELECT p.id as id, pr.name as product, t.amount as amount, t.time as time, u.name as user
 				FROM  pallet p, product pr, trash t, user u
			where pr.id=p.product_id and t.pallet_id = p.id and t.user_id = u.id
			 and
			t.time >= '".$day." 00:00:00' and
			t.time <= '".$last." 23:59:59'
			and p.deleted = false and pr.deleted = false and t.deleted = false 
			".$groupby." order by product")){

			$str =  '<table class="table table-hover">';
			$str .= '<thead>';
			$str .= '<tr>';
				
			if($detail){
			 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></th>';
			 }else{
			 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" ></th>';
			 }
			
			$str .= '<th class="dateth">'.datepicker(true) .'</th>';

			$str .= '<th><button class="btn btn-sm btn-default"  onclick="dailySpare()">Napi Szűrés</button></th>';
			$str .= '<th><button class="btn btn-sm btn-default"  onclick="monthlySpare()">Havi Szűrés</button></th>';

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
				$str .= '</table>';
				print $str;
				print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
					
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

function periodInput($day,$last,$detail){
	$labels = array();
	$data = array();

	if($detail){
		$groupby = "";
	}else{
		$groupby = " group by pr.id ";
	}
	
	$mysqli = connect();
	if($results = $mysqli->query(
			"SELECT p.id as id, pr.name as product, s.name as supplier, p.amount as amount, u.name as user
	 				FROM supplier s, pallet p, product pr, user u
				where pr.id=p.product_id and p.supplier_id = s.id and u.id = p.user_id
				 and  p.time >= '".$day." 00:00:00' and
			p.time <= '".$last." 23:59:59' 
			and p.deleted = false and pr.deleted = false ".$groupby." order by supplier")){


				 $str = '<table class="table table-hover">';
				 $str .= '<thead>';
				 $str .= '<tr>';
				 if($detail){
				 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></th>';
				 }else{
				 	$str .= '<th>'.$day." -> ".$last.' Részletes<input id="detailscb" type="checkbox" name="detailscb" ></th>';
				 }
				 
				 $str .= '<th class="dateth">'.datepicker(true).'</th>';

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
				 	$str .= '</table>';
				 	print $str;
				 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Ma még semmmit nem adtak ki a raktárból!</strong></div>';
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
			print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Nincs lejáró termék</strong></div>';
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

function alertOutput(){
	
	$mysqli = connect();
	$results = $mysqli->query("SELECT a.id, a.type, a.param, a.param2, a.time, u.name, a.seen from alert a, user u where u.id = a.user_id and a.deleted = false and a.type='output' order by time desc ");
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Kiadás id</th>';
	print '<th>Raklap id</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		print '<td>'.$row["param2"].'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> OK </td>';
		}
		
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function alertSpare(){

	$mysqli = connect();
	$results = $mysqli->query("SELECT a.id, a.type, a.param, a.param2, a.time, u.name, a.seen from alert a, user u where u.id = a.user_id and a.deleted = false and a.type='trash' order by time desc ");
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Selejt id</th>';
	print '<th>Raklap id</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		print '<td>'.$row["param2"].'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		if($row["seen"] == '0' ){
		print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> </td>';
		}
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function alertInput(){

	$mysqli = connect();
	$results = $mysqli->query("SELECT a.id, a.type, a.param, a.param2, a.time, u.name, a.seen from alert a, user u where u.id = a.user_id and a.deleted = false and a.type='input' order by time desc ");
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Minőség id</th>';
	print '<th>Hibák</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		$data = json_decode($row["param2"],True);
		print '<td>';
		if($data != null){
			foreach ($data as $i => $value) {
					
				if(is_numeric($value) && (2 == (int)$value || 1 == (int)$value) && $i != 'product'){
					print minosegmap2($i).' => '.minosegmap((int)$value).'<br/>';
				}
			}
		}		
		print '</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> </td>';
		}
		print '</tr>';
	}
	print '</table>';
	// Frees the memory associated with a result
	$results->free();
	// close connection
	$mysqli->close();
}

function minosegmap($i){
	if($i === 1){
		return "Rossz";
	}else if($i === 2){
		return "Közepes";
	}else if($i === 3){
		return "OK";
	}else{
		return '';
	}
}
function minosegmap2($i){
	if($i === "appearance"){
		return "Kinézet";
	}else if($i === "consistency"){
		return "Állag";
	}else if($i === "smell"){
		return "Illat";
	}else if($i === "color"){
		return "Szín";
	}else if($i === "clearness"){
		return "Tisztaság Hőfok";
	}else if($i === "pallet_quality"){
		return "Raklap minőság";
	}else{
		return '';
	}
}


function inputStatistic($weekday,$day,$day2){
	
	$mysqli = connect();
	if($results = $mysqli->query(
			
			
			
			"SELECT pr.name as product, sum(p.amount) as amount 
			FROM pallet p, product pr where pr.id=p.product_id and
				p.time >= '".$day2." 00:00:00' 
			and p.time <= '".$day." 23:59:59' and 
			WEEKDAY(p.time) = '".$weekday."' and 
			 p.deleted = false and pr.deleted = false
			 group by product order by p.product_id ")){
		$str =  '<table class="table table-hover ">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Nap: '.daymap($weekday).'</th>';
		$str .= '<th>'.daypicker().'</th>';
		$str .= '</tr>';
		$str .= '<tr>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';	
		$str .= '</tr>';
		$str .= '</thead>';
		while($row = $results->fetch_assoc()) {
			$str.= '<tr>';
	
			$str.= '<td>'.$row["product"].'</td>';
			$str.= '<td>'.$row["amount"].'</td>';
	
			$str.= '</tr>';
		}
		$str.= '</table>';
		print $str;
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
}

function outputStatistic($weekday){
	$data = array();
	print '<table class="table">';
	
	for($i=1; $i<=4; $i++){
		if($i==1 || $i == 3)
			print '<tr>';
		print '<td>';
		$back = $i*7-1-6;
		$day = date('Y-m-d', strtotime("-".$back." days"));
		$back = $i*7-1;
		$day2 = date('Y-m-d', strtotime("-".$back." days"));
		
		$mysqli = connect();
		if($results = $mysqli->query(
				"SELECT pr.name as product, sum(o.amount) as amount
			FROM pallet p, product pr, output o where pr.id=p.product_id and o.pallet_id = p.id and
				o.time >= '".$day2." 00:00:00'
			and o.time <= '".$day." 23:59:59' and
			WEEKDAY(o.time) = '".$weekday."' and
			 p.deleted = false and pr.deleted = false and
			o.deleted = false group by product order by p.product_id ")){
					$str =  '<table class="table table-hover ">';
					$str .= '<thead>';
					$str .= '<tr>';
					$str .= '<th>'.$day2.' -> '.$day.'</th>';
					$str .= '<th>'.daymap($weekday).'</th>';
					
					$str .= '</tr>';
					$str .= '<tr>';
					$str .= '<th>Alapanyag</th>';
					$str .= '<th>Mennyiség</th>';
					$str .= '</tr>';
					$str .= '</thead>';
					while($row = $results->fetch_assoc()) {
						$prod = $row["product"];
						if(array_key_exists($prod,$data))
						{							
							$data[$prod] = $data[$prod]+(int)$row["amount"];
						}else{
							$data[$prod] = $row["amount"];
						}
						$str.= '<tr>';
		
						$str.= '<td>'.$row["product"].'</td>';
						$str.= '<td>'.$row["amount"].'</td>';
		
						$str.= '</tr>';
					}
					$str.= '</table>';
					print $str;
		}else{
			print "hiba";
			print mysqli_error($mysqli);
		}	
		
		
		print '</td>';
		if($i==2 || $i == 4)
			print '</tr>';
			
	}
	print '</table>';
//ÖSSZEGZŐ
	print '<br/>';
	print '<hr/>';
	print '<div class="statisticsdiv"><h2>Átlag</h2></div>';
	
	$str =  '<table class="table table-hover ">';
	$str .= '<thead>';
	$str .= '<tr>';
	$str .= '<th>'.$day2.' -> '.$day.'</th>';
	$str .= '<th>'.daymap($weekday).'</th>';
		
	$str .= '</tr>';
	$str .= '<tr>';
	$str .= '<th>Alapanyag</th>';
	$str .= '<th>Mennyiség</th>';
	$str .= '</tr>';
	$str .= '</thead>';
		foreach ($data as $key => $value) {		 	
			$average = $value / 4;
			$str.= '<tr>';
			
			$str.= '<td>'.$key.'</td>';
			$str.= '<td>'.$average.'</td>';
			
			$str.= '</tr>';
		}
	$str.= '</table>';
	print $str;
	
}



function daymap($weekday){
	if($weekday == "0"){
		return "Hétfő";
	}else if($weekday == "1"){
		return "Kedd";
	}else if($weekday == "2"){
		return "Szerda";
	}else if($weekday == "3"){
		return "Csütörtök";
	}else if($weekday == "4"){
		return "Péntek";
	}else if($weekday == "5"){
		return "Szombat";
	}else if($weekday == "6"){
		return "Vasárnap";
	}
}


function inventory(){
	$mysqli = connect();
		if($results = $mysqli->query(palletSQL())){

				print '<table class="table table-hover sortable">';
				print '<thead>';
				print '<tr>';
				print '<th>ID</th>';
				print '<th>';

				print 'Alapanyag név</th>';
				print '<th>Beszállító Neve</th>';
				print '<th>Beérkezés ideje</th>';
				print '<th>Mennyiség</th>';
				print '<th>Raktáros</th>';
				print '<th>Módosít</th>';
				print '<th>Töröl</th>';
				print '</tr>';
				print '</thead>';
				while($row = $results->fetch_assoc()) {
					
						
					print '<tr>';
					print '<td>'.$row["id"].'</td>';
					print '<td>'.$row["product"].'</td>';
					print '<td>'.$row["supplier"].'</td>';
					print '<td>'.$row["time"].'</td>';
					print '<td>'.$row["rest"].'</td>';
					print '<td>'.$row["user"].'</td>';
					print '<td><button class="btn btn-sm btn-default" onclick="inventory_update('.$row["id"].','.$row["rest"].')">Szerkeszt</button></td>';
					print '<td><button class="btn btn-sm btn-danger" onclick="deletePallet('.$row["id"].')">Töröl</button></td>';
					print '</tr>';
				}
				print '</table>';

				// Frees the memory associated with a result
				$results->free();

		}else{
			print mysqli_error($mysqli);
			print "hiba";
		}
		// close connection
		$mysqli->close();
	
}



function palletSQL(){
	return palletSQL2(""); 
}

function palletSQL2($filter){
	return palletSQL3($filter,"");
}


function palletSQL3($filter,$groupby){
	
	
	return "select p.id as id, pr.name as product, s.name as supplier, p.time as time, u.name as user,pr.minimum as min,
				IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest
				from pallet p 
				INNER JOIN product pr on p.product_id = pr.id ".$filter." and p.deleted = false  
				INNER JOIN supplier s on s.id = p.supplier_id
				INNER JOIN user u on u.id = p.user_id
				LEFT JOIN (
	    			select t2.id as id ,t3.amount as trash,t2.amount as output from
					(
			           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
			        )t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
		        )t3
				ON t2.id = t3.id
				UNION
				select t2.id as id ,t2.amount as trash,t3.amount as output from
				(
	             	SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false group by pallet_id
	        	)t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false group by pallet_id
		        )t3
				ON t2.id = t3.id
	 			) t1
	 			on p.id = t1.id 
						".$groupby."
						HAVING rest > 0 
						order by product, time";
	
	//TODO deleted pallet!!!
}
	



function outOfStock(){
	
	
	
	$SQL = str_replace("HAVING rest > 0","HAVING rest < min and rest > 0",palletSQL3(""," GROUP BY product "));
	$mysqli = connect();
	if($results = $mysqli->query($SQL)){
	
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>ID</th>';
		print '<th>';	
		print 'Alapanyag név</th>';
		print '<th>Jelzés szint</th>';
		print '<th>Mennyiség</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
				
	
			print '<tr>';
			print '<td>'.$row["id"].'</td>';
			print '<td>'.$row["product"].'</td>';
			print '<td>'.$row["min"].'</td>';
			print '<td>'.$row["rest"].'</td>';
			print '</tr>';
		}
		print '</table>';
	
		// Frees the memory associated with a result
		$results->free();
	
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
	
}

?>


