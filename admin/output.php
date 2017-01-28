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

require("../common/footer.php");
?>