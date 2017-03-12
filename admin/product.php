<?php
$selected ="admin";
$selector ="product";
require("../common/header.php");

	sqlExecute(
			"SELECT p.id as id, p.name as name, 
			p.minimum as minimum, p.expire as expire, p.unit as unit,
			c.name as cat, c.id as catid FROM product p, category c 
			WHERE c.id = p.category_id and p.deleted = false",
			'productTable');


?>

<div id="category_container" class="hiddendiv" >
	<?php categoryOptions();?>
</div>

<?php 
require("../common/footer.php");


function productTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Alapanyag Neve</th>';	
	print '<th>Kategória</th>';
	print '<th>Egység</th>';
	print '<th>Jelzési Mennyiség</th>';
	print '<th>Lejárat (nap)</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createProduct()">Új alapanyag</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="alapnev_'.$row["id"].'">'.$row["name"].'</td>';
		print '<td id="alapkat_'.$row["id"].'" catid="'.$row["catid"].'">'.$row["cat"].'</td>';
		print '<td id="alapunit_'.$row["id"].'">'.$row["unit"].'</td>';
		print '<td id="alapmin_'.$row["id"].'">'.$row["minimum"].'</td>';
		print '<td id="alapexp_'.$row["id"].'">'.$row["expire"].'</td>';
		print '<td><button class="btn btn-sm btn-default" id="newRetailer"  onclick="editProduct('.$row["id"].')">Szerkeszt</button></td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="deleteProduct('.$row["id"].')">Töröl</button></td>';
		print '</tr>';
	}
	print '</table>';
}

?>