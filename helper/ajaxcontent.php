<?php
require 'contentgenerator.php';
if(isset($_GET['type'])){
	if($_GET['type'] == "fogyas"){
		if(isset($_GET['wday']) && is_numeric($_GET['wday'])){
			outputStatistic($_GET['wday']);
		}else{

			$dw = date( "w");
			$dw = $dw -1;
			if($dw == -1){
				$dw = 6;
			}
			outputStatistic($dw);				
		}
	}	
	
	
	if($_GET['type'] == "supplyprint"){
		if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])){
			$timefilter = " and time < '".$_GET['year']."-".$_GET['month']."-".$_GET['day']." 00:00:00' ";
			sqlExecute(supplySQL($timefilter,""),'supplieJSON');
			
		}else{
			
		}
	}
}

function supplieJSON($results){
	$arr = array();
	while($row = $results->fetch_assoc()) {
		
		$item = array();
		$item["terméknév"] = $row['product'];
		$item["mennyiség"] = $row['rest']." ".$row['unit'];

		array_push($arr,$item);
	}
	$data = json_encode($arr,3);
	print $data;
}

?>