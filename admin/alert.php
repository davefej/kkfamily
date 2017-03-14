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
	  				Selejbe dobott áruk
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
		if($data != null){
			foreach ($data as $i => $value) {
					
				if(is_numeric($value) && (2 == (int)$value || 1 == (int)$value) && $i != 'product'){
					print minosegmap2($i).': '.minosegmap((int)$value).'<br/>';
				}
			}
		}
		print '</td>';
		print '<td>'.$row["name"].'</td>';
		print '<td>'.$row["time"].'</td>';
		print '<td> <button class="btn btn-default btn-md" onclick="bootbox.alert('.mymessage($data).')">Üzenet</button></td>';
		if($row["seen"] == '0' ){
			print '<td><button class="btn btn-sm btn-danger" onclick="updateAlert('.$row["id"].')">OK</button></td>';
		}else{
			print '<td> <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> </td>';
		}
		print '</tr>';
	}
	print '</table>';
}


function minosegmap($i){
	if($i === 1){
		return "Rossz";
	}else if($i === 2){
		return "Közepes";
	}else if($i === 3){
		return "OK";
	}else{
		return '';
	}
}

function minosegmap2($i){
	if($i === "appearance"){
		return "Kinézet";
	}else if($i === "consistency"){
		return "Állag";
	}else if($i === "smell"){
		return "Illat";
	}else if($i === "color"){
		return "Szín";
	}else if($i === "clearness"){
		return "Tisztaság Hőfok";
	}else if($i === "pallet_quality"){
		return "Raklap minőság";
	}else{
		return '';
	}
}



function mymessage($data){
	$str = "'<h2>Kedves Ügyfelünk!</h2>";
	$str .= "<br/>Rossz minőségű árut szállítottak üzemünkbe.";
	$str .= "<br/>Az áruval alábbi problémáink voltak:<br/>";
	$str .= "<ul>";
	if($data != null){
		foreach ($data as $i => $value) {

			if(is_numeric($value) && (2 == (int)$value || 1 == (int)$value) && $i != 'product'){
				$str .= "<li>".minosegmap2($i)." : ".minosegmap((int)$value)." </li>";

			}
		}
	}
	$str .= "</ul>";
	$str .= "<p>Az áruátvételt megtagadtuk</p>";

	$str .= "Üdvözlettel<br/><br/>";
	$str .= "KKFAMILY<br/><br/>'";
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