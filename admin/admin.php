<?php
$selected ="admin";
$selector ="admin";
require("../common/header.php");
?>
  
  <div class="panel-group">
	  
	  <!-- DAILY INPUT -->
	  <div class="panel panel-info">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse1">
	  			Napi bevétel (Raktár)
	  		</a>
	  		&nbsp;&nbsp;&nbsp;&nbsp;
	  		<button type="button" class="btn btn-primary">
		  			<a class="details" href="input.php">Részletek</a>
	  		</button>
	  	</div>
	  	<div id="collapse1" class="panel-collapse collapse in">
		  	<div class="row" style="width:95%">
		  		<div class="col-md-6-1" style="padding-top: 10px" >
					<?php 											
						dailyInput();			
					?>
		  		</div>
		  		
		  		<div class="col-md-6-2">
		  			<div class="centerBlock">
			  			<canvas id="dailyInputChart" width="300" height="250">
		                    <script>
		                        var ctx = document.getElementById("dailyInputChart");
		                        var data = document.getElementById('dailyInput_json').innerHTML;

		                        try{
		                			data = JSON.parse(data);
		                		}catch(err){
		                			cosole.log(err);
		                		}
		                        
		                        var myDoughnutChart = new Chart(ctx, {
		                            type: 'doughnut',
		                            data: data,
		                            options: {
		                                legend: {
		                                display: false
		                                },
		                                title: {
		                                    display: true,
		                                    text: 'Raktárkészlet',
		                                    fontColor: "#FFFFFF",
		                                    fontSize: 18
		                                }
		                            }
		                        });
		                    </script>
		                </canvas>
	                </div>
		  		</div>
		  	</div>
		  </div>
		</div>
	  
	  <!-- DAILY OUTPUT -->
	  <div class="panel panel-info">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse2">
	  			Napi Kiadás (Raktár)
	  		</a>
	  		&nbsp;&nbsp;&nbsp;&nbsp;
	  		<button type="button" class="btn btn-primary">
		  			<a class="details" href="output.php">Részletek</a>
	  		</button>
	  	</div>
	  	<div id="collapse2" class="panel-collapse collapse in">
		  	<div class="row" style="width:95%">
		  		<div class="col-md-6-1" style="padding-top: 10px"> 
					<?php 			
						dailyOutput();
					?>
				</div>
		  	<div class="col-md-6-2">
		  		<div class="centerBlock">
			  			<canvas id="dailyOutputChart">
		                    <script>
		                        var ctx = document.getElementById("dailyOutputChart");
		                        var data = document.getElementById('dailyOutput_json').innerHTML;

		                        try{
		                			data = JSON.parse(data);
		                		}catch(err){
		                			cosole.log(err);
		                		}
		                        
		                        var myDoughnutChart = new Chart(ctx, {
		                            type: 'doughnut',
		                            data: data,
		                            options: {
		                                legend: {
		                                display: false
		                                },
		                                title: {
		                                    display: true,
		                                    text: 'Raktárkészlet',
		                                    fontColor: "#FFFFFF",
		                                    fontSize: 18
		                                }
		                            }
		                        });
		                    </script>
		                </canvas>
	           </div>
		  	</div>
		 </div>
	  </div>
	  </div>
	  
	  
	  
	  
	 
		
		<!-- WORKERS / USERS -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse4">
	  				Munkások
	  			</a>
			</div>
			<div id="collapse4" class="panel-collapse collapse">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							sqlExecute("SELECT * from user where deleted = false",'UserTable');
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		</div>
	

	<!-- STATISTICS -->
	  <div class="panel panel-danger">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapsed6">
	  				Fogyásban lévő termékek
	  			</a>
			</div>
			<div id="collapsed6" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div id="adminstatisticcontainer">
						<?php 			
							
								outOfStock();
							
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
	</div>
</div>

	  <div class="panel panel-danger">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse3">
	  			Hamarosan Lejáró Termékek
	  		</a>
	  	</div>
	  	<div id="collapse3" class="panel-collapse collapse">
		  	<table class="table">
		  		<tr>
			  		<td>
						<div>
						<?php 			
							listOld();
						?>
						</div>
					</td>
				</tr>
		  	</table>
		  </div>
		</div>

	
<?php 
require("../common/footer.php");

function dailyInput(){
	$labels = array();
	$data = array();

	$mysqli = connect();
	if($results = $mysqli->query(
			"SELECT p.id as id, pr.name as product, s.name as supplier, sum(p.amount) as amount
	 				FROM supplier s, pallet p, product pr
				where pr.id=p.product_id and p.supplier_id = s.id

				 and p.time >= CURDATE()  and p.deleted = false and pr.deleted = false
			group by pr.id
			order by supplier")){

			$str = '<table class="table table-hover sortable">';
			$str .= '<thead>';
			$str .= '<tr>';
			$str .= '<th>Alapanyag</th>';
			$str .= '<th>Beszállító Neve</th>';
			$str .= '<th>Mennyiség</th>';

			$str .= '</tr>';
			$str .= '</thead>';

			$i = false;
			while($row = $results->fetch_assoc()) {
				if(in_array($row["product"],$labels))
				{
					$key = array_search($row["product"],$labels);
					$data[$key] = $data[$key]+(int)$row["amount"];
				}else{
					array_push($labels,$row["product"]);
					array_push($data,(int)$row["amount"]);
				}

				$str .= '<tr>';
				$str .= '<td>'.$row["product"].'</td>';
				$str .= '<td>'.$row["supplier"].'</td>';
				$str .= '<td>'.$row["amount"].'</td>';
					
				$str .= '</tr>';
				$i = true;

			}
			$str .= '</table>';

		 if($i){
		 	print $str;
		 }
		 else{
		 	print '<div class="alert alert-danger text-center centerBlock" role="alert" style="width: 90%"><strong>Ma még nem érkezett be semmi a raktárba</strong></div>';
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

		 $hoverBackgroundColor = array();
		 for($i=0; $i < count($labels); $i++){
		 	$num = $i%count($colors);
		 	array_push($hoverBackgroundColor,$colors[$num]);
		 }

		 $datasets = array(
		 		"data" => $data,
		 		"backgroundColor" => $backgroundColor,
		 		"hoverBackgroundColor" => $hoverBackgroundColor
		 );
		 $datasetsarray = array($datasets);
		 $json = array(
		 		"labels" => $labels,
		 		"datasets" => $datasetsarray
		 );

		 $json_str = json_encode($json,True);

		 print '<div id="dailyInput_json" class="hiddendiv">'.$json_str.'</div>';

		 // Frees the memory associated with a result
		 $results->free();
	}else{
		print "hiba";
		print mysqli_error($mysqli);
	}
	// close connection
	$mysqli->close();
}



function dailyOutput(){
	$labels = array();
	$data = array();

	$mysqli = connect();
	if($results = $mysqli->query(
				
			"SELECT p.id as id, pr.name as product, sum(o.amount) as amount
 				FROM  pallet p, product pr, output o
			where pr.id=p.product_id and o.pallet_id = p.id
			 and o.time >= CURDATE() and p.deleted = false and pr.deleted = false and o.deleted = false
			group by pr.id order by product")){

			$str =  '<table class="table table-hover sortable">';
			$str .= '<thead>';
			$str .= '<tr>';

			$str .= '<th>Alapanyag</th>';
			$str .= '<th>Mennyiség</th>';


			$str .= '</tr>';
			$str .= '</thead>';
			$i =false;

			while($row = $results->fetch_assoc()) {
				if(in_array($row["product"],$labels))
				{
					$key = array_search($row["product"],$labels);
					$data[$key] = $data[$key]+(int)$row["amount"];
				}else{
					array_push($labels,$row["product"]);
					array_push($data,(int)$row["amount"]);
				}
				$str .= '<tr>';

					
				$str .= '<td>'.$row["product"].'</td>';
				$str .= '<td>'.$row["amount"].'</td>';
					
					

				$str .= '</tr>';
				$i = true;
			}

			$str.= "</table>";
		 if($i){
		 	print $str;
		 	 
		 }else{
		 	print ('<div class="alert alert-danger text-center centerBlock" role="alert"
		 	style="width: 90%"><strong>Ma még semmmit nem adtak ki a raktárból</strong></div>');
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

		 $hoverBackgroundColor = array();
		 for($i=0; $i < count($labels); $i++){
		 	$num = $i%count($colors);
		 	array_push($hoverBackgroundColor,$colors[$num]);
		 }

		 $datasets = array(
		 		"data" => $data,
		 		"backgroundColor" => $backgroundColor,
		 		"hoverBackgroundColor" => $hoverBackgroundColor
		 );
		 $datasetsarray = array($datasets);
		 $json = array(
		 		"labels" => $labels,
		 		"datasets" => $datasetsarray
		 );

		 $json_str = json_encode($json,True);

		 print '<div id="dailyOutput_json" class="hiddendiv">'.$json_str.'</div>';

		 $results->free();
	}else{
		print mysqli_error($mysqli);
		print ("HIBA");
	}

	$mysqli->close();
}


function UserTable($results){
	print '<table class="table table-hover">';
	print '<thead>';
	print '<tr>';
	print '<th>Felhasználó Név</th>';
	print '<th>Jogosultság</th>';
	print '<th>Szerkeszt</th>';
	print '<th><button class="btn btn-sm btn-default" id="newRetailer" onclick="createUser()">Új Felhasználó</button></th>';
	print '<th>Törlés</th>';
	print '</tr>';
	print '</thead>';
	while($row = $results->fetch_assoc()) {
		print '<tr>';
		print '<td id="username_'.$row["id"].'">'.$row["name"].'</td>';
		if($row["type"] === "0"){
			print '<td id="usertype_'.$row["id"].'">Admin</td>';
		}else if($row["type"] === "1"){
			print '<td id="usertype_'.$row["id"].'">Raktáros</td>';
		}
		print '<td><button class="btn btn-sm btn-default" onclick="editUserName('.$row["id"].')">Név Szerkeszés</button></td>';
		print '<td><button class="btn btn-sm btn-default" onclick="editUserPass('.$row["id"].')">Új Jelszó</button></td>';
		print '<td><button class="btn btn-sm btn-danger" onclick="deleteUser('.$row["id"].')">Törlés</button></td>';
		print '</tr>';
	}
	print '</table>';

}

function outOfStock(){

	$mysqli = connect();
	$prodstock = array();
	if($results = $mysqli->query(palletSQL3(""," GROUP BY pr_id "))){
		while($row = $results->fetch_assoc()) {
			$prodstock[$row["pr_id"]] = $row["rest"];
		}
		$results->free();
	}

	if($results = $mysqli->query("SELECT id,minimum,name from product where deleted = false and minimum > 0")){
		print '<table class="table table-hover sortable">';
		print '<thead>';
		print '<tr>';

		print '<th>Alapanyag név</th>';
		print '<th>Jelzés szint</th>';
		print '<th>Mennyiség</th>';
		print '</tr>';
		print '</thead>';
		while($row = $results->fetch_assoc()) {

			if(array_key_exists($row["id"],$prodstock))
			{
				if((int)$row["minimum"] > (int)$prodstock[$row["id"]]){
					print '<tr>';
					print '<td>'.$row["name"].'</td>';
					print '<td>'.$row["minimum"].'</td>';
					print '<td>'.$prodstock[$row["id"]].'</td>';
					print '</tr>';
				}

			}else{
				print '<tr>';
				print '<td>'.$row["name"].'</td>';
				print '<td>'.$row["minimum"].'</td>';
				print '<td>0</td>';
				print '</tr>';
			}
		}
		print '</table>';
		$results->free();
	}else{
		print mysqli_error($mysqli);
		print "hiba";
	}
	// close connection
	$mysqli->close();

}



?>