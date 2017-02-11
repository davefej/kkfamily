<?php
$selected ="admin";
$selector = "storage";
require("../common/header.php");


if(isset($_GET["filter"])){
	if($_GET["filter"] == "prod"){
		listStorage($_GET["id"]);
	}
	
}else{
	getSupplies("");
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
?>