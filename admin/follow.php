<?php
$selected ="admin";
$selector ="follow";
require("../common/header.php");
	
?>

<div class="followtop">
<br/>
<input placeholder="ID" type="number" id="followpalletid" <?php if(isset($_GET["id"])){echo "value='".$_GET["id"]."'";} ?> >
<button class="btn btn-sm btn-default" onclick="follow()" >Raklap Követés</button><br/><br/>

<?php 
	
	$prodid = "";
	if(isset($_GET["prodid"])){
		$prodid = ($_GET["prodid"]);
	}
	
	echo "<div class='followdate'>";
	echo datepicker("", "", "", "_from");
	echo datepicker("", "", "", "_to");
	echo "<div>".productOptionStorage2($prodid)."</div>";
	echo "</div>"
	?>
&nbsp;&nbsp;<button class="btn btn-sm btn-default" onclick="followProd()" >Termék Követés</button>
</div>

<?php 
if(isset($_GET["id"])){
	$mysqli = connect();
	$id = $_GET["id"];
	
	$sql = "SELECT p.id as id, p.time as time, u.name as user, p.amount as amount, s.name as supp,pr.unit as unit,
		pr.name as prod,p.deleted as deleted from pallet p, supplier s, product pr, user u where
		pr.id = p.product_id and s.id = p.supplier_id and u.id = p.user_id and p.id = '".$id."'";
	$match = false;
	$deleted = false;
	
	$data = array();
	$sum = 0;
	$creation = array();
	if($results = $mysqli->query($sql)){
		while($row = $results->fetch_assoc()) {
			
			$match = true;
			if($row["deleted"] == "1"){
				$deleted = true;
			}
			$sum = (int)$row['amount'];
			$creation = $row;
			break;
		}
		$results->free();
		
	}else{
		print mysqli_error($mysqli);
		print "nincs adatbázis kapcsolat";
	}
	
	
	$actions = array();
	
	if($match){
		if($results = $mysqli->query("
				SELECT p.id as id, pr.name as prod, o.amount as amount, o.time as time,
				u.name as user,o.deleted FROM  pallet p, product pr, output o, user u, supplier s 
			where pr.id=p.product_id and o.pallet_id = p.id and o.user_id = u.id
			 and s.id = p.supplier_id  and p.id = '".$id."' order by time
			")){
		
			while($row = $results->fetch_assoc()) {
				$row["action"] = "Kiadás";
				$sum -= (int)$row['amount'];
				array_push($actions,$row);
			}
		
			$results->free();
		}else{
			print mysqli_error($mysqli);
			print "nincs adatbázis kapcsolat";
		}
		
		if($results = $mysqli->query("
				SELECT p.id as id, pr.name as prod, t.amount as amount, t.time as time,
				u.name as user,t.deleted FROM  pallet p, product pr, trash t, user u, supplier s
			where pr.id=p.product_id and t.pallet_id = p.id and t.user_id = u.id
			 and s.id = p.supplier_id  and p.id = '".$id."'
			 and pr.deleted = false order by time
			")){
		
					while($row = $results->fetch_assoc()) {
						$row["action"] = "Selejt";
						$sum -= (int)$row['amount'];
						array_push($actions,$row);
					}
		
					$results->free();
		}else{
			print mysqli_error($mysqli);
			print "nincs adatbázis kapcsolat";
		}
		
		
		
		
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>BEVÉTEL</th>';
		print '<th>'.$creation['time'].'</th>';
		print '<th>'.$creation['amount'].' '.$creation['unit'].'</th>';
		print '<th>'.$creation['prod'].'</th>';
		print '<th>'.$creation['supp'].'</th>';
		print '<th>'.$creation['user'].'</th>';
		print '</tr>';
		print '</thead>';
		
		
		
		usort($actions, "mysort");
		$i = 0;
		while(count($actions) > 0 && $i < 1000) {
			$a = array_shift($actions);
			print '<tr>';
			print '<td>'.$a['action'].'</td>';
			print '<td>'.$a['time'].'</td>';
			print '<td>'.$a['amount'].' '.$creation['unit'].'</td>';
			print '<td></td>';
			print '<td></td>';
			print '<td>'.$a['user'].'</td>';
			print '</tr>';
			
			$i++;
		}
		if($deleted){
			print '<thead>';
			print '<tr>';
			print '<th>Állapot:</th>';
			print '<th colspan="5">TÖRÖLVE</th>';
			print '</tr>';
			print '</thead>';	
		}else{
			print '<thead>';
			print '<tr>';
			print '<th>Állapot:</th>';
			if($sum <= 0){
				print '<th colspan="5">Ki lett adva</th>';
			}else{
				print '<th colspan="5">Raktárban: '.strval($sum)." ".$creation['unit'].'</th>';
			}
			
			print '</tr>';
			
		}
		print '</table>';
		
		
		
		
	}else{
		print "NINCS ILYEN IDjú RAKLAP";
	}
	
	
	
	$mysqli->close();
	
}else if(isset($_GET["prodid"]) && isset($_GET["from"]) && isset($_GET["to"]) && isset($_GET["diff"])){
	$mysqli = connect();
	$id = $_GET["prodid"];
	$idfiler = "and pr.id = '".$id."' ";
	$weekday = date("w");
	$weekday = $weekday -1;
	if($weekday == -1){
		$weekday = 6;
	}
	
	$labels = array();
	$data = array();
	$labels2 = array();
	$outputs = array();
	$prodname ="";
	
	if((int) $_GET["diff"] < 13){
		$backdays = 1;
	}else if((int) $_GET["diff"] < 37){
		$backdays = 3;
	}else if((int) $_GET["diff"] < 370){
		$backdays = 30;
	}else if((int) $_GET["diff"] < 4500){
		$backdays = 365;
	}else{
		echo "Túl nagy időtáv";
	}
	
	for($i=12; $i>=0; $i--){
		$back = ($i)*$backdays-1;
		$currdate = date('Y-m-d', strtotime($_GET["to"]." -".$back." days"));
		if(strtotime('now') < strtotime($_GET["to"])){
			//FutuRE
			continue;
		}
		$back2 = ($i+1)*$backdays-1;
		$currdate2 = date('Y-m-d', strtotime($_GET["to"]." -".$back2." days"));
		
		
		$timefilter = " and time < '".$currdate." 00:00:00' ";
		
		if($results = $mysqli->query(supplySQL($timefilter,$idfiler))){
			$nores = true;
			while($row = $results->fetch_assoc()) {
				$prodname = $row["product"];
				array_push($labels,$currdate);
				array_push($data,(int)$row["rest"]);
				$nores = false;
				//print $row['rest']."<br/> ";
			}
			if($nores){
				array_push($labels,$currdate);
				array_push($data,0);
			}
			$results->free();
		
		}else{
			print mysqli_error($mysqli);
			print "nincs adatbázis kapcsolat";
		}
		
		if($results = $mysqli->query(inputSql("and o.time < '".$currdate." 23:59:59' and o.time > '".$currdate2." 00:00:00' ",$id))){
			$nores = true;
			
			array_push($labels2,$currdate2." -> ".$currdate);
			while($row = $results->fetch_assoc()) {
				$nores = false;
				array_push($outputs,(int)$row['amount']);				
			}
			if($nores){
				array_push($outputs,0);
			}
			$results->free();
		
		}else{
			print mysqli_error($mysqli);
			print "nincs adatbázis kapcsolat";
		}
		

	}
	
	
	
	$colors = array( 'rgba(255, 99, 132, 0.8)',
			'rgba(54, 162, 235, 0.8)',
			'rgba(255, 206, 86, 0.8)',
			'rgba(75, 192, 192, 0.8)',
			'rgba(153, 102, 255, 0.8)');
		
	$backgroundColor = array();
	for($i=0; $i < count($labels); $i++){
		$num = $i%count($colors);
		array_push($backgroundColor,$colors[$num]);
	}
		
	$datasets = array(
			"label" => "Raktárkészletek",
			"backgroundColor" => $backgroundColor,
			"borderWidth" => 0,
			"data" => $data
	);
	$datasetsarray = array($datasets);
	$json = array(
			"labels" => $labels,
			"datasets" => $datasetsarray
	);
		
	$json_str = json_encode($json,True);
		
	print '<div id="follow_json" class="hiddendiv">'.$json_str.'</div>';
	
	for($i=0; $i < count($labels2); $i++){
		$num = $i%count($colors);
		array_push($backgroundColor,$colors[$num]);
	}
	
	$datasets = array(
			"label" => "Raktárkészletek",
			"backgroundColor" => $backgroundColor,
			"borderWidth" => 0,
			"data" => $outputs
	);
	$datasetsarray = array($datasets);
	$json = array(
			"labels" => $labels2,
			"datasets" => $datasetsarray
	);
	
	$json_str = json_encode($json,True);
	print '<div id="follow_json_outputs" class="hiddendiv">'.$json_str.'</div>';
	print '<h1 align="center">'.$prodname.' - készlet</h1>';
	?>
<div class="container-fluid" id="barChartContainer">
	<canvas id="myBarChart" width="600" height="150">
		<script>
		var ctx = document.getElementById("myBarChart");
		var data = document.getElementById('follow_json').innerHTML; 
		try{
			data = JSON.parse(data);
		}catch(err){
			cosole.log(err);
		}
		
		var myBarChart = new Chart(ctx, {
			type: 'bar',
		    data: data,
		    options: {
		    	legend: {
                    display: false
                },
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
	        
	    });
		</script>
	</canvas>
</div>

	<h1 align="center"><?php echo $prodname;?> - kiadások</h1>
<div class="container-fluid" id="barChartContainer2">
	<canvas id="myBarChart2" width="600" height="150">
		<script>
		var ctx = document.getElementById("myBarChart2");
		var data = document.getElementById('follow_json_outputs').innerHTML; 
		try{
			data = JSON.parse(data);
		}catch(err){
			cosole.log(err);
		}
		
		var myBarChart = new Chart(ctx, {
			type: 'bar',
		    data: data,
		    options: {
		    	legend: {
                    display: false
                },
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
	        
	    });
		</script>
	</canvas>
</div>
	
	
	<?php 
}

require("../common/footer.php");

function mysort($a, $b) {
	return strcmp($a['time'],$b['time']);
	
}
?>