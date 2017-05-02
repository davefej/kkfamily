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



if(isset($_GET['from']) && isset($_GET['to'])){
	
	$fromarr = explode("-", $_GET['from']);
	$toarr = explode("-", $_GET['to']);

	periodInput($_GET['from'],$_GET['to'],$detail,$supp);
	
}else{
	$day  = date("Y-m-d");
	periodInput($day,$day,$detail,$supp);
}



require("../common/footer.php");
?>