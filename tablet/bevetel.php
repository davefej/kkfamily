<?php
	$selected = "tablet";
	$selector = "bevetel";
	require("../header.php");
	
	require('../helper/mysqli.php');
?>
<div class="container-fluid">
	<div class="col-md-11">
		<table class="table table-striped">
			<thead>
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
			</thead>
			<tr>
				<td>
					<?php 
						supplierOption();
					?>
				</td>
			
				<td>
					<?php 
						productOption();
					?>	
				<td>
					<input class="form-control" id="suly" type="number" />
				</td>
			</tr>
		</table>
		<button class="btn btn-primary btn-block" onclick="input()">Mentés</button>
	</div>
</div>


<?php 
require("../footer.php");
?>