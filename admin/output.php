<?php

$selected ="admin";
$selector ="output";
require("../common/header.php");

$detail = false;
if(isset($_GET['detail'])){
	if($_GET['detail'] == "true"){
		$detail = true;
	}
}

if(isset($_GET['from']) && isset($_GET['to'])){

	$fromarr = explode("-", $_GET['from']);
	$toarr = explode("-", $_GET['to']);

	periodOutput($_GET['from'],$_GET['to'],$detail);

}else{
	$day  = date("Y-m-d");
	periodOutput($day,$day,$detail);
}

require("../common/footer.php");
?>