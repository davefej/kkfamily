<?php

$selected ="admin";
$selector ="output";
require("../common/header.php");

if(isset($_GET['day'])){
	$day  =$_GET['day'];
}else{
	$day  = date("Y-m-d");
}
dailyOutputByDay($day);

require("../common/footer.php");
?>