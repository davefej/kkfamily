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
			<a class="navbar-brand" href="admin.php"><img alt="KK Family" src="../img/kkfamily_logo.png"></a>
		</div>
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-left">
				<li <?php if($selector == "product"){ echo "class=\"active\"";} ?>><a href="product.php">Alapanyag</a></li>
				<li <?php if($selector == "supplier"){ echo "class=\"active\"";} ?>><a href="supplier.php">Beszállító</a></li>
				<li <?php if($selector == "category"){ echo "class=\"active\"";} ?>><a href="category.php">Kategória</a></li>
				<li <?php if($selector == "storage"){ echo "class=\"active\"";} ?>><a href="storage.php">Raktár</a></li>
				<li <?php if($selector == "input"){ echo "class=\"active\"";} ?>><a href="input.php">Bevétel</a></li>
				<li <?php if($selector == "output"){ echo "class=\"active\"";} ?>><a href="output.php">Kiadás</a></li>
				<li <?php if($selector == "spare"){ echo "class=\"active\"";} ?>><a href="spare.php">Selejt</a></li>				
				<li <?php if($selector == "alert"){ echo "class=\"active\"";} ?>><a id='alerta'  href="alert.php">Jelzés</a></li>
				<li <?php if($selector == "inventory"){ echo "class=\"active\"";} ?>><a href="inventory.php">Leltár</a></li>
				<li <?php if($selector == "statistics"){ echo "class=\"active\"";} ?>><a href="statistics.php">Napi feladás</a></li>
				<li <?php if($selector == "quality"){ echo "class=\"active\"";} ?>><a href="quality.php">Minőség</a></li>
				<li <?php if($selector == "supply"){ echo "class=\"active\"";} ?>><a href="supply.php">Készlet</a></li>
				<li <?php if($selector == "print"){ echo "class=\"active\"";} ?>><a href="print.php">Nyomtatás</a></li>
				<li <?php if($selector == "follow"){ echo "class=\"active\"";} ?>><a href="follow.php">Követés</a></li>
				
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="../logout.php">Kilépés</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div class="raktarlogin">

<?php 
$log = lastlog();
echo $log["user"];
echo '<br>';
echo $log["day"];
?>
</div>
