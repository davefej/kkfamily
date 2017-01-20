<?php
require("tabletheader.php");

require('../helper/mysqli.php');
?>

<table align="center" class="bevetelmain">
	<tr>
		<th>
			Beszállító
		</th>
		<th>
			Alapanyag
		</th>
		<th>
			Mennyiség
		</th>
	</tr>
	<tr>
		<td>
		<?php 
		beszallitokoption();
		?>
		</td>
	
		<td>
		<?php 
		alapanyagoption();
		?>	
		<td>
			<input class="bevoption" id="suly" type="number" />
		</td>
	</tr>
</table>
<div class="buttoncont">
<button class="bevetelment" onclick="bevetel()">MENT</button>
</div>

<?php 
require("tabletfooter.php");
?>