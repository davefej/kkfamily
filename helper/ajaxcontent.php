<?php
require 'contentgenerator.php';
if(isset($_GET['type'])){
	if($_GET['type'] == "fogyas"){
		if(isset($_GET['wday']) && is_numeric($_GET['wday'])){
			$day  = date("Y-m-d");
			$day2 = date('Y-m-d', strtotime("-30 days"));
			outputStatistic($_GET['wday'],$day,$day2);
		}else{
			$day  = date("Y-m-d");
			$day2 = date('Y-m-d', strtotime("-30 days"));
			$dw = date( "w");
			$dw = $dw -1;
			if($dw == -1){
				$dw = 6;
			}
			outputStatistic($dw,$day,$day2);				
		}
	}	
}


?>