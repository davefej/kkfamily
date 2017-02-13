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
}


?>