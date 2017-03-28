<?php

$selected ="admin";
$selector ="input";
require("../common/header.php");

$detail = false;
if(isset($_GET['detail'])){
	if($_GET['detail'] == "true"){
		$detail = true;
	}
}

if(isset($_GET['supp'])){
	$supp = $_GET['supp'];
}else{
	$supp = "";
}

if(isset($_GET['type'])){
	if($_GET['type'] == "day"){
		if(isset($_GET['day'])){
			$day  = $_GET['day'];
			$only_month = date('n', strtotime($day));
			$only_day = date('j', strtotime($day));
			$only_year = date('Y', strtotime($day));
		}else{
			$day  = date("Y-m-d");
			$only_month = "";
			$only_day = "";
			$only_year = "";
		}
		periodInput($only_year,$only_day, $only_month, $day,$day,$detail,$supp);
	}else if($_GET['type'] == "month"){
		if(isset($_GET['month'])){
			$month_begin  = $_GET['month'];
			$month_end =  date('Y-m-t', strtotime($month_begin));
			$only_month = date('n', strtotime($month_begin));
			$only_year = date('Y', strtotime($month_begin));
			$only_day = "";
		}else{
			$month_begin  = date("Y-m-d");
			$month_end = date("Y-m-t");
			$only_month = "";
			$only_day = "";
			$only_year = "";
		}
		periodInput($only_year,$only_day, $only_month, $month_begin,$month_end,$detail,$supp);
	}
	
}else{
	$day  = date("Y-m-d");
	periodInput("","","",$day,$day,$detail,$supp);
}



require("../common/footer.php");
?>