<?php
	$selected = "tablet";
	$selector = "bevetel";
	require("../common/header.php");
	
?>
<div class="container-fluid">
	<div class="centerBlock">
		
			<table id="beveteltable" class="table table-striped tabletTable desktop">
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
							supplierOption(false);
						?>
					</td>
				
					<td colspan="3">
						<?php 
							productOption(false);
						?>	
					<td colspan="3">
						<input class="form-control tabletForm" id="suly" type="number" />
					</td>
				</tr>
				<tr>
					<td>
						Bevétel Dátuma:
					</td>
					<td colspan="3">
						<?php 
							$today = date("Y-m-d");
							$today_det = explode("-",$today);
							echo datepicker((int)$today_det[0],(int)$today_det[2],(int)$today_det[1],false);
						?>	
					</td>
					<td>
						Lejárat:
					</td>	
					<td colspan="3">
						<?php 
							$today = date("Y-m-d");
							$today_det = explode("-",$today);
							echo datepicker("","","","-expire");
						?>	
					</td>
				</tr>
				<tr>
					<td>
						Mennyiségi eltérés
					</td>
					<td>
						Külső megjelenés, kártevőmentesség
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
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td>
						<select class="form-control tabletForm" id="consistency">
						<option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td>
						<select class="form-control tabletForm" id="smell">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td>
						<select class="form-control tabletForm" id="color">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td>
						<select class="form-control tabletForm" id="clearness">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td>
						<select class="form-control tabletForm" id="palletQuality">
						  <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
					<td style="width: 150px">
						<select class="form-control tabletForm" id="decision">
						  <option value="accept">Átvesz</option>
						   <option value="accept2">Reklamáció (átvétel)</option>
						  <option value="decline">Visszautasít</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="9">
						<button class="btn btn-primary btn-block btn-lg" onclick="input(event)">Mentés</button>
					</td>
				</tr>
			</table>
		
			<table id="beveteltablemobile" class="table table-striped tabletTable mobile">
				<tr>
					<td>
						Beszállító
					</td>
					<td>
						<?php 
								supplierOption(true);
						?>
					</td>
				</tr>
				<tr>
					<td>
						Alapanyag
					</td>
					<td>
						<?php 
							productOption(true);
						?>
					</td>
				</tr>
				<tr>
					<td>
						Mennyiség
					</td>
					<td>
						<input class="form-control tabletForm" id="suly-mobile" type="number" />
					</td>
				</tr>
				
				<tr>
					<td>
						Bevétel Dátuma:
					</td>
					<td colspan="3">
						<?php 
							$today = date("Y-m-d");
							$today_det = explode("-",$today);
							echo datepicker((int)$today_det[0],(int)$today_det[2],(int)$today_det[1],"-mobile");
						?>	
					</td>
				</tr>
				<tr>
					<td>
						Lejárat:
					</td>	
					<td colspan="3">
						<?php 
							$today = date("Y-m-d");
							$today_det = explode("-",$today);
							echo datepicker("","","","-expire-mobile");
						?>	
					</td>
				</tr>
				
			</table>
			<br>
			<table class="table table-striped tabletTable mobile">
				<tr>
					<td>
						Mennyiségi eltérés
					</td>
					<td>
						<input type="number" class="form-control tabletForm" id="sumDifference-mobile" value=0>
					</td>
				</tr>
				<tr>
					<td>
						Külső megjelenés
					</td>
					<td>
						<select class="form-control tabletForm" id="appearance-mobile">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Állag
					</td>
					<td>
						<select class="form-control tabletForm" id="consistency-mobile">
						<option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Illat
					</td>
					<td>
						<select class="form-control tabletForm" id="smell-mobile">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Szín
					</td>
					<td>
						<select class="form-control tabletForm" id="color-mobile">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Jármű tisztaság, hőfok
					</td>
					<td>
						<select class="form-control tabletForm" id="clearness-mobile">
						<option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Raklap, ládák minősége
					</td>
					<td>
						<select class="form-control tabletForm" id="palletQuality-mobile">
						 <option value="0">0 - Komoly Probléma</option>
						  <option value="1">1 - Nem átvehető</option>
						  <option value="2">2 - Átvehető</option>
						  <option value="3" selected>3 - Megfelelő</option>
						</select>
					</td>
				</tr>				
				<tr>
					<td>
						Döntés
					</td>
					<td style="width: 150px">
						<select class="form-control tabletForm" id="decision-mobile">
						  <option value="accept">Átvesz</option>
						  <option value="decline">Visszautasít</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button class="btn btn-primary btn-block btn-lg" onclick="inputMobile(event)">Mentés</button>
					</td>
				</tr>
			</table>
			
			
		
	</div>
</div>


<?php 

if ($file = fopen("../log/printerlog.txt", "r")) {
	while(!feof($file)) {
		$line = fgets($file);
		$last = strtotime($line);
		$minsago = strtotime("-2 minutes");
		
		if($minsago > $last){
			echo "<h1 align='center'>Nyomtató program nincs bekapcsolva!</h1>";
		}
		break;
	}
}

require("../common/footer.php");
?>
