
<?php
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>kkfamily admin</title>
		<meta charset="UTF-8">
		<link href="js/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Overpass+Mono:700" rel="stylesheet">	
	</head>
	<body style="text-align:center;background-color:#00767F;color:white;">
		<!-- CSS-be átírni!! -->
		<h2></h2>
		
		
		<div class="container">
			<div class="row">
    			<div class="span2 well col-lg-5"  style="float: none; margin: 0 auto;">
    				<legend>Lejárt az idő, kérjük jelentkezzen be újra <a href="index.html">Log in!</a></legend>
					
				</div>
			</div>                
		</div>
		
		<footer class="footer navbar-fixed-bottom">
            <div class="container text-center">
                <p style="font-color: white;">made by <b>David Varga</b> &amp; <b>David Szanto</b> | Bootstrap 3</p>
            </div>
        </footer>
 
 		<!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	    <script src="js/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	</body>
</html>
