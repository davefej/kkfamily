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
		print "nincs adatbázis kapcsolat";
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

function sqlExecute3($sql,$proces,$param, $param2){
	$mysqli = connect();
	if($results = $mysqli->query($sql)){

		$proces($results,$param, $param2);

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
	return "select p.id as id, pr.name as product, pr.id as pr_id,pr.unit as unit,
			s.name as supplier, p.time as time,p.expire as expire, u.name as user,".$sum1."p.amount".$sum2." as origamount, pr.minimum as min, p.printed as printed,
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

function periodOutput($from,$to,$detail){
	$jsonarray = array();
	

	if($detail){
		$sql = "SELECT p.id as id, pr.name as product,pr.unit as unit, o.amount as amount, o.time as time,
				u.name as user,o.id as o_id,p.time as origtime, s.name as supp, o.id as oid
 				FROM  pallet p, product pr, output o, user u, supplier s 
			where pr.id=p.product_id and o.pallet_id = p.id and o.user_id = u.id
			 and s.id = p.supplier_id and
			o.time >= '".$from." 00:00:00' and
			o.time <= '".$to." 23:59:59' 
			and p.deleted = false and pr.deleted = false and o.deleted = false order by product";
	}else{
		$sql = "SELECT p.id as id, pr.name as product,pr.unit as unit, sum(o.amount) as amount, o.time as time,
				u.name as user,o.id as o_id,p.time as origtime, s.name as supp 
 				FROM  pallet p, product pr, output o, user u,  supplier s 
			where pr.id=p.product_id and o.pallet_id = p.id and o.user_id = u.id
			 and s.id = p.supplier_id and
			o.time >= '".$from." 00:00:00' and
			o.time <= '".$to." 23:59:59'
			and p.deleted = false and pr.deleted = false and o.deleted = false group by pr.id order by product";
		
	}
	
	
	$mysqli = connect();
	if($results = $mysqli->query(
			$sql
			)){

			 $str =  '<table class="table table-hover">';
			 $str .= '<thead>';
			 $str .= '<tr class="tableHeader">';
		
			 $str .= '<th colspan=2>'.$from." <br> ".$to.'</th>';
			 	
			 $str .= '<th class="dateth">'.mydatepicker($from, "_from")."<br/>".mydatepicker($to, "_to").'</th>';
			 
			 $str .= '<th><button class="btn btn-sm btn-default"  onclick="outputfilter()">Szűrés</button></th>';
			 
			 
			 if($detail){
			 	$str .= '<th>Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></th>';
			 }else{
			 	$str .= '<th> Részletes<input id="detailscb" type="checkbox" name="detailscb" ></th>';
			 }
			 $str .= '<th><button class="btn btn-sm btn-default printbutton" onclick="outputPrint()">
			 		<button class="btn btn-sm btn-default csvbutton" onclick="outputCSV()"></th>';
			 
			 $str .= '</tr>';
			 $str .= '</thead>';
			 $str .= '</table>';
			 
			 $str .=  '<table class="table table-hover sortable">';
			 $str .= '</thead>';
			 $str .= '<tr>';
			 if($detail){
				 $str .= '<th>Raklap ID</th>';
			 }
			 $str .= '<th>Alapanyag</th>';
			 if($detail){
				 $str .= '<th>Beszállítás ideje</th>';
				 $str .= '<th>Beszállító</th>';
				 $str .= '<th>Kiadási idő</th>';
			 }
			 $str .= '<th>Mennyiség</th>';
			 $str .= '<th>Mértékegység</th>';
			 if($detail){
			 	$str .= '<th>Raktáros</th>';
			
			 	$str .= '<th>Törlés</th>';
			 }
			 $str .= '</tr>';
			 $str .= '</thead>';
			 $i =false;
			 while($row = $results->fetch_assoc()) {
			 	$arritem = array();
			 	$arritem['termék'] =$row["product"];
			 	$arritem['mennyiség'] = $row["amount"];
			 	$arritem['egység'] =$row["unit"];
			 	if($detail){
			 		$arritem['bevétel'] = $row["origtime"];
			 		$arritem['beszállító'] = $row["supp"];
			 		$arritem['kiadás'] = $row["time"];
			 	}
			 	array_push($jsonarray, $arritem);
			 	
			 	$str .= '<tr>';
				
			 	if($detail){
					$str .= '<td>'.$row["id"].'</td>';
			 	}
				$str .= '<td>'.$row["product"].'</td>';
				if($detail){
					$str .= '<td>'.$row["origtime"].'</td>';
					$str .= '<td>'.$row["supp"].'</td>';
					$str .= '<td>'.$row["time"].'</td>';
				}
				$str .= '<td>'.$row["amount"].'</td>';
				$str .= '<td>'.$row["unit"].'</td>';
				if($detail){
					$str .= '<td>'.$row["user"].'</td>';	
					$str .= '<td><button class="btn btn-sm btn-danger" onclick="deleteOutput('.$row["oid"].')">Visszavonás</button></td>';
				}
			 	$str .= '</tr>';
			 	$i =true;
		 	}
			
			 if($i){
			 	$str .= '</table>';
			 	print $str;
			 		
			 }else{
			 	$str .= '</table>';
			 	print $str;
			 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 85%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
			 	
			 }
		 
			
			 $title = "Kiadás ".$from."-tól ".$to."-ig";
			 $json_str = json_encode($jsonarray,True);
			 print '<div id="printhelper_json" class="hiddendiv" detail="'.strval($detail).'"
				 		title="'.$title.'">'.$json_str.'</div>';

			 $results->free();
	}else{
		print mysqli_error($mysqli);
		print ("nincs adatbázis kapcsolat");
	}

	$mysqli->close();
}

function periodSpare($from,$to,$detail){
	$jsonarray = array();
	

	if($detail){
		
		$SQL = "SELECT p.id as id, pr.name as product,pr.unit as unit,  t.amount as amount, 
				t.time as time, u.name as user, s.name as sname, p.time as origtime
 				FROM  pallet p, product pr, trash t, user u, supplier s
			where pr.id=p.product_id and t.pallet_id = p.id and t.user_id = u.id
			 and s.id = p.supplier_id and
			t.time >= '".$from." 00:00:00' and
			t.time <= '".$to." 23:59:59'
			and p.deleted = false and pr.deleted = false and t.deleted = false 
			 order by product";
	}else{
		$SQL ="SELECT p.id as id, pr.name as product,pr.unit as unit,  t.amount as amount, t.time as time, u.name as user
 				FROM  pallet p, product pr, trash t, user u
			where pr.id=p.product_id and t.pallet_id = p.id and t.user_id = u.id
			 and
			t.time >= '".$from." 00:00:00' and
			t.time <= '".$to." 23:59:59'
			and p.deleted = false and pr.deleted = false and t.deleted = false
			group by pr.id  order by product";
	}
	

	$mysqli = connect();
	if($results = $mysqli->query($SQL)){

			$str =  '<table class="table table-hover">';
			$str .= '<thead>';
			$str .= '<tr class="tableHeader">';
				
			$str .= '<th>'.$from." <br> ".$to.'</th>';
		
				
			$str .= '<th class="dateth" colspan="4">'.mydatepicker($from, "_from")."<br/>".mydatepicker($to, "_to").'</th>';
			
			$str .= '<th><button class="btn btn-sm btn-default"  onclick="sparefilter()">Szűrés</button></th>';
			
			
			if($detail){
				$str .= '<th>Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></th>';
			}else{
				$str .= '<th> Részletes<input id="detailscb" type="checkbox" name="detailscb" ></th>';	
			}
			$str .= '<th><button class="btn btn-sm btn-default printbutton" onclick="sparePrint()">
					<button class="btn btn-sm btn-default csvbutton" onclick="spareCSV()"></th>';
				
			if($detail){
				
				$str .= '<th></th>';
			}
			
			$str .= '</tr>';
			$str .= '<tr>';
			if($detail){
				$str .= '<th>Raklap ID</th>';
			}
			
			if(!$detail){
				$colspan = "colspan='3'";
			}else{
				$colspan = "";
			}
			
			$str .= '<th '.$colspan.'>Alapanyag</th>';
			$str .= '<th '.$colspan.'>Mennyiség</th>';
			$str .= '<th '.$colspan.'>Mértékegység</th>';
			
			if($detail){
				$str .= '<th>Beszállító neve</th>';
				$str .= '<th>Beszállítás dátuma</th>';
				$str .= '<th>Selejtezési idő</th>';
				$str .= '<th colspan=2>Raktáros</th>';
			}
			
			
			$str .= '</tr>';
			$str .= '</thead>';
			$i =false;
			while($row = $results->fetch_assoc()) {
				$arritem = array();
				$arritem['termék'] =$row["product"];
				$arritem['mennyiség'] = $row["amount"];
				$arritem['egység'] = $row["unit"];
				
				if($detail){
					$arritem['bevétel'] = $row["origtime"];
					$arritem['beszállító'] = $row["sname"];
					$arritem['selejt'] = $row["time"];
				}
				array_push($jsonarray, $arritem);
				$str .= '<tr>';
				
				if($detail){
					$str .= '<td>'.$row["id"].'</td>';
				}
				$str .= '<td '.$colspan.'>'.$row["product"].'</td>';
				$str .= '<td '.$colspan.'>'.$row["amount"].'</td>';
				$str .= '<td '.$colspan.'>'.$row["unit"].'</td>';
				if($detail){
					$str .= '<td>'.$row["sname"].'</td>';
					$str .= '<td>'.$row["origtime"].'</td>';
					$str .= '<td>'.$row["time"].'</td>';
					$str .= '<td>'.$row["user"].'</td>';
				}
				
				
					

				$str .= '</tr>';
				$i =true;
			}
				

			if($i){
				$str .= '</table>';
				print $str;

			}else{
				$str .= '</table>';
				print $str;
				print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 85%"><strong>Semmmit nem adtak ki a raktárból!</strong></div>';
					
			}
		
			$title = "Selejt ".$from."-tól ".$to."-ig";
			
			$json_str = json_encode($jsonarray,True);
			print '<div id="printhelper_json" class="hiddendiv" detail="'.strval($detail).'"
				 		title="'.$title.'">'.$json_str.'</div>';

			$results->free();
	}else{
		print mysqli_error($mysqli);
		print ("nincs adatbázis kapcsolat");
	}

	$mysqli->close();
}

function periodInput($from,$to,$detail,$supp){
	
	$jsonarray = array();
	if($supp != ""){
		$supp_filter = "and s.id = '".$supp."' ";
	}else{
		$supp_filter = "";
	}
	
	if($detail){
		
		$sql = "SELECT p.id as id, pr.name as product,pr.unit as unit, s.name as supplier, p.amount as amount, p.expire as expire, u.name as user, p.time as time
	 				FROM supplier s, pallet p, product pr, user u
				where pr.id=p.product_id and p.supplier_id = s.id 
				and u.id = p.user_id ".$supp_filter."
				 and  p.time >= '".$from." 00:00:00' and
			p.time <= '".$to." 23:59:59' 
			and p.deleted = false and pr.deleted = false order by supplier";
	}else{
		
		$sql = "SELECT p.id as id, pr.name as product,pr.unit as unit, s.name as supplier, sum(p.amount) as amount, u.name as user
	 				FROM supplier s, pallet p, product pr, user u
				where pr.id=p.product_id and p.supplier_id = s.id 
				and u.id = p.user_id ".$supp_filter."
				 and  p.time >= '".$from." 00:00:00' and
			p.time <= '".$to." 23:59:59'
			and p.deleted = false and pr.deleted = false group by pr.id order by supplier";
		
	}
	
	$mysqli = connect();
	if($results = $mysqli->query($sql
			)){


				 $str = '<table class="table table-hover">';
				 $str .= '<thead>';
				 $str .= '<tr class="tableHeader">';
			 	 $str .= '<td>'.$from." <br> ".$to.'</td>';
				 
				 
				 
				 
				 $str .= '<td class="dateth">'.mydatepicker($from, "_from")."<br/>".mydatepicker($to, "_to").'</td>';

				 $str .= '<td>'.supplierOption2($supp);
				 $str .= '<button class="btn btn-sm btn-default"  onclick="inputfilter()">Szűrés</button></td>';
				 if($detail){
				 	$str .= '<td>Részletes<input id="detailscb" type="checkbox" name="detailscb" checked></td>';
				 }else{
				 	$str .= '<td>Részletes<input id="detailscb" type="checkbox" name="detailscb" ></td>';
				 }
				 $str .= '<td> <button class="btn btn-sm btn-default printbutton" onclick="inputPrint()">
				 		<button class="btn btn-sm btn-default csvbutton" onclick="inputCSV()"></td>';
				
				
				 
				 $str .= '</tr>';
				 $str .= '</thead>';
				 $str .= '</table>';
				 $str .= '<table class="table table-hover sortable">';
				 $str .= '<thead>';
				 $str .= '<tr>';
				 if($detail){
				 	$str .= '<th>Raklap ID</th>';
				 	
				 }
				 $str .= '<th colspan=2>Alapanyag</th>';		 
				 $str .= '<th>Mennyiség</th>';
				 $str .= '<th>Mértékegység</th>';
				 if($detail){
				 	$str .= '<th>Beszállító Neve</th>';
				 	$str .= '<th>Bevétel ideje</th>';
				 	$str .= '<th>Szav idő</th>';
				 	$str .= '<th>Raktáros</th>';
				 }
				
				 $str .= '</tr>';
				 $str .= '</thead>';

				 $i = false;
				 while($row = $results->fetch_assoc()) {
				 	$arritem = array();
				 	$arritem['termék'] =$row["product"];
				 	$arritem['mennyiség'] = $row["amount"];
				 	$arritem['egység'] = $row["unit"];
				 	if($detail){
					 	$arritem['bevétel'] = $row["time"];
					 	$arritem['beszállító'] = $row["supplier"];
				 	}
				 	array_push($jsonarray, $arritem);
				 	$str .= '<tr>';
				 	if($detail){
				 		$str .= '<td>'.$row["id"].'</td>';
				 	}
				 	$str .= '<td colspan=2>'.$row["product"].'</td>';
				 	$str .= '<td>'.$row["amount"].'</td>';
				 	$str .= '<td>'.$row["unit"].'</td>';
				 	if($detail){
				 		$str .= '<td>'.$row["supplier"].'</td>';
				 		$str .= '<td>'.$row["time"].'</td>';
				 		
				 		$exp = $row["expire"];
				 		if($exp != "" && $exp != "NULL" && $exp != "0000-00-00 00:00:00" ){
				 			$str .= '<td>'.$exp.'</td>';
				 		}else{
				 			$str .= '<td> - </td>';
				 		}
				 		
				 		$str .= '<td>'.$row["user"].'</td>';
				 	}
				
				 	
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
				 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 85%"><strong>Ma még semmmit nem adtak ki a raktárból!</strong></div>';
				 }
				 
				
			 	$title = "Bevétel ".$from."-tól ".$to."-ig";
				 
				 $json_str = json_encode($jsonarray,True);
				 print '<div id="printhelper_json" class="hiddendiv" detail="'.strval($detail).'"
				 		title="'.$title.'">'.$json_str.'</div>';

				 // Frees the memory associated with a result
				 $results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function listOld(){

	$mysqli = connect();
	
	if($results = $mysqli->query(palletSQL())){
		
		$str =  '<table class="table table-hover  sortable">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>RAKLAP ID</th>';
		$str .= '<th>Alapanyag</th>';
		$str .= '<th>Mennyiség</th>';
		$str .= '<th>Bevétel ideje</th>';
		$str .= '<th>Lejárat</th>';
		$str .= '<th>Lejárt </th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$i = false;

		while($row = $results->fetch_assoc()) {
			$exp = $row["expire"];
			
			if($exp != "" && $exp != "NULL"){
				if( $exp != "0000-00-00 00:00:00" &&  strtotime('now') > strtotime($exp)
					&& strtotime($exp) > strtotime("2015-01-01")){
				
				
					
					$expireDate = $row["expire"];
					
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
		print ("nincs adatbázis kapcsolat");
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
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
}

function outputStatistic($weekday){
	$data = array();
	$unit = array();
	print '<table class="table">';

	print '<thead><tr class="tableTitle"><th>Napi Statisztikák</th><th></th></tr></thead>';

	print '<tr>';
	print '<td>';
	print daypicker($weekday);
	print '</td>';
	print '</tr>';


	for($i=1; $i<=4; $i++){
		if($i==1 || $i == 3){
			print '<tr>';
		}
			
			print '<td>';
			$back = ($i)*7-1-6;
			$day = date('Y-m-d', strtotime("-".$back." days"));
			$back = ($i)*7-1;
			$day2 = date('Y-m-d', strtotime("-".$back." days"));


			$back = $back+((int)date( "w")-1)-$weekday;

			if((int)date( "w")-1 >= $weekday){
				$back = $back-6;
			}else{
				$back = $back+1;
			}



			$currdate = date('Y-m-d', strtotime("-".$back." days"));

			$mysqli = connect();
			if($results = $mysqli->query(
					"SELECT pr.name as product, sum(o.amount) as amount,pr.unit as unit
			FROM pallet p, product pr, output o where pr.id=p.product_id and o.pallet_id = p.id and
				o.time >= '".$day2." 00:00:00'
			and o.time <= '".$day." 23:59:59' and
			WEEKDAY(o.time) = '".$weekday."' and
			 p.deleted = false and pr.deleted = false and
			o.deleted = false group by product order by p.product_id ")){
			$str =  '<table class="table table-hover ">';
			$str .= '<thead>';
			$str .= '<tr class="tableHeader">';
			$str .= '<th>'.strval($i).' hete '.$currdate.'</th>';
			$str .= '<th colspan="2">'.daymap($weekday).'</th>';
				
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<th>Alapanyag</th>';
			$str .= '<th>Mennyiség</th>';
			$str .= '<th>Mértékegység</th>';
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
				
				$unit[$prod] = $row["unit"];
				$str.= '<tr>';

				$str.= '<td>'.$row["product"].'</td>';
				$str.= '<td>'.$row["amount"].'</td>';
				$str.= '<td>'.$row["unit"].'</td>';

				$str.= '</tr>';
			}
			$str.= '</table>';
			print $str;
			}else{
				print "nincs adatbázis kapcsolat";
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

	$str =  '<table class="table table-hover sortable">';
	$str .= '<thead><tr class="tableHeader">';
	$str .= '<th>Átlag</th>';
	$str .= '<th ><button class="btn btn-sm btn-default printbutton" onclick="statisticsPrint()">';
	$str .= '<button class="btn btn-sm btn-default csvbutton" onclick="statisticsCSV()"></th>';
	
	$str .= '<th >'.daymap($weekday).'</th>';
	$str .= '</tr>';
	
	$str .= '<tr>';
	$str .= '<th>Alapanyag</th>';
	
	$str .= '<th>Mennyiség</th>';
	$str .= '<th>Mértékegység</th>';
	$str .= '</tr>';
	$str .= '</thead>';
	
	ksort($data);
	
	foreach ($data as $key => $value) {
		$average = $value / 4;
		$str.= '<tr>';
			
		$str.= '<td>'.$key.'</td>';
		
		$str.= '<td><input type="number" value="'.$average.'" prodname="'.$key.'" unit="'.$unit[$key].'" class="statistic_amountinput"/></td>';
		$str.= '<td>'.$unit[$key].'</td>';
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

function supplierOption($mobile){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM supplier WHERE deleted = false order by name")){
		if($mobile)
			print '<select id="besz-mobile" class="form-control tabletForm">';
		else
			print '<select id="besz" class="form-control tabletForm">';
		while($row = $results->fetch_assoc()) {
			print '<option value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';

		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}

	$mysqli->close();
}

function supplierOption2($selected){
	
	$mysqli = connect();
	$str = "";
	if($results = $mysqli->query("SELECT * FROM supplier WHERE deleted = false order by name")){
		
				$str .= '<select id="supp_opt" class="form-control beszselect">';
				$str .= '<option value="">Beszállító</option>';
				$str .= '<option value=""> --- </option>';
				while($row = $results->fetch_assoc()) {
					if($selected == $row["id"]){
						$str .= '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
					}else{
						$str .= '<option value="'.$row["id"].'" >'.$row["name"].'</option>';
					}
					
				}
				$str .= '</select>';

				$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}

	$mysqli->close();
	return $str;
}

function productOption($mobile = true){

	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		if($mobile)
			print '<select id="alap-mobile" class="form-control tabletForm">';
		else
			print '<select id="alap" class="form-control tabletForm">';
		while($row = $results->fetch_assoc()) {
			print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';

		// Frees the memory associated with a result
		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionStorage($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="prod_select" onchange="filterProd()" style="width: 50%;" class="form-control">';

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
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionInventory($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="prod_select" onchange="filterInventoryProd()" style="width: 50%;" class="form-control">';

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
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionStorage2($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		print '<select id="follow_prod_select" style="width: 50%;" class="form-control noblock">';

		print '<option  value=""> Termék </option>';
		print '<option  value=""> --- </option>';
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
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function productOptionOutput($filter, $mobile){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM product where deleted = false order by name")){
		if($mobile)
			print '<select id="prod_select_mobile" onchange="filterProdOutput('.$mobile.')" class="form-control tabletForm">';
		else
			print '<select id="prod_select" onchange="filterProdOutput('.$mobile.')" class="form-control tabletForm">';
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
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}

	$mysqli->close();
}

function categoryOption($filter){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM category where deleted = false order by name")){
		print '<select id="cat_select" onchange="filterCategory()" class="form-control">';
		print '<option  value=""> Zöldség & Gyümölcs </option>';
		while($row = $results->fetch_assoc()) {
			if($filter === $row["id"]){
				print '<option  value="'.$row["id"].'" selected>'.$row["name"].'</option>';
			}else{
				print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
			}
		}
		print '</select>';
		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function categoryOptions(){
	$mysqli = connect();
	if($results = $mysqli->query("SELECT * FROM category where deleted = false order by name")){
		print '<select id="#_#" class="form-control">';
		while($row = $results->fetch_assoc()) {
			print '<option  value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		print '</select>';
		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}

function getDataById($id){
	$mysqli = connect();
	$pr_id = 0;	
	if($results = $mysqli->query("SELECT product_id as pid FROM pallet where deleted = false and id = ".$id)){
		while($row = $results->fetch_assoc()) {
			$pr_id = $row["pid"];			
		}
		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	
	if($pr_id == 0){
		print '<h1>NINCS ILYEN RAKLAP VAGY TÖRÖLVE LETT</h1>';
		return;
	}
	
	$filter  = "and pr.id = '".$pr_id."' ";	
	
	if($results = $mysqli->query(palletSQL2($filter))){
		$str_head = "";
		$str_head .= '<table class="table table-hover">';
		$str_head .= '<thead>';
		$str_head .= '<tr>';
		$str_head .= '<th style="text-align:center;">ID</th>';
		$str_head .= '<th style="text-align:center;">Alapanyag</th>';
		$str_head .= '<th style="text-align:center;">Mennyiség</th>';
		$str_head .= '<th style="text-align:center;">Beszállító</th>';
		$str_head .= '<th style="text-align:center;">Idő</th>';
		$str_head .= '</tr>';
		$str_head .= '</thead>';
		$firstprods = array();
		$printed = false;
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
				if((int)$row["rest"] > 0){
					print $str_head;
					print $str;
					$printed = true;
					break;
				}
				
			}else{
				$printed = false;
			}
			
		}
		if(!$printed){
			print "<h1>ÜRES RAKLAP</h1>";
		}
		
		$results->free();
	}else{
		print "nincs adatbázis kapcsolat";
		print mysqli_error($mysqli);
	}
	
	// close connection
	$mysqli->close();
}

function supplySQL($timefilter,$prodfilter){
	return "select p.id as id, pr.name as product, pr.id as pr_id,pr.unit as unit, s.name as supplier, p.time as time, u.name as user,sum(p.amount) as origamount, pr.minimum as min, p.printed as printed,
				sum( IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0)) as rest
				from pallet p
				INNER JOIN product pr on p.product_id = pr.id and p.deleted = false  ".$prodfilter." ".$timefilter." 
				INNER JOIN supplier s on s.id = p.supplier_id
				INNER JOIN user u on u.id = p.user_id
				LEFT JOIN (
	    			select t2.id as id ,t3.amount as trash,t2.amount as output from
					(
			           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false ".$timefilter." group by pallet_id
			        )t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false ".$timefilter." group by pallet_id
		        )t3
				ON t2.id = t3.id
				UNION
				select t2.id as id ,t2.amount as trash,t3.amount as output from
				(
	             	SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false ".$timefilter." group by pallet_id
	        	)t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false ".$timefilter." group by pallet_id
		        )t3
				ON t2.id = t3.id
	 			) t1
	 			on p.id = t1.id GROUP BY pr_id
						HAVING rest > 0
						order by product, time";
}


function supplyDetailsSQL($timefilter,$prodfilter){
	return "select p.id as id, pr.name as product, pr.id as pr_id,pr.unit as unit, s.name as supplier, p.time as time,p.expire as expire, u.name as user,p.amount as origamount, pr.minimum as min, p.printed as printed,
				IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest
				from pallet p
				INNER JOIN product pr on p.product_id = pr.id and p.deleted = false  ".$prodfilter." ".$timefilter."
				INNER JOIN supplier s on s.id = p.supplier_id
				INNER JOIN user u on u.id = p.user_id
				LEFT JOIN (
	    			select t2.id as id ,t3.amount as trash,t2.amount as output from
					(
			           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false ".$timefilter." group by pallet_id
			        )t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false ".$timefilter." group by pallet_id
		        )t3
				ON t2.id = t3.id
				UNION
				select t2.id as id ,t2.amount as trash,t3.amount as output from
				(
	             	SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false ".$timefilter." group by pallet_id
	        	)t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false ".$timefilter." group by pallet_id
		        )t3
				ON t2.id = t3.id
	 			) t1
	 			on p.id = t1.id 
		           		HAVING rest > 0
						order by product, time";
}

function inputSql($timefilter,$prod_id){
	return "select sum(o.amount) as amount
				from pallet p, output o,product pr WHERE
				 p.product_id = pr.id and p.deleted = false and pr.id = '".$prod_id."' 
				 ".$timefilter." and o.pallet_id = p.id and o.deleted = false";
}

function inventorySQL($prodfilter){
	return "select p.id as id, pr.name as product, pr.id as pr_id,pr.unit as unit, s.name as supplier, p.time as time, u.name as user,p.amount as origamount, pr.minimum as min, p.printed as printed,
				IFNULL(p.amount,0) - IFNULL(t1.trash,0) - IFNULL(t1.output,0) as rest, p.deleted as deleted
				from pallet p
				INNER JOIN product pr on p.product_id = pr.id and p.time > (CURDATE() - INTERVAL 2 MONTH) ".$prodfilter." 
				INNER JOIN supplier s on s.id = p.supplier_id
				INNER JOIN user u on u.id = p.user_id
				LEFT JOIN (
	    			select t2.id as id ,t3.amount as trash,t2.amount as output from
					(
			           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false  group by pallet_id
			        )t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false  group by pallet_id
		        )t3
				ON t2.id = t3.id
				UNION
				select t2.id as id ,t2.amount as trash,t3.amount as output from
				(
	             	SELECT pallet_id as id, sum(amount) as amount from trash WHERE deleted = false  group by pallet_id
	        	)t2
				LEFT JOIN
				(
		           SELECT pallet_id as id, sum(amount) as amount from output WHERE deleted = false  group by pallet_id
		        )t3
				ON t2.id = t3.id
	 			) t1
	 			on p.id = t1.id
						order by product, time";
}

function suppnameFromId($id){
	$suppname = "";
	$mysqli = connect();
	if($results = $mysqli->query("SELECT name from supplier WHERE id = ".$id)){
	
		while($row = $results->fetch_assoc()) {
			$suppname = $row['name'];
		}
	
		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "nincs adatbázis kapcsolat";
	}
	$mysqli->close();
	return $suppname;
}

function prodnameFromId($id){
	$suppname = "";
	$mysqli = connect();
	if($results = $mysqli->query("SELECT name from product WHERE id = ".$id)){

		while($row = $results->fetch_assoc()) {
			$suppname = $row['name'];
		}

		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "nincs adatbázis kapcsolat";
	}
	$mysqli->close();
	return $suppname;
}


function dailyOutputSqlTablet($from,$to){
	$sql = "SELECT p.id as id, pr.name as product,pr.unit as unit, o.amount as amount, o.time as time,
				u.name as user,o.id as o_id,p.time as origtime, s.name as supp, o.id as oid
 				FROM  pallet p, product pr, output o, user u, supplier s
			where pr.id=p.product_id and o.pallet_id = p.id and o.user_id = u.id
			 and s.id = p.supplier_id and
			o.time >= '".$from." 00:00:00' and
			o.time <= '".$to." 23:59:59'
			and p.deleted = false and pr.deleted = false and o.deleted = false order by product";
	
	$mysqli = connect();
	$str = "";
	if($results = $mysqli->query(
			$sql
			)){
	
				
				

				while($row = $results->fetch_assoc()) {
					$str .=  '<table class="table table-hover">';
					$str .= '<tr>';						
					$str .= '<td>ID:'.$row['id'].'</td>';
					$str .= '<td><b>'.$row['product'].'</b></td>';
					$str .= '</tr>';
					$str .= '<tr>';
					$str .= '<td>kiadás: '.$row['amount'].' '.$row['unit'].'</td>';
					$str .= '<td>'.$row['time'].'</td>';
					$str .= '</tr>';
					$str .= '<tr>';
					$str .= '<td><button class="btn btn-sm btn-danger" onclick="reverseOutput('.$row['o_id'].','.$row['amount'].')" >Visszavétel</button></td>';
					$str .= '<td><button class="btn btn-sm btn-danger" onclick="deleteOutput('.$row['o_id'].')" >Törlés</button></td>';
					$str .= '</tr>';
					$str .= '</table>';
					$str .= '<br/>';
				}
				
				print $str;
	
				$results->free();
	}else{
		print mysqli_error($mysqli);
		print ("nincs adatbázis kapcsolat");
	}
	
	$mysqli->close();
}
?>