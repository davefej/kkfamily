<?php
$selected="tablet";
$selector="spare";
require("../common/header.php");


sqlExecute(
		palletSQL(),
		'spareTable');

require("../common/footer.php");

function spareTable($results){
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
}
?>