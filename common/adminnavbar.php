<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		<a class="navbar-brand" href="admin.php">KK Family Admin felület</a>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	    </button>
			<a class="navbar-brand" href="admin.php"><img alt="KK Family" src="../img/kkfamily_logo.png"></a>
		</div>
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-left">
				<li <?php if($selector == "product"){ echo "class=\"active\"";} ?>><a href="product.php">Alapanyagok</a></li>
				<li <?php if($selector == "supplier"){ echo "class=\"active\"";} ?>><a href="supplier.php">Beszállítók</a></li>
				<li <?php if($selector == "category"){ echo "class=\"active\"";} ?>><a href="category.php">Kategória</a></li>
				<li <?php if($selector == "storage"){ echo "class=\"active\"";} ?>><a href="storage.php">Raktár</a></li>
				<li <?php if($selector == "input"){ echo "class=\"active\"";} ?>><a href="input.php">Bevétel</a></li>
				<li <?php if($selector == "output"){ echo "class=\"active\"";} ?>><a href="output.php">Kiadás</a></li>
			</ul>

			<!-- <form class="navbar-form navbar-left">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Keresés">
				</div>
			</form> -->

			<ul class="nav navbar-nav navbar-right">
				<li><a href="../index.html">Kijelentkezés</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
