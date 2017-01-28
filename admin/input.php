<?php

$selected ="admin";
$selector ="input";
require("../common/header.php");

if(isset($_GET['day'])){
	$day  = $_GET['day'];
}else{
	$day  = date("y-m-d"); 
}
dailyInputByDay($day);

require("../common/footer.php");
?>