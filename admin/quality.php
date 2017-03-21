<?php


$selected ="admin";
$selector ="quality";
require("../common/header.php");


if(isset($_GET['type'])){
	if($_GET['type'] == "day"){
		if(isset($_GET['day'])){
			$begin  = $_GET['day'];
			$end = $_GET['day'];
			$only_month = date('n', strtotime($begin));
			$only_day = date('j', strtotime($begin));
		}else{
			$day  = date("Y-m-d");
			$only_month = "";
			$only_day = "";
		}
	}else if($_GET['type'] == "month"){
		if(isset($_GET['month'])){
			$begin  = $_GET['month'];
			$end =  date('Y-m-t', strtotime($begin));
			$only_month = date('n', strtotime($begin));
			$only_day = "";
		}else{
			$begin  = date("Y-m-d");
			$end = date("Y-m-t");
			$only_month = "";
			$only_day = "";
		}
	}

}else{
	$begin  = date("Y-m-01");
	$end = date("Y-m-t");
	$only_month = "";
	$only_day = "";
}


sqlExecute3(
		"SELECT p.id as id, pr.name as name, p.amount as amount,s.name as supp, p.time as time,u.name as user, q.sum_difference, 
		q.appearance, q.consistency, q.smell, q.color,  q.clearness, q.pallet_quality, q.decision
		FROM product pr, pallet p,quantity_form q, user u, supplier s
		WHERE  pr.deleted = false and u.id = p.user_id and s.id = p.supplier_id and
		p.time >= '".$begin." 00:00:00' and
		p.time <= '".$end." 23:59:59'
		and p.product_id = pr.id and p.quantity_form_id = q.id",
		'qualityinputTable', $only_month, $only_day);

function qualityinputTable($results, $month, $day){
	
	print '<table class="table table-hover ">';
	print '<thead>';
	print '<tr>';
	print '<th colspan="12" class="dateth">'.datepicker($day, $month, true).'</th>';
	print '<th><button class="btn btn-sm btn-default" onclick="reloadMonthlyQuality()">Havi betöltés</button></th>';
	print '<th><button class="btn btn-sm btn-default" onclick="reloadDailyQuality()">Napi betöltés</button></th>';
	print '</thead>';
	
	print '</table>';
	print '<table class="table table-hover sortable">';
	print '</tr>';
	print '<thead>';
	print '<tr>';
	print '<th>Raklap ID</th>';
	print '<th>Alapanyag</th>';
	print '<th>Beszállító</th>';
	print '<th>Beszállítás Dátuma</th>';
	print '<th>Eredeti Súly</th>';
	print '<th>Súly különbség</th>';
	print '<th>Külső<br/>Megjelenés</th>';
	print '<th>Állag</th>';
	print '<th>Illat</th>';
	print '<th>Szín</th>';
	print '<th>Jármű tisztaság, hőfok</th>';
	print '<th>Raklap, ládák minőség</th>';
	print '<th>Raktáros</th>';
	print '<th>Átvétel</th>';	
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["supp"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["amount"].'</td>';
		print '<td>'.$row["sum_difference"].'</td>';
		print '<td>'.$row["appearance"].'</td>';
		print '<td>'.$row["consistency"].'</td>';
		print '<td>'.$row["smell"].'</td>';
		print '<td>'.$row["color"].'</td>';
		print '<td>'.$row["clearness"].'</td>';
		print '<td>'.$row["pallet_quality"].'</td>';
		print '<td>'.$row["user"].'</td>';
		if($row["decision"] == "0"){
			print '<td>Átvéve</td>';
		}else if($row["decision"] == "1"){
			print '<td>Reklamáció (Átvéve)</td>';
		}else{
			print '<td>Nincs átvéve</td>';
		}
		
		print '</tr>';
	}
	print '</table>';
}

require("../common/footer.php");
?>