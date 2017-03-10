<?php
$selected ="admin";
$selector = "storage";
require("../common/header.php");


if(isset($_GET["filter"]) && isset($_GET["id"]) && $_GET["id"] !== ""){
	if($_GET["filter"] == "prod"){
		listStorageByProduct($_GET["id"]);
	}
	if($_GET["filter"] == "cat"){
		listStorageByCategory($_GET["id"]);
	}
	
}else{
	sqlExecute(palletSQL3(""," GROUP BY pr_id "),'suppliesTable');
	listForChart();
}

?>

<!-- BAR CHART -->
<div class="container-fluid" id="barChartContainer">
	<canvas id="myBarChart" width="600" height="150">
		<script>
		var ctx = document.getElementById("myBarChart");
		var data = document.getElementById('storage_json').innerHTML; 
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
echo "<br/>...";
require("../common/footer.php");

function suppliesTable($results){
	
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr class="tableHeader">';
	print '<th>';
		productOptionStorage("");
	print '</th>';
	print '<th>';
		categoryOption("");
	print '</th>';
	print '</tr>';
	print '</thead>';
	print '</table>';
	
	print '<table class="table table-hover sortable">';
	print '<thead>';
	print '<tr>';
	print '<th>';
	
	print 'Alapanyag név</th>';
	print '<th>Mennyiség</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td>'.$row["product"].'</td>';
		print '<td>'.$row["rest"].'</td>';
		print '</tr>';
	}
	print '</table>';
}


function listForChart(){
	$labels = array();
	$data = array();
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL())){
			
		while($row = $results->fetch_assoc()) {
			if(in_array($row["product"],$labels))
			{
				$key = array_search($row["product"],$labels);
				$data[$key] = $data[$key]+(int)$row["rest"];
			}else{
				array_push($labels,$row["product"]);
				array_push($data,(int)$row["rest"]);
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
			
		print '<div id="storage_json" class="hiddendiv">'.$json_str.'</div>';
			
		$results->free();
	}
	else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
}

function listStorageByProduct($id){

	$filter  = "and pr.id = '".$id."' ";

	$labels = array();
	$data = array();
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL2($filter))){

		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr class="tableHeader">';
		print '<th>';
		productOptionStorage($id);
		print '</th>';
		print '<th>';
		categoryOption("");
		print '</th>';
		print '</tr>';
		print '</thead>';
		print '</table>';
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>ID</th>';
		print '<th>';
		print 'Alapanyag név</th>';
		print '<th>Beszállító Neve</th>';
		print '<th>Beérkezés ideje</th>';
		print '<th>Mennyiség</th>';
		print '<th>Raktáros</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
			array_push($labels,$row["product"]);
			array_push($data,(int)$row["rest"]);
				
			print '<tr>';
			print '<td>'.$row["id"].'</td>';
			print '<td>'.$row["product"].'</td>';
			print '<td>'.$row["supplier"].'</td>';
			print '<td>'.$row["time"].'</td>';
			print '<td>'.$row["rest"].'</td>';
			print '<td>'.$row["user"].'</td>';
			print '</tr>';
		}
		print '</table>';

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
			
		print '<div id="storage_json" class="hiddendiv">'.$json_str.'</div>';

		// Frees the memory associated with a result
		$results->free();

	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();

}

function listStorageByCategory($id){
	$filter  = "and pr.id = '".$id."' ";
	
	$labels = array();
	$data = array();
	$mysqli = connect();
	if($results = $mysqli->query(palletSQL2($filter))){
	
		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr class="tableHeader">';
		print '<th>';
		productOptionStorage("");
		print '</th>';
		print '<th>';
		categoryOption($id);
		print '</th>';
		print '</tr>';
		print '</thead>';
		print '</table>';
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';
		print '<th>ID</th>';
		print '<th>';
		print 'Alapanyag név</th>';
		print '<th>Beszállító Neve</th>';
		print '<th>Beérkezés ideje</th>';
		print '<th>Mennyiség</th>';
		print '<th>Raktáros</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {
			array_push($labels,$row["product"]);
			array_push($data,(int)$row["rest"]);
	
			print '<tr>';
			print '<td>'.$row["id"].'</td>';
			print '<td>'.$row["product"].'</td>';
			print '<td>'.$row["supplier"].'</td>';
			print '<td>'.$row["time"].'</td>';
			print '<td>'.$row["rest"].'</td>';
			print '<td>'.$row["user"].'</td>';
			print '</tr>';
		}
		print '</table>';
	
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
			
		print '<div id="storage_json" class="hiddendiv">'.$json_str.'</div>';
	
		// Frees the memory associated with a result
		$results->free();
	
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();
}

?>