<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
      		<a class="navbar-brand" href=""><img alt="KK Family" src="../img/kkfamily_logo.png"></a>
    	</div>
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li <?php if($selector =="bevetel"){ echo "class=\"active\"";} ?> ><a href="bevetel.php">BEVÉTEL<span class="sr-only">(current)</span></a></li>
				<li <?php if($selector =="kiadas"){ echo "class=\"active\"";} ?> ><a href="kiadas.php">KIADÁS</a></li>
				<li <?php if($selector =="spare"){ echo "class=\"active\"";} ?> ><a href="spare.php">SELEJT</a></li>
				<li <?php if($selector =="openqr"){ echo "class=\"active\"";} ?> ><a href="openqr.php">QR CODE</a></li>
				<li <?php if($selector =="idkiadas"){ echo "class=\"active\"";} ?> ><a href="idkiadas.php">ID BEÍRÁS</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../logout.php">Kijelentkezés</a></li>
			</ul>		
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>