<?php
	$selected = "tablet";
	$selector = "bevetel";
	require("../common/header.php");
	

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
			<tr>
				<td colspan="4">
					<button class="btn btn-primary btn-block" onclick="input()">Mentés</button>
				</td>
			</tr>
		</table>
		
	</div>
</div>


<?php 
require("../common/footer.php");
?>