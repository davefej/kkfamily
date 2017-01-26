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
		
			/*{
			    labels: ["Sárga Répa", "Zeller", "Fejes Káposzta", "Fehér Répa", "Petrezselyem", "Saláta", "Paradicsom"],
			    datasets: [
			        { 
			            label: "Raktárkészletek",
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			                'rgba(255, 206, 86, 0.8)',
			                'rgba(75, 192, 192, 0.8)',
			                'rgba(153, 102, 255, 0.8)',
			                'rgba(255, 159, 64, 0.8)'
			            ],
			            borderWidth: 0,
			            data: [65, 59, 80, 81, 56, 55, 40],
			        }
			    ]
			};*/
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