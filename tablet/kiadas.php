<?php
$selected="tablet";
$selector="kiadas";
require("../common/header.php");

$id="";
if(isset($_GET["filter"]) && $_GET["filter"] == "prod"){
	if($_GET["id"] == "")
		$filter = "";
	else{
		$id = $_GET["id"];
		$filter  = "and pr.id = '".$id."' ";
	}
}else{
	$filter  = "";
}

sqlExecute2(
		palletSQL2($filter),
		'outputTable',$id);
sqlExecute2(
		palletSQL2($filter),
		'outputTableMobile',$id);

require("../common/footer.php");

function outputTable($results,$id){
	print '<table class="table table-hover sortable tabletTable desktop">';
	print '<thead>';
	print '<tr>';
	print '<th>ID</th>';
	print '<th>';
	productOptionOutput($id, false);
	print 'Alapanyag név';
	print '</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Beérkezés ideje</th>';
	print '<th>Mennyiség</th>';
	print '<th>Kiad</th>';
	print '</tr>';
	print '</thead>';
	$firstprods = array();
	$sum_rest = 0;
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["id"].'</td>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		$sum_rest += $row["rest"];
	
		if(in_array($row["product"],$firstprods))
		{
			print '<td><button class="btn btn-lg btn-danger" onclick="olderOutput('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
		}else{
			print '<td><button class="btn btn-lg btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td>';
			array_push($firstprods,$row["product"]);
		}
	
		print '</tr>';
	}
	print '<tr><td colspan=6>Összesen: '.$sum_rest.'</td></tr>';
	print '</table>';
}
	
function outputTableMobile($results, $id){	
	print '<table class="table table-hover tabletTable mobile">';
	print '<thead>';
	print '<tr>';
	print '<th>';
	productOptionOutput($id, true);
	print 'Alapanyag név';
	print '</th>';
	print '<th>Beszállító Neve</th>';
	print '<th>Mennyiség</th>';
	print '</tr>';
	print '</thead>';
	$firstprods = array();
	$sum_rest = 0;
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["supplier"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		$sum_rest += $row["rest"];
	
		if(in_array($row["product"],$firstprods))
		{
			print '<tr><td colspan=3><button class="btn btn-lg btn-danger" onclick="olderOutput('.$row["id"].','.$row["rest"].')">Kiadás</button></td></tr><tr><td colspan=3 style="background-color:#777;"></td></tr>';
		}else{
			print '<tr><td colspan=3><button class="btn btn-lg btn-danger" onclick="output('.$row["id"].','.$row["rest"].')">Kiadás</button></td></tr><tr><td colspan=3 style="background-color:#777;"></td></tr>';
			array_push($firstprods,$row["product"]);
		}
	
		print '</tr>';
	}
	print '<tr><td colspan=3>Összesen: '.$sum_rest.'</td></tr>';
	print '</table>';
}
?>