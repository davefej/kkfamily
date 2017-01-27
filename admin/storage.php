<?php
$selected ="admin";
$selector = "storage";
require("../common/header.php");

listStore();
?>

<!-- BAR CHART -->
<!-- TODO: Dinamikussá tenni a grafikonokat -->
<div class="container-fluid" id="barChartContainer">
	<canvas id="myBarChart" width="600" height="300">
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