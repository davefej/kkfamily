<?php 
require 'helper/mysqli.php';


$str= "";

$mysqli = connect();

//PALLET
/*
if($results = $mysqli->query("SELECT * from pallet")){
		while($row = $results->fetch_assoc()) {

			$str.= $row["id"];
			$str.= ",".$row["quantity_form_id"];
			$str.= ",".$row["product_id"];
			$str.= ",".$row["supplier_id"];
			$str.= ",".$row["time"];
			$str.= ",".$row["amount"];
			$str.= ",".$row["printed"];
			$str.= ",".$row["user_id"];
			$str.= ",".$row["deleted"];
			$str .= "\r\n";	
		}
	$results->free();
}else{
	print mysqli_error($mysqli);
	print "hiba";
}


$str= "";
if($results = $mysqli->query("SELECT * from output")){
		while($row = $results->fetch_assoc()) {

			$str.= $row["id"];
			$str.= ",".$row["pallet_id"];
			$str.= ",".$row["amount"];
			$str.= ",".$row["time"];
			$str.= ",".$row["user_id"];
			$str.= ",".$row["deleted"];
			$str .= "\r\n";	
		}
	$results->free();
}else{
	print mysqli_error($mysqli);
	print "hiba";
}

$str= "";
if($results = $mysqli->query("SELECT * from quantity_form")){
	while($row = $results->fetch_assoc()) {

		$str.= $row["id"];
		$str.= ",".$row["sum_difference"];
		$str.= ",".$row["appearance"];
		$str.= ",".$row["consistency"];
		$str.= ",".$row["smell"];
		$str.= ",".$row["color"];
		$str.= ",".$row["clearness"];
		$str.= ",".$row["pallet_quality"];
		$str.= ",".$row["decision"];
		$str .= "\r\n";
	}
	$results->free();
}else{
	print mysqli_error($mysqli);
	print "hiba";
}

*/

$str= "";
if($results = $mysqli->query("SELECT * from product")){
	while($row = $results->fetch_assoc()) {

		$str.= $row["id"];
		$str.= ",".$row["name"];
		$str.= ",".$row["category_id"];
		$str.= ",".$row["type"];
		$str.= ",".$row["minimum"];
		$str.= ",".$row["expire"];
		$str.= ",".$row["unit"];
		$str.= ",".$row["deleted"];
		$str .= "\r\n";
	}
	$results->free();
}else{
	print mysqli_error($mysqli);
	print "hiba";
}


$mysqli->close();
print $str;
$myfile = fopen("exportprod.txt","a");
fwrite($myfile, $str);
fclose($myfile);
?>