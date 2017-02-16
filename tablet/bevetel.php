<?php
	$selected = "tablet";
	$selector = "bevetel";
	require("../common/header.php");
	

?>
<div class="container-fluid">
	<div class="centerBlock">
	<form method="post">
		<table class="table table-striped tabletTable">
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
					<input class="form-control tabletForm" id="suly" type="number" />
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
					<input type="number" class="form-control tabletForm" id="sumDifference" value=0>
				</td>
				<td>
					<select class="form-control tabletForm" id="appearance">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td>
					<select class="form-control tabletForm" id="consistency">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td>
					<select class="form-control tabletForm" id="smell">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td>
					<select class="form-control tabletForm" id="color">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td>
					<select class="form-control tabletForm" id="clearness">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td>
					<select class="form-control tabletForm" id="palletQuality">
					  <option value="1">Rossz</option>
					  <option value="2">Közepes</option>
					  <option value="3" selected>Jó</option>
					</select>
				</td>
				<td style="width: 150px">
					<select class="form-control tabletForm" id="decision">
					  <option value="accept">Átvesz</option>
					  <option value="decline">Visszautasít</option>
					</select>
					
				</td>
			</tr>
			<tr>
				<td colspan="9">
					<button class="btn btn-primary btn-block btn-lg" onclick="input()">Mentés</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>


<?php 
require("../common/footer.php");
?>