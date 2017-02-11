<?php

$selected ="admin";
$selector ="input";
require("../common/header.php");


if(isset($_GET['wday'])){
	$day  = date("Y-m-d");
	$day2 = date('Y-m-d', strtotime("-30 days"));
	inputStatistic($_GET['wday'],$day,$day2);
}else{
	$day  = date("Y-m-d");
	$day2 = date('Y-m-d', strtotime("-30 days"));
	$dw = date( "w");
	$dw = $dw -1;
	if($dw == -1){
		$dw = 6;
	}
	inputStatistic($dw,$day,$day2);
}
?>
<br/>
<?php 

if(isset($_GET['type'])){
	if($_GET['type'] == "day"){
		if(isset($_GET['day'])){
			$day  = $_GET['day'];
		}else{
			$day  = date("Y-m-d");
		}
		periodInput($day,$day);
	}else if($_GET['type'] == "month"){
		if(isset($_GET['month'])){
			$month_begin  = $_GET['month'];
			$month_end =  date('Y-m-t', strtotime($month_begin));
		}else{
			$month_begin  = date("Y-m-d");
			$month_end = date("Y-m-t");
		}
		periodInput($month_begin,$month_end);
	}
	
}else{
	$day  = date("Y-m-d");
	periodInput($day,$day);
}



require("../common/footer.php");
?>