<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
      		<a class="navbar-brand" href="#">KK Family</a>
    	</div>
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li <?php if($selector =="bevetel"){ echo "class=\"active\"";} ?> ><a href="bevetel.php">Áruhozzáadás<span class="sr-only">(current)</span></a></li>
				<li <?php if($selector =="kiadas"){ echo "class=\"active\"";} ?> ><a href="kiadas.php">Árukiadás</a></li>
				<li <?php if($selector =="spare"){ echo "class=\"active\"";} ?> ><a href="spare.php">Árueltávolítás</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../index.php">Kijelentkezés</a></li>
			</ul>
			<?php
			if($selector == "kiadas"){
				echo "	<form class=\"navbar-form navbar-right\">
							<div class=\"form-group\">
								<input type=\"text\" class=\"form-control\" placeholder=\"Keresés\">
							</div>
						</form>";
			}
				
			?>
			
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>