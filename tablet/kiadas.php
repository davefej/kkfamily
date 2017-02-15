<?php
$selected="tablet";
$selector="kiadas";
require("../common/header.php");

$id="";
if(isset($_GET["filter"]) && $_GET["filter"] == "prod"){
	$id = $_GET["id"];
	$filter  = "and pr.id = '".$id."' ";
}else{
	$filter  = "";
}

sqlExecute2(
		palletSQL2($filter),
		'outputTable',$id);

require("../common/footer.php");

function outputTable($results,$id){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>';
	productOptionOutput($id);
	print 'Alapanyag név';
	print '</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';
	$firstprods = array();
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["rest"].'</td>';
	
		if(in_array($row["product"],$firstprods))
		{
			print '<td><button class="btn btn-sm btn-danger" onclick="olderOutput('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
		}else{
			print '<td><button class="btn btn-sm btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
			array_push($firstprods,$row["product"]);
		}
	
		print '</tr>';
	}
	print '</table>';
}
?>