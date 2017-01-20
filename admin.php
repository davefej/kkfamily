<?php
$selected ="index";
require("header.php");
?>

<table align="center" class="maintable" border="1">
	<tr>
		<th class="mainth">
			Napi Bevétel (Raktár)
		</th>
		<th class="mainth">
			Napi Kiadás (Raktár)
		</th>
		<th class="mainth">
			Hamarosan Lejáró Termékek
		</th>
	</tr>
	<tr>
		<td class="maintd">
			<div class="maintddiv">
			<?php 			
			require('helper/mysqli.php');
			listnapibevetel();			
			?>
			
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">				
				<?php 
				listnapikiadas();
				?>					
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">
				<?php 
				listlejar();
				?>
			</div>

<?php 
require("footer.php");
?>