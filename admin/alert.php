<?php

$selected ="admin";
$selector ="alert";
require("../common/header.php");
?>

<br/>
 <div class="panel-group">
<!-- OUTPUT ALERT -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse4">
	  				Újabban kiadott Kiadás
	  			</a>
			</div>
			<div id="collapse4" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							alertOutput();
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		</div>
		
		<!-- SPARE ALERT -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse5">
	  				Selejbe dobott áruk
	  			</a>
			</div>
			<div id="collapse5" class="panel-collapse collapse">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							alertSpare();
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		</div>
</div>

<?php 
require("../common/footer.php");
?>