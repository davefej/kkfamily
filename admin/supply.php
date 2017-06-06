<?php
$selected ="admin";
$selector ="supply";
require("../common/header.php");


if(isset($_GET['month']) && isset($_GET['day'])  && isset($_GET['year'])){
	$month  = $_GET['month'];
	$day  = $_GET['day'];
	$year = $_GET['year'];
}else{
	$month = date("m");
	$day = date("d");
	$year = date("Y");
}


$arr = array();
$arr['day'] = $day;
$arr['month'] = $month;
$arr['year'] = $year;

$timefilter = " and time < '".$year."-".$month."-".$day." 00:00:00' ";

if(isset($_GET['details']) && $_GET['details'] == "true"){
	$arr['details'] = true;
	sqlExecute2(supplyDetailsSQL($timefilter,""),'supplieTable',$arr);
}else{
	$arr['details'] = false;
	sqlExecute2(supplySQL($timefilter,""),'supplieTable',$arr);
}


require("../common/footer.php");


function supplieTable($results,$arr){
	$details = $arr['details'];
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr class="tableHeader">';
	print '<th>';
	echo datepicker($arr['year'],$arr['day'], $arr['month'], true);
	
	print '</th>';
	print '<th>';
	print '<th>Részletes<input id="detailscb" type="checkbox" name="detailscb"></th>';
	print '</th>';
	print '<th>			
			<button class="btn btn-sm btn-default" onclick="loadSupply()">Betölt</button>
			<button class="btn btn-sm btn-default printbutton" onclick="supplyPrint()"></button>
			<button class="btn btn-sm btn-default csvbutton" onclick="supplyCSV()">
			</th>';
	print '</tr>';
	print '</thead>';
	print '</table>';
	
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	if($details){
		print '<th>Raklap ID</th>';
	}
	print '<th>Alapanyag név</th>';
	if($details){
		print '<th>Beszállító</th>';
		print '<th>Bevétel ideje</th>';
		print '<th>Szav idő</th>';
	}
	print '<th>Mennyiség</th>';
	print '<th>Mértékegység</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		if($details){
			print '<td>'.$row["id"].'</td>';
		}
		print '<td>'.$row["product"].'</td>';
		if($details){			
			print '<td>'.$row["supplier"].'</td>';
			print '<td>'.$row["time"].'</td>';
			$exp = $row["expire"];
			if($exp != "" && $exp != "NULL" && $exp != "0000-00-00 00:00:00" ){
				print '<td>'.$exp.'</td>';
			}else{
				print '<td> - </td>';
			}
		}
		print '<td>'.$row["rest"].'</td>';
		print '<td>'.$row["unit"].'</td>';
		print '</tr>';
	}
	print '</table>';
}

?>