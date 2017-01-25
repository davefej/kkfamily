
<html>
	<head>
		<?php
		$version = rand();
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
		
		<link href="../js/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/styles.css?v=<?php echo $version;?>">
		<script src="../js/bootbox.js" ></script>
		<script src="../js/functions.js" ></script>
		<script src="../js/server.js" ></script>
		<script src="../js/Chart.js"></script>
		
	<?php  if($selected == "tablet"){	//TODO css rand		?>							
				
				<script src="../js/tablet.js"></script>
	<?php } ?>
				
	</head>
	<body class="admin">
		<?php 
			require('../helper/contentgenerator.php');
			
			if($selected == "admin")
				require("../common/adminnavbar.php");
			else
				require("../common/tabletnavbar.php");
		?>
