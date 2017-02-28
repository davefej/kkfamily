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


?>



<?php 
require("../common/footer.php");
?>