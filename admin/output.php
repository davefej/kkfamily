<?php

$selected ="admin";
$selector ="output";
require("../common/header.php");

if(isset($_GET['type'])){
	if($_GET['type'] == "day"){
		if(isset($_GET['day'])){
			$day  = $_GET['day'];
		}else{
			$day  = date("Y-m-d");
		}
		periodOutput($day,$day);
	}else if($_GET['type'] == "month"){
		if(isset($_GET['month'])){
			$month_begin  = $_GET['month'];
			$month_end =  date('Y-m-t', strtotime($month_begin));
		}else{
			$month_begin  = date("Y-m-d");
			$month_end = date("Y-m-t");
		}
		periodOutput($month_begin,$month_end);
	}
	
}else{
	$day  = date("Y-m-d");
	periodOutput($day,$day);
}
?>
<br/>
<?php 

if(isset($_GET['wday'])){
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
require("../common/footer.php");
?>