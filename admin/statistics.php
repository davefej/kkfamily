<?php

$selected ="admin";
$selector ="statistics";
require("../common/header.php");
?>
<div class="statisticsdiv">
<?php print daypicker();?>
</div>
<br/>
<div id="adminstatisticcontainer">

<?php 			
	
		$day  = date("Y-m-d");
		$day2 = date('Y-m-d', strtotime("-30 days"));
		$dw = date( "w");
		$dw = $dw -1;
		if($dw == -1){
			$dw = 6;
		}
		outputStatistic($dw);
	
?>
	
	</div>
<?php

require("../common/footer.php");
?>