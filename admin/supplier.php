<?php
$selected ="admin";
$selector ="supplier";
require("../common/header.php");

sqlExecute(
		"SELECT * FROM supplier where deleted = false",
		'supplierTable');


require("../common/footer.php");

function supplierTable($results){
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
}
?>