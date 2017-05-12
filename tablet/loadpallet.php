<?php
$selected="tablet";
$selector="loadpallet";
require("../common/header.php");

if(isset($_GET['id'])){
	$id = $_GET['id'];
	echo $id." idjű raklap beolvasva! :)";
	getDataById($id);
}else{
	echo "NINCS ID MEGADVA";
}

$today = date("Y-m-d");
$today_det = explode("-",$today);
echo "<script> var global_date_str = '".datepicker((int)$today_det[0],(int)$today_det[2],(int)$today_det[1],"")."'; </script>";

?>



<?php 
require("../common/footer.php");
?>