<html>
	<head>
		<?php
		
		$bool = session_start();
		//echo $bool ? 'true' : 'false';
		if(!isset($_SESSION["user_id"])){
			header('Location: ../timeout.php');
		}
		if(isset($_SESSION["user_id"])){
			//echo "USERSESISOn ".strval(isset($_SESSION["user_id"]))." ".$_SESSION["user_id"];
		}else{
			echo "USERSESSION HIBA, NOT SET ";
		}
		$version = rand();
			if($selected == "admin")
				echo "<title> Kezelőfelület | KK Family</title>";
			else if($selector == "kiadas")
				echo "<title> Kiadás | KK Family</title>";
			else if($selector == "bevetel")
				echo "<title> Bevétel | KK Family</title>";
			else if($selector == "spare")
				echo "<title> Selejtezés | KK Family</title>";
		?>
		<meta http-equiv="cache-control" content="max-age=0" />
	  	<meta http-equiv="cache-control" content="no-cache" />
	  	<meta http-equiv="expires" content="0" />
	  	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	  	<meta http-equiv="pragma" content="no-cache" />
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		
		<script src="../js/print.min.js" type="text/javascript" ></script>
		<script src="../js/functions.js?v=30" ></script>
		<script src="../js/server.js?v=30" ></script>
		<script src="../js/Chart.js"></script>
		<script src="../js/sorttable.js"></script>

		
	<?php  if($selected == "tablet"){	//TODO css rand		?>							
				<link href="../js/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
				<script src="../js/tablet.js?v=30"></script>
				<link rel="stylesheet" type="text/css" href="../css/tabletstyles.css?v=3">
	<?php }else{ ?>
				
				<link rel="stylesheet" type="text/css" href="../css/print.min.css">
				<link href="../js/bootstrap-3.3.7-dist/css/bootstrap.css?v=2" rel="stylesheet">
				<link rel="stylesheet" type="text/css" href="../css/styles.css?v=5">
	<?php } ?>
<?php 		
	if(isset($_SESSION['theme']) && $_SESSION['theme'] != "0"){	
		echo '<link rel="stylesheet" type="text/css" href="../css/theme'.$_SESSION['theme'].'.css?v=1">';
	}
?>
				
	</head>
	<body class="admin">
		<?php 
			require('../helper/contentgenerator.php');
			
			if($selected == "admin")
				require("../common/adminnavbar.php");
			else
				require("../common/tabletnavbar.php");
		?>
