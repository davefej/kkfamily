
<html>
	<head>
		<title>admin</title>
		<meta http-equiv="cache-control" content="max-age=0" />
  	<meta http-equiv="cache-control" content="no-cache" />
  	<meta http-equiv="expires" content="0" />
  	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  	<meta http-equiv="pragma" content="no-cache" />
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		
		
		<script src="js/jquery1.9.1.js" ></script>
		<script src="js/bootbox.js" ></script>
		 <script src="js/bootstrap.js"></script>
		 <script src="js/functions.js" ></script>
		<script src="js/server.js" ></script>		
	</head>
	<body class="admin">
		<header class="header" id="indexheader" >
			<div class="headerspancontainer">
				<div class="headerspan"><a <?php if($selected =="index"){echo "class='selheader'";}?>  href="index.php">Kezdőlap</a></div>
				<div class="headerspan"><a <?php if($selected =="raktar"){echo "class='selheader'";}?>  href="raktar.php">Raklapok</a></div>
				<div class="headerspan"><a <?php if($selected =="alapanyag"){echo "class='selheader'";}?>  href="alapanyag.php">Alapanyagok</a></div>
				<div class="headerspan"><a <?php if($selected =="beszallito"){echo "class='selheader'";}?>  href="beszallito.php">Beszállítók</a></div>
				
				<img class="logo"  src="img/logo.png"/>
				
			</div>
		
		
		</header>
