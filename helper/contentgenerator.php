<?php
require('mysqli.php');
require('datepicker.php');

//***SQL EXECUTERS***///

function sqlExecute($sql,$proces){
	$mysqli = connect();
	if($results = $mysqli->query($sql)){

		$proces($results);

		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	$mysqli->close();
}

function sqlExecute2($sql,$proces,$param){
	$mysqli = connect();
	if($results = $mysqli->query($sql)){

		$proces($results,$param);

		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	$mysqli->close();
}

//** REST PALLET LISTING SQL QUERY**//

function palletSQL(){
	return palletSQL2("");
}

function palletSQL2($filter){
	return palletSQL3($filter,"");
}

function palletSQL3($filter,$groupby){

	if($groupby == ""){
		$sum1="";
		$sum2="";
	}else{
		$sum1="sum(";
		$sum2=")";

	}
	return "select p.id as id, pr.name as product, pr.id as pr_id, s.name as supplier, p.time as time, u.name as user,pr.minimum as min,
				".$sum1."IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0)".$sum2." as rest
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

}


//** OTHER FUNCTIONS **//

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
			 $str .= '<tr class="tableHeader">';
			 
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
			 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 80%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
			 	
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
			$str .= '<tr class="tableHeader">';
				
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
				print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 80%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
					
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
				 $str .= '<tr class="tableHeader">';
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
				 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 80%"><strong>Ma még semmmit nem adtak ki a raktárból!</strong></div>';
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
	$prod_exp = array();
	if($results = $mysqli->query("SELECT id,expire,name from product where deleted = false and expire > 0")){
		while($row = $results->fetch_assoc()) {
			$prod_exp[$row["id"]] = $row["expire"];
		}
		$results->free();
	}
	if($results = $mysqli->query(palletSQL())){
		
		$str =  '<table class="table table-hover  sortable">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>RAKLAP ID</th>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Bevétel ideje</th>';
		$str .= '<th>Kalkulált Lejárat</th>';
		$str .= '<th>Lejárt </th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$i = false;

		while($row = $results->fetch_assoc()) {
			
			if(array_key_exists($row["pr_id"],$prod_exp)){
				
				$expday = $prod_exp[$row["pr_id"]];
				$date = date("Y-m-d",strtotime($row["time"]));
				$expireDate = date('Y-m-d',strtotime($date . "+".$expday." days"));
				//$expireDate = date("Y-m-d",date( strtotime("+".$expday." days"),$date));
				$today = date("Y-m-d");
				if($today > $expireDate) {
					
					$timediff = strtotime($today)-strtotime($expireDate);
					$daydiff = floor($timediff / (60 * 60 * 24));
					
					$str .= '<tr>';
					$str .= '<td>'.$row["id"].'</td>';
					$str .= '<td>'.$row["product"].'</td>';
					$str .= '<td>'.$row["rest"].'</td>';
					$str .= '<td>'.$row["time"].'</td>';
					$str .= '<td>'.$expireDate.'</td>';
					$str .= '<td>'.$daydiff.' napja</td>';
					$str .= '</tr>';
					$i = true;
				}				
			}

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
		$str .= '<th>'.daypicker($weekday).'</th>';
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
	
	print '<thead><tr class="tableTitle"><th>Napi Statisztikák</th><th></th></tr></thead>';
	
	print '<tr>';
	print '<td>';
	print daypicker($weekday);
	print '</td>';
	print '</tr>';
	
	
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
					$str .= '<tr class="tableHeader">';
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
	print '<hr style="width:90%">';
	
	$str =  '<table class="table table-hover ">';
	$str .= '<thead><tr class="tableTitle"><th>Átlag</th></tr></thead>';
	$str .= '<thead>';
	$str .= '<tr class="tableHeader">';
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
	$str .= '</table>';
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


////***OPTION FIELDS***////

function supplierOption(){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM supplier WHERE deleted = false order by name")){
		print '<select id="besz" class="form-control tabletForm">';
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
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="alap" class="form-control tabletForm">';
		while($row = $results->fetch_assoc()) {
			print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';

		// Frees the memory associated with a result
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionStorage($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="prod_select" onchange="filterProd() style="width: 130%;"" class="form-control">';

		print '<option  value=""> Összes </option>';
		while($row = $results->fetch_assoc()) {
			if($filter === $row["id"]){
				print '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
			}else{
				print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
			}
				
		}
		print '</select>';

		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionOutput($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="prod_select" onchange="filterProdOutput()" class="form-control tabletForm">';

		print '<option  value=""> Összes </option>';
		while($row = $results->fetch_assoc()) {
			if($filter === $row["id"]){
				print '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
			}else{
				print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
			}

		}
		print '</select>';
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}

	$mysqli->close();
}

function categoryOption(){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM category where deleted = false order by name")){
		print '<select id="#_#" class="form-control">';
		while($row = $results->fetch_assoc()) {
			print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';

		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function getDataById($id){
	$mysqli = connect();
	$pr_id = 0;	
	if($results = $mysqli->query("SELECT product_id as pid FROM pallet where id = ".$id)){
		while($row = $results->fetch_assoc()) {
			$pr_id = $row["pid"];			
		}
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	
	if($pr_id == 0){
		print '<h1>NINCS ILYEN RAKLAP VAGY TÖRÖLVE LETT</h1>';
		return;
	}
	
	$filter  = "and pr.id = '".$pr_id."' ";	
	
	if($results = $mysqli->query(palletSQL2($filter))){
		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr>';
		print '<th style="text-align:center;">ID</th>';
		print '<th style="text-align:center;">Alapanyag</th>';
		print '<th style="text-align:center;">Mennyiség</th>';
		print '<th style="text-align:center;">Beszállító</th>';
		print '<th style="text-align:center;">Idő</th>';
		print '</tr>';
		print '</thead>';
		$firstprods = array();
		while($row = $results->fetch_assoc()) {
			$str = '<tr>';
			$str .= '<td>'.$row["id"].'</td>';
			$str .= '<td>'.$row["product"].'</td>';
			$str .= '<td>'.$row["rest"].'</td>';
			$str .= '<td>'.$row["supplier"].'</td>';
			$str .= '<td>'.$row["time"].'</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			
			if(in_array($row["product"],$firstprods))
			{
				$str .= '<td colspan="2"><button class="btn btn-lg btn-danger" onclick="olderOutput('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
			}else{
				$str .= '<td colspan="2"><button class="btn btn-lg btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
				array_push($firstprods,$row["product"]);
			}			
			
			$str .= '<td colspan="2"><button class="btn btn-lg btn-danger" onclick="trash('.$row["id"].','.$row["rest"].')">Selejt</button></td>';
			$str .= '<td><button class="btn btn-lg btn-danger" onclick="deletePallet('.$row["id"].')">Töröl</button></td>';
			$str .= '</tr>';
			$str .= '</table>';
			
			if($row["id"] == $id){
				print $str;
				break;
			}
			
		}
		$results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	
	// close connection
	$mysqli->close();
}



?>