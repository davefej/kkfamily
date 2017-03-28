<?php

$selected ="admin";
$selector ="alert";
require("../common/header.php");

$day = date('Y-m-d', strtotime("-7 days"));

updateAlert();
?>

<br/>
 <div class="panel-group">
<!-- OUTPUT ALERT -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse4">
	  				<font style="color:gray">Újabb Kiadás</font>
	  			</a>
			</div>
			<div id="collapse4" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							sqlExecute(
						"SELECT a.id, a.type, a.param, a.param2, pr.name as prname,
						a.time, u.name, a.seen from alert a, user u, pallet p, product pr
						where u.id = a.user_id and a.deleted = false 
						and a.param2=p.id and p.product_id = pr.id and a.time > '".$day." 00:00:00' 
						and a.type='output' order by time desc ",
						'alertoutputTable');
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
	  				Selejtbe dobott áruk
	  			</a>
			</div>
			<div id="collapse5" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							sqlExecute(
						"SELECT a.id, a.type, a.param, a.param2, a.time,
						u.name, a.seen from alert a, user u 
						where u.id = a.user_id and a.deleted = false and a.time > '".$day." 00:00:00' 
						and a.type='trash' order by time desc ",
						'alertspareTable');
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		</div>
		
		<!-- INPUT ALERT -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse6">
	  				Hibás beérkezett áruk
	  			</a>
			</div>
			<div id="collapse6" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
				sqlExecute(
						"SELECT a.id, a.type, a.param, a.param2, a.time,
						u.name,a.seen from alert a, user u 
						where u.id = a.user_id and a.deleted = false and a.time > '".$day." 00:00:00' 
						and a.type='input' order by time desc ",
						'alertinputTable');
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

function alertinputTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Minőség id</th>';
	print '<th>Hibák</th>';
	print '<th>Beszállító</th>';
	print '<th>Mennyiség</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Üzenet</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		$data = json_decode($row["param2"],True);
		print '<td>';
		$supplier_id = 0;
		$amount = 0;
		$prod = 0;
		if($data != null){
			foreach ($data as $i => $value) {
					
				if(is_numeric($value) && (2 == (int)$value || 1 == (int)$value) && $i != 'product' &&
						$i != 'decision' && $i != 'supplier' && $i != 'amount'){
					print minosegmap($i,(int)$value).'<br/>';
					
				}
				
				if($i == 'supplier'){
					$supplier_id = $value;
				}
				if($i == 'amount'){
					$amount = $value;
				}
				if($i == 'product'){
					$prod = $value;
				}
			}
		}
		print '</td>';
		print '<td>'.suppnameFromId($supplier_id).'</td>';
		print '<td>'.$amount.'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td> <button class="btn btn-default btn-md" onclick="bootbox.alert('.mymessage($data,$row["time"],$prod).')">Üzenet</button></td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> </td>';
		}
		print '</tr>';
	}
	print '</table>';
}


function minosegmap($name,$i){
	$str = false;
	if($name === "appearance"){
		$str = "Kinézet";
	}else if($name === "consistency"){
		$str = "Állag";
	}else if($name === "smell"){
		$str = "Illat";
	}else if($name === "color"){
		$str = "Szín";
	}else if($name === "clearness"){
		$str = "Tisztaság Hőfok";
	}else if($name === "pallet_quality"){
		$str = "Raklap minőság";
	}else if($name === "sum_difference"){
		$str = "Súly különbség : ".strval($i);
		$i =0;
	}
	
	if($str){
		if($i === 1){
			$str .= " : Rossz";
		}else if($i === 2){
			$str .= " : Közepes";
		}else if($i === 3){
			$str .= " : Jó";
		}
	}
	return $str;
}







function mymessage($data,$time,$prod){

	
	
	
	$str = "'<h2>Tisztelt Beszállító Partnerünk!</h2>";
	$str .= "<br/>Szeretnénk tájékoztatni, hogy a ". substr($time, 0, 10)."-án ". substr($time, 11, 5)."-kor beszállított ".prodnameFromId($prod)." termék áruátvétele során az átvételre szakosított személyzet a következő problémákat találta:";
	$str .= "<ul>";
	if($data != null){
		foreach ($data as $i => $value) {

			if(is_numeric($value) && (2 == (int)$value || 1 == (int)$value) && $i != 'product' &&
				$i != 'decision' && $i != 'supplier' && $i != 'amount'){
					$str .= "<li>".minosegmap($i,(int)$value)." </li>";

			}
		}
	}
	
	$str .= "</ul>";
	$str .= "<br/>Szeretnénk kérni a hibásan küldött termék(ek) esetében cégünk illetékesével meghatározni a további teendőket.<br/>";
	$str .= "Üdvözlettel<br/><br/>";
	$str .= "K&K Family Kft.<br/><br/>'";
	return $str;
}

function alertoutputTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Kiadás id</th>';
	print '<th>Raklap id</th>';
	print '<th>Termék Név</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		print '<td>'.$row["param2"].'</td>';
		print '<td>'.$row["prname"].'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"> </td>';
		}
	
		print '</tr>';
	}
	print '</table>';
}

function alertspareTable($results){
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>Selejt id</th>';
	print '<th>Raklap id</th>';
	print '<th>Raktáros</th>';
	print '<th>Időpont</th>';
	print '<th>Láttam</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr';
		if($row["seen"] == '0' ){
			print " class='unseen' ";
		}
		print '>';
		print '<td>'.$row["param"].'</td>';
		print '<td>'.$row["param2"].'</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"> </td>';
		}
		print '</tr>';
	}
	print '</table>';
}


function updateAlert(){
	$day = date('Y-m-d', strtotime("-7 days"));
	$day2 =  date('Y-m-d', strtotime("-1 days"));
	$SQL = "UPDATE alert SET seen = '1' WHERE time >= '".$day." 00:00:00' and time < '".$day2." 00:00:00' and seen = '0'";
	update($SQL);
}

?>