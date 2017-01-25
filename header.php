
<html>
	<head>
		<?php
			if($selected == "admin")
				echo "<title> Kezelőfelület | KK Family</title>";
			else if($selector == "kiadas")
				echo "<title> Kiadás | KK Family</title>";
			else if($selector == "bevetel")
				echo "<title> Bevétel | KK Family</title>";
		?>
		<meta http-equiv="cache-control" content="max-age=0" />
	  	<meta http-equiv="cache-control" content="no-cache" />
	  	<meta http-equiv="expires" content="0" />
	  	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	  	<meta http-equiv="pragma" content="no-cache" />
		<meta charset="utf-8">
		
		
		
		<?php 
			if($selected == "admin"){
				echo"	<link href=\"js/bootstrap-3.3.7-dist/css/bootstrap.min.css\" rel=\"stylesheet\">
						<link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css?v=<?php echo rand();?>\">
						<script src=\"js/jquery1.9.1.js\" ></script>
						<script src=\"js/bootbox.js\" ></script>
						<script src=\"js/functions.js\" ></script>
						<script src=\"js/server.js\" ></script>
						<script src=\"js/Chart.js\"></script>";
			}
			else if($selected == "tablet"){
						//TODO: kivenni a style.css után a random verziószámot
						$version = rand();
				echo"	<link href=\"../js/bootstrap-3.3.7-dist/css/bootstrap.min.css\" rel=\"stylesheet\">
						<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/tabletstyles.css?v=$version\">
	  					<script src=\"../js/jquery1.9.1.js\" ></script>
						<script src=\"../js/bootbox.js\" ></script>
						<script src=\"../js/functions.js\" ></script>
						<script src=\"../js/server.js\" ></script>
						<script src=\"../js/Chart.js\"></script>
						<script src=\"../js/tablet.js\"></script>";
			}
		?>
				
	</head>
	<body class="admin">
		<?php 
			if($selected == "admin")
				require("adminnavbar.php");
			else
				require("navbar.php");
		?>
