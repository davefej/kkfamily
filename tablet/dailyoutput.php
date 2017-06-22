<?php
$selected="tablet";
$selector="dailyoutput";
require("../common/header.php");


$to = date("Y-m-d")." 23:59:59";
$from = date('Y-m-d', strtotime('-2 days'))." 00:00:01";
echo "<br/>";
echo "<br/>";
dailyOutputSqlTablet($from,$to,true);
?>




<?php 
require("../common/footer.php");
?>