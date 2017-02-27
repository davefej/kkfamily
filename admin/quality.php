<?php


$selected ="admin";
$selector ="quality";
require("../common/header.php");

if(isset($_GET["date"])){
	$month_begin  = $_GET['date'];
	$month_end =  date('Y-m-t', strtotime($month_begin));
}else{
	$month_begin  = date("Y-m-d");
	$month_end = date("Y-m-t");
}


sqlExecute(
		"SELECT p.id as id, pr.name as name, q.sum_difference, 
		q.appearance, q.consistency, q.smell, q.color,  q.clearness, q.pallet_quality, q.decision
		FROM product pr, pallet p,quantity_form q
		WHERE  pr.deleted = false and
		p.time >= '".$month_begin." 00:00:00' and
		p.time <= '".$month_end." 23:59:59'
		and p.product_id = pr.id and p.quantity_form_id = q.id",
		'qualityinputTable');

function qualityinputTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th colspan="9" class="dateth">'.monthpicker().'</th>';
	print '<th><button class="btn btn-sm btn-default" onclick="reloadQuality()">Betölt</button></th>';
	print '</thead>';
	print '</tr>';
	print '<thead>';
	print '<tr>';
	print '<th>Raklap ID</th>';
	print '<th>Alapanyag</th>';
	print '<th>Súly különbség</th>';
	print '<th>Kinézet</th>';
	print '<th>Állag</th>';
	print '<th>Illat</th>';
	print '<th>Szín</th>';
	print '<th>Tisztaság</th>';
	print '<th>Raklap minőség</th>';
	print '<th>Átvétel</th>';	
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["sum_difference"].'</td>';
		print '<td>'.$row["appearance"].'</td>';
		print '<td>'.$row["consistency"].'</td>';
		print '<td>'.$row["smell"].'</td>';
		print '<td>'.$row["color"].'</td>';
		print '<td>'.$row["clearness"].'</td>';
		print '<td>'.$row["pallet_quality"].'</td>';
		if($row["decision"] == "0"){
			print '<td>Átvéve</td>';
		}else{
			print '<td>Nincs átvéve</td>';
		}
		
		print '</tr>';
	}
	print '</table>';
}

require("../common/footer.php");
?>