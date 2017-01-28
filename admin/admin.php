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
		  	<div class="panel-body">
		  		A bevétel leírási adatokat lehetne ide írni.
		  	</div>
		  	<div class="row" style="width:95%">
		  		<div class="col-md-6-1">
		  			<table class="table">
				  		<tr>
					  		<td>
								<?php 											
									dailyInput();			
								?>
							</td>
						</tr>
		  			</table>
		  		</div>
		  		
		  		<div class="col-md-6-2">
		  			<div class="centerBlock">
			  			<canvas id="dailyInputChart" width="300" height="270">
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
		                                display: true
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
	  	<div id="collapse2" class="panel-collapse collapse">
		  	<div class="panel-body">
		  		A kiadási adatokat lehetne ide írni.
		  	</div>
		  	<div class="row" style="width:95%">
		  		<div class="col-md-6-1">
				  	<table class="table">
				  		<tr>
					  		<td>
								<?php 			
									dailyOutput();
								?>
							</td>
						</tr>
				  	</table>
				</div>
		  	<div class="col-md-6-2">
		  		<div class="centerBlock">
			  			<canvas id="dailyOutputChart" width="300" height="270">
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
		                                display: true
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
		  	<div class="panel-body">
		  		lejáró termékek statisztikáit lehetne ide írni
		  	</div>
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
	</div>

<?php 
require("../common/footer.php");
?>