<?php
$selected ="admin";
require("header.php");
?>
  
  <div class="panel-group">
	  <div class="panel panel-info">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse1">
	  			Napi bevétel (Raktár)
	  		</a>
	  	</div>
	  	<div id="collapse1" class="panel-collapse collapse in">
		  	<div class="panel-body">
		  		A bevétel leírási adatokat lehetne ide írni.
		  	</div>
		  	<div class="row" style="width:95%">
		  		<div class="col-md-6">
		  			<table class="table">
				  		<tr>
					  		<td>
								<div>
								<?php 			
									require('helper/mysqli.php');
									listnapibevetel();			
								?>
								</div>
							</td>
						</tr>
		  			</table>
		  		</div>
		  		
		  		<div class="col-md-6">
		  			<div class="centerBlock">
			  			<canvas id="myDoughnutChart" width="300" height="280">
		                    <script>
		                    //TODO: dinamikussá tenni.
		                        var ctx = document.getElementById("myDoughnutChart");
		                        var data = {
		                            labels: [
		                                "Káposzta",
		                                "Saláta",
		                                "Répa",
		                                "Cékla",
		                                "Uborka"
		                            ],
		                            datasets: [
		                                {
		                                    data: [14, 9, 4, 2, 0],
		                                    backgroundColor: [
		                                        "#FF6384",
		                                        "#36A2EB",
		                                        "#FFCE56",
		                                        "#93ff93",
		                                        "#e397ff"
		                                    ],
		                                    hoverBackgroundColor: [
		                                        "#FF6384",
		                                        "#36A2EB",
		                                        "#FFCE56",
		                                        "#93ff93",
		                                        "#e397ff"
		                                    ]
		                                }]
		                        };
		                        var myDoughnutChart = new Chart(ctx, {
		                            type: 'doughnut',
		                            data: data,
		                            options: {
		                                responsive: false,
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
	  
	  <div class="panel panel-info">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse2">
	  			Napi Kiadás (Raktár)
	  		</a>
	  	</div>
	  	<div id="collapse2" class="panel-collapse collapse">
		  	<div class="panel-body">
		  		A kiadási adatokat lehetne ide írni.
		  	</div>
		  	<table class="table">
		  		<tr>
			  		<td>
						<div>
						<?php 			
							listnapikiadas();
						?>
						</div>
					</td>
				</tr>
		  	</table>
		 </div>
	  </div>
	  
	  <div class="panel panel-danger">
	  	<div class="panel-heading">
	  		<a data-toggle="collapse" href="#collapse3">
	  			Hamarosan Lejáró Termékek
	  		</a>
	  	</div>
	  	<div id="collapse3" class="panel-collapse collapse">
		  	<div class="panel-body">
		  		lejáró termékek statisztikáit lehetne ide írni
		  	</div>
		  	<table class="table">
		  		<tr>
			  		<td>
						<div>
						<?php 			
							listlejar();
						?>
						</div>
					</td>
				</tr>
		  	</table>
		  </div>
		</div>
		
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse4">
	  				Munkások Statisztikái
	  			</a>
			</div>
			<div id="collapse4" class="panel-collapse collapse">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div>
						<?php 			
							listlejar();
						?>
						</div>
					</td>
				</tr>
			  	</table>
			  	
			</div>
		</div>
	</div>
<?php 
require("footer.php");
?>