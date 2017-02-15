<?php

$selected ="admin";
$selector ="category";
require("../common/header.php");


sqlExecute(
		"SELECT * FROM category where deleted = false",
		'categoryTable');

require("../common/footer.php");

function categoryTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Kategória Neve</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createCategory()">Új Kategória</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="categoryname_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td ><button class="btn btn-sm btn-default" id="newRetailer" onclick="editCategory('.$row["id"].')">Szerkeszt</button></td>';
		print '<td ><button class="btn btn-sm btn-danger" onclick="deleteCategory('.$row["id"].')">Töröl</button></td>';
		print '</tr>';
	}
	print '</table>';
}
?>