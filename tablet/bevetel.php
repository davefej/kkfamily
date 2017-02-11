<?php
	$selected = "tablet";
	$selector = "bevetel";
	require("../common/header.php");
	

?>
<div class="container-fluid">
	<div class="col-md-11 centerBlock">
	<form method="post">
		<table class="table table-striped">
			<thead>
				<tr>
					<th colspan="3">
						Beszállító
					</th> 
					<th  colspan="3">
						Alapanyag
					</th>
					<th  colspan="3">
						Mennyiség
					</th>
				</tr>
			</thead>
			<tr>
				<td colspan="3">
					<?php 
						supplierOption();
					?>
				</td>
			
				<td colspan="3">
					<?php 
						productOption();
					?>	
				<td colspan="3">
					<input class="form-control" id="suly" type="number" />
				</td>
			</tr>
			<tr>
				<td>
					Mennyiségi eltérés
				</td>
				<td>
					Külső megjelenés
				</td>
				<td>
					Állag
				</td>
				<td>
					Illat
				</td>
				<td>
					Szín
				</td>
				<td>
					Jármű tisztaság, hőfok
				</td>
				<td>
					Raklap, ládák minősége
				</td>
				<td>
					Döntés
				</td>
			</tr>
			<tr>
				<td>
					<input class="form-control" type="number" id="sumDifference">
				</td>
				<td>
					<input class="form-control" type="number" id="appearance" min="1" max="5">
				</td>
				<td>
					<input class="form-control" type="number" id="consistency" min="1" max="5">
				</td>
				<td>
					<input class="form-control" type="number" id="smell" min="1" max="5">
				</td>
				<td>
					<input class="form-control" type="number" id="color" min="1" max="5">
				</td>
				<td>
					<input class="form-control" type="number" id="clearness" min="1" max="5">
				</td>
				<td>
					<input class="form-control" type="number" id="palletQuality" min="1" max="5">
				</td>
				<td style="width: 150px">
					<select class="form-control" id="decision">
					  <option value="accept">Átvesz</option>
					  <option value="decline">Visszautasít</option>
					</select>
					
				</td>
			</tr>
			<tr>
				<td colspan="9">
					<button class="btn btn-primary btn-block" onclick="input()">Mentés</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>


<?php 
require("../common/footer.php");
?>