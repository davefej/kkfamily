<?php

$selected ="admin";
$selector ="spare";
require("../common/header.php");

if(isset($_GET['type'])){
	if($_GET['type'] == "day"){
		if(isset($_GET['day'])){
			$day  = $_GET['day'];
		}else{
			$day  = date("Y-m-d");
		}
		periodSpare($day,$day);
	}else if($_GET['type'] == "month"){
		if(isset($_GET['month'])){
			$month_begin  = $_GET['month'];
			$month_end =  date('Y-m-t', strtotime($month_begin));
		}else{
			$month_begin  = date("Y-m-d");
			$month_end = date("Y-m-t");
		}
		periodSpare($month_begin,$month_end);
	}
	
}else{
	$day  = date("Y-m-d");
	periodSpare($day,$day);
}

require("../common/footer.php");
?>