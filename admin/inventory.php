<?php

$selected ="admin";
$selector ="inventory";
require("../common/header.php");

sqlExecute(
		palletSQL(),
		'inventoryTable');

require("../common/footer.php");

function inventoryTable($results){
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
		print '<td><button class="btn btn-sm btn-default" onclick="inventory_update('.$row["id"].','.$row["rest"].",'".$row["time"]."'".','.$row["origamount"].')">Szerkeszt</button></td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="deletePallet('.$row["id"].')">Töröl</button></td>';
		print '</tr>';
	}
	print '</table>';
}
?>