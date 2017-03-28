<?php
require 'helper/mysqli.php';
header('Content-Type: text/html; charset=utf-8');

if(isset($_GET['pass']) && $_GET['pass'] == "kkpass123"){
	
	if(isset($_GET['error'])){		
		$myfile = fopen("printerror.txt", "a");
		fwrite($myfile, "\r\n". date('Y-m-d H:i:s'). "\r\n");
		fwrite($myfile, $_GET['error']);
		fclose($myfile);
		return;
	}else{
		$myfile = fopen("log/printerlog.txt", "w");
		fwrite($myfile,date('Y-m-d H:i:s'));
		fclose($myfile);
	}
	$id = "";
	$str = "NO_DATA";
	$mysqli = connect();
	if($results = $mysqli->query("SELECT p.id as id, p.amount as amount,pr.name as prod, s.name as sup, p.time as time, pr.unit as unit from pallet p,product pr, supplier s WHERE p.deleted = 0 and p.printed = 0 and p.product_id = pr.id and p.supplier_id = s.id")){		
		while($row = $results->fetch_assoc()) {
			$str = $row['id']."#_#".$row['amount']."#_#".$row['prod']."#_#".$row['time']."#_#".$row['sup']."#_#".$row['unit']."#_#";
			$id = $row['id'];
			break;
		}		
		$results->free();
	}else{
		$str = "ERROR";
	}
	if($str != "NO_DATA" && str != "ERROR" && $id != "" && !isset($_GET['test'])){
		
		update("UPDATE pallet SET printed = '1' WHERE id = '".$id."'");
	}
	// close connection
	$mysqli->close();
	
	
	print $str;
	
	
}



?>