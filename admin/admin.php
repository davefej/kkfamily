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
	  		<a href="input.php">
	  			Részletek
	  		</a>
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
	  		<a href="output.php">
	  			Részletek
	  		</a>
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
	  
	  <!-- SOON BE EXPIRED PRODUCTS -->
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
							listUser();
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		</div>
	



	<!-- WORKERS / USERS -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#collapse5">
	  				Fogyási statisztika
	  			</a>
			</div>
			<div id="#collapse5" class="panel-collapse collapse in">
			  	<table class="table">
			  		<tr>
			  		<td>
						<div id="adminstatisticcontainer">
						<?php 			
							
								$day  = date("Y-m-d");
								$day2 = date('Y-m-d', strtotime("-30 days"));
								$dw = date( "w");
								$dw = $dw -1;
								if($dw == -1){
									$dw = 6;
								}
								outputStatistic($dw,$day,$day2);
							
						?>
						</div>
					</td>
				</tr>
			  	</table>
			</div>
		
	</div>

	

<?php 
require("../common/footer.php");
?>