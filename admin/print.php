<?php
	$selected ="admin";
	$selector ="print";
	require("../common/header.php");
	
	sqlExecute(palletSQL3("",""),'printedTables');
?>

<?php
	echo "<br/>...";
	require("../common/footer.php");
	
	function printedTables($results){
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>';
		print 'Alapanyag név</th>';
		print '<th>Nyomtatva</th>';
		print '<th>Nyomtatás beállítása</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
			print '<tr>';
			print '<td>'.$row["product"].'</td>';
			if($row["printed"] == 1)
				print '<td><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></td>';
			else if($row["printed"] == 0)
				print '<td><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></td>';
			else
				print '<td>Hiba történt nyomtatás közben</td>';
			if($row["printed"] > 1)
				print '<td><button class="btn btn-danger" onclick="updatePrinted('.$row["id"].')">Hiba megoldása</button></td>';
			else if($row["printed"] == 1)
				print '<td><button class="btn" onclick="rePrint('.$row["id"].')">ÚJRA NYOMTAT</button></td>';	
			else
				print '<td><button class="btn btn-danger" onclick="updatePrinted('.$row["id"].')">Nyomtat</button></td>';
			
			
				
			print '</tr>';
		}
		print '</table>';
	}
?>