<?php
$selected="tablet";
$selector="raktar";
require("../common/header.php");
sqlExecute(palletSQL3(""," GROUP BY pr_id "),'raktarTable');


require("../common/footer.php");



function raktarTable($results){

	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr class="tableHeader">';
	print '<th>';
	
	print '</th>';
	print '<th>';
	
	print '</th>';
	print '</tr>';
	print '</thead>';
	print '</table>';

	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag név</th>';
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