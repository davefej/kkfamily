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

sqlExecute2(supplySQL($timefilter,""),'supplieTable',$arr);

require("../common/footer.php");


function supplieTable($results,$datearr){
	
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr class="tableHeader">';
	print '<th>';
	echo datepicker($datearr['year'],$datearr['day'], $datearr['month'], true);
	
	print '</th>';
	print '<th>
			
			<button class="btn btn-sm btn-default" onclick="loadSupply()">Betölt</button>
			<button class="btn btn-sm btn-default printbutton" onclick="supplyPrint()">
			  
			</button>
			</th>';
	print '</tr>';
	print '</thead>';
	print '</table>';
	
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>';
	
	print 'Alapanyag név</th>';
	print '<th>Mennyiség</th>';
	print '<th>Mértékegység</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		print '<td>'.$row["unit"].'</td>';
		print '</tr>';
	}
	print '</table>';
}

?>