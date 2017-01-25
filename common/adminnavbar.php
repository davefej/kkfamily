<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		<a class="navbar-brand" href="admin.php">KK Family Admin felület</a>
		</div>
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-left">
				<li <?php if($selector == "alapanyag"){ echo "class=\"active\"";} ?>><a href="alapanyag.php">Beszállítók</a></li>
				<li <?php if($selector == "beszallito"){ echo "class=\"active\"";} ?>><a href="beszallito.php">Alapanyagok</a></li>
			</ul>
			<form class="navbar-form navbar-left">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Keresés">
				</div>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.html">Kijelentkezés</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>