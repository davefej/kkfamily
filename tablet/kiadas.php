<?php
$selected="tablet";
$selector="kiadas";
require("../common/header.php");

if(isset($_GET["filter"])){
	if($_GET["filter"] == "prod"){
		palletOutput($_GET["id"]);
	}

}else{
	palletOutput("");
}

require("../common/footer.php");
?>